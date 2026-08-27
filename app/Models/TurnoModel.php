<?php

namespace App\Models;

use CodeIgniter\Model;

class TurnoModel extends Model
{
    protected $table            = 'turnos';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['usuario_id', 'profesional_id', 'fecha', 'hora_inicio', 'hora_fin', 'estado'];

    protected $useTimestamps    = true;
    protected $dateFormat       = 'datetime';

    protected $validationRules  = [
        'usuario_id'      => 'required|integer',
        'profesional_id'  => 'required|integer',
        'fecha'           => 'required|valid_date',
        'hora_inicio'     => 'required',
        'hora_fin'        => 'required',
    ];

    /**
     * Busca turnos del mismo profesional que se solapen
     * con el rango horario pedido, en la misma fecha.
     * Devuelve true si hay conflicto.
     */
    public function existeSolapamiento(int $profesionalId, string $fecha, string $horaInicio, string $horaFin, ?int $excluirTurnoId = null): bool
    {
        $builder = $this->where('profesional_id', $profesionalId)
                         ->where('fecha', $fecha)
                         ->whereIn('estado', ['pendiente', 'confirmado'])
                         ->groupStart()
                             ->where('hora_inicio <', $horaFin)
                             ->where('hora_fin >', $horaInicio)
                         ->groupEnd();

        if ($excluirTurnoId !== null) {
            $builder->where('id !=', $excluirTurnoId);
        }

        return $builder->countAllResults() > 0;
    }
}