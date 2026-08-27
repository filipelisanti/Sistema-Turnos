<?php

namespace App\Services;

use App\Models\TurnoModel;
use App\Models\UsuarioModel;
use RuntimeException;

class TurnoService
{
    protected TurnoModel $turnoModel;

    // Reglas de negocio configurables
    protected int $anticipacionMinimaHoras = 1;      // no sacar turno para "ya mismo"
    protected int $antelacionCancelacionHoras = 2;    // no cancelar si falta menos de esto

    public function __construct()
    {
        $this->turnoModel = new TurnoModel();
    }

    /**
     * Crea un turno validando reglas de negocio.
     * Devuelve el ID del turno creado.
     * Lanza RuntimeException si alguna regla falla.
     */
    public function crearTurno(array $datos): int
    {
        $fecha       = $datos['fecha'];
        $horaInicio  = $datos['hora_inicio'];
        $horaFin     = $datos['hora_fin'];
        $profesionalId = (int) $datos['profesional_id'];

        // Regla 1: no permitir fecha/hora en el pasado o muy próxima
        $inicioDatetime = new \DateTime("$fecha $horaInicio");
        $ahoraMasMargen = (new \DateTime())->modify("+{$this->anticipacionMinimaHoras} hours");

        if ($inicioDatetime < $ahoraMasMargen) {
            throw new RuntimeException('El turno debe solicitarse con al menos ' . $this->anticipacionMinimaHoras . ' hora(s) de anticipación.');
        }

        // Regla 2: hora_fin tiene que ser posterior a hora_inicio
        
        if ($horaFin <= $horaInicio) {
            throw new RuntimeException('La hora de fin debe ser posterior a la hora de inicio.');
        }

        // Regla 3: no solapamiento
        if ($this->turnoModel->existeSolapamiento($profesionalId, $fecha, $horaInicio, $horaFin)) {
            throw new RuntimeException('El profesional ya tiene un turno en ese horario.');
        }
        
        // Crear (o reutilizar) el usuario del turno
        $usuarioId = $this->crearOReutilizarUsuario($datos);

        $datos['usuario_id'] = $usuarioId;
        $datos['estado']     = 'pendiente';

        $id = $this->turnoModel->insert($datos);

        if ($id === false) {
            // insert() devuelve false si falló la validación del Model
            throw new RuntimeException(implode(' ', $this->turnoModel->errors()));
        }

        return $id;
    }

    /**
     * Crea un usuario con los datos del formulario o, si ya existe
     * el email, devuelve el ID existente.
     */
    protected function crearOReutilizarUsuario(array $datos): int
    {
        $usuarioModel = new UsuarioModel();

        $email = $datos['email'];
        $existente = $usuarioModel->where('email', $email)->first();

        if ($existente !== null) {
            return (int) $existente['id'];
        }

        $usuarioId = $usuarioModel->insert([
            'nombre'  => $datos['nombre'],
            'email'   => $email,
            'telefono' => $datos['telefono'] ?? null,
            'rol'     => 'cliente',
        ]);

        if ($usuarioId === false) {
            throw new RuntimeException(implode(' ', $usuarioModel->errors()));
        }

        return (int) $usuarioId;
    }

    /**
     * Cancela un turno respetando la antelación mínima y las transiciones válidas.
     */
    public function cancelarTurno(int $turnoId): bool
    {
        $turno = $this->turnoModel->find($turnoId);

        if ($turno === null) {
            throw new RuntimeException('El turno no existe.');
        }

        if (!$this->esTransicionValida($turno['estado'], 'cancelado')) {
            throw new RuntimeException("No se puede cancelar un turno en estado '{$turno['estado']}'.");
        }

        $inicioDatetime = new \DateTime("{$turno['fecha']} {$turno['hora_inicio']}");
        $limiteCancelacion = (new \DateTime())->modify("+{$this->antelacionCancelacionHoras} hours");

        if ($inicioDatetime < $limiteCancelacion) {
            throw new RuntimeException('No se puede cancelar con menos de ' . $this->antelacionCancelacionHoras . ' hora(s) de antelación.');
        }

        return $this->turnoModel->update($turnoId, ['estado' => 'cancelado']);
    }

    /**
     * Confirma un turno pendiente.
     */
    public function confirmarTurno(int $turnoId): bool
    {
        $turno = $this->turnoModel->find($turnoId);

        if ($turno === null) {
            throw new RuntimeException('El turno no existe.');
        }

        if (!$this->esTransicionValida($turno['estado'], 'confirmado')) {
            throw new RuntimeException("No se puede confirmar un turno en estado '{$turno['estado']}'.");
        }

        return $this->turnoModel->update($turnoId, ['estado' => 'confirmado']);
    }

    /**
     * Marca un turno como completado.
     */
    public function completarTurno(int $turnoId): bool
    {
        $turno = $this->turnoModel->find($turnoId);

        if ($turno === null) {
            throw new RuntimeException('El turno no existe.');
        }

        if (!$this->esTransicionValida($turno['estado'], 'completado')) {
            throw new RuntimeException("No se puede completar un turno en estado '{$turno['estado']}'.");
        }

        return $this->turnoModel->update($turnoId, ['estado' => 'completado']);
    }

    /**
     * Define el mapa de transiciones válidas entre estados.
     */
    protected function esTransicionValida(string $estadoActual, string $estadoNuevo): bool
    {
        $transicionesValidas = [
            'pendiente'   => ['confirmado', 'cancelado'],
            'confirmado'  => ['completado', 'cancelado'],
            'cancelado'   => [],   // estado final
            'completado'  => [],   // estado final
        ];

        return in_array($estadoNuevo, $transicionesValidas[$estadoActual] ?? [], true);
    }
}