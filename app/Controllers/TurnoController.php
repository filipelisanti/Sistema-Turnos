<?php

namespace App\Controllers;

use App\Models\TurnoModel;
use App\Models\ProfesionalModel;
use App\Services\TurnoService;
use RuntimeException;

class TurnoController extends BaseController
{
    protected TurnoModel $turnoModel;
    protected TurnoService $turnoService;

    public function __construct()
    {
        $this->turnoModel   = new TurnoModel();
        $this->turnoService = new TurnoService();
    }

    /**
     * Lista los turnos del barbero logueado.
     */
    public function index()
    {
        $profesionalId = (int) session()->get('profesional_id');

        if ($profesionalId <= 0) {
            return redirect()->to('/login');
        }

        $data['turnos'] = $this->turnoModel
            ->select('turnos.*, u.nombre as usuario_nombre, p.nombre as profesional_nombre')
            ->join('usuarios u', 'u.id = turnos.usuario_id')
            ->join('profesionales p', 'p.id = turnos.profesional_id')
            ->where('turnos.profesional_id', $profesionalId)
            ->orderBy('turnos.fecha', 'ASC')
            ->orderBy('turnos.hora_inicio', 'ASC')
            ->findAll();

        return view('turnos/index', $data);
    }

    /**
     * Muestra el formulario para crear un turno.
     */
    public function new()
    {
        $data['profesionales'] = (new ProfesionalModel())->findAll();

        $fecha = $this->request->getGet('fecha') ?: date('Y-m-d');
        $profesionalId = (int) $this->request->getGet('profesional_id');

        $builder = $this->turnoModel
            ->select('hora_inicio')
            ->where('fecha', $fecha)
            ->whereIn('estado', ['pendiente', 'confirmado']);

        if ($profesionalId > 0) {
            $builder->where('profesional_id', $profesionalId);
        }

        $data['fechaSeleccionada']      = $fecha;
        $data['profesionalSeleccionado'] = $profesionalId;
        $data['horasOcupadas'] = array_map(
            fn ($t) => substr($t['hora_inicio'], 0, 5),
            $builder->findAll()
        );

        return view('turnos/create', $data);
    }

    /**
     * Procesa el alta de un turno.
     */
    public function create()
    {
        $datos = $this->request->getPost(['nombre', 'email', 'telefono', 'profesional_id', 'fecha', 'hora_inicio', 'hora_fin']);

        try {
            $id = $this->turnoService->crearTurno($datos);
            return redirect()->to("/turnos/$id")->with('mensaje', "Turno #$id creado correctamente.");
        } catch (RuntimeException $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Eliminar un turno.
     */
    public function delete(int $id)
    {
        $turno = $this->turnoPropio($id);
        if ($turno === 'redirect') {
            return redirect()->to('/login');
        }
        if ($turno === null) {
            return redirect()->back()->with('error', 'El turno no existe.');
        }

        if ($this->turnoModel->delete($id)) {
            return redirect()->to('/turnos')->with('mensaje', 'Turno eliminado correctamente.');
        }

        return redirect()->back()->with('error', 'No se pudo eliminar el turno.');
    }


    /**
     * Muestra el detalle de un turno.
     */
    public function show(int $id)
    {
        $turno = $this->turnoPropio($id);

        if ($turno === 'redirect') {
            return redirect()->to('/login');
        }

        if ($turno === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('turnos/show', ['turno' => $turno]);
    }

    /**
     * Cancela un turno.
     */
    public function cancelar(int $id)
    {
        $turno = $this->turnoPropio($id);
        if ($turno === 'redirect') {
            return redirect()->to('/login');
        }
        if ($turno === null) {
            return redirect()->back()->with('error', 'El turno no existe.');
        }

        try {
            $this->turnoService->cancelarTurno($id);
            return redirect()->to('/turnos')->with('mensaje', 'Turno cancelado.');
        } catch (RuntimeException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Confirma un turno pendiente.
     */
    public function confirmar(int $id)
    {
        $turno = $this->turnoPropio($id);
        if ($turno === 'redirect') {
            return redirect()->to('/login');
        }
        if ($turno === null) {
            return redirect()->back()->with('error', 'El turno no existe.');
        }

        try {
            $this->turnoService->confirmarTurno($id);
            return redirect()->to('/turnos')->with('mensaje', 'Turno confirmado.');
        } catch (RuntimeException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Marca un turno como completado.
     */
    public function completar(int $id)
    {
        $turno = $this->turnoPropio($id);
        if ($turno === 'redirect') {
            return redirect()->to('/login');
        }
        if ($turno === null) {
            return redirect()->back()->with('error', 'El turno no existe.');
        }

        try {
            $this->turnoService->completarTurno($id);
            return redirect()->to('/turnos')->with('mensaje', 'Turno completado.');
        } catch (RuntimeException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Devuelve el turno si existe y pertenece al barbero logueado.
     * Devuelve la cadena 'redirect' si no hay sesión, o null si no aplica.
     */
    private function turnoPropio(int $id)
    {
        $profesionalId = (int) session()->get('profesional_id');

        if ($profesionalId <= 0) {
            return 'redirect';
        }

        $turno = $this->turnoModel
            ->select('turnos.*, u.nombre as usuario_nombre, p.nombre as profesional_nombre')
            ->join('usuarios u', 'u.id = turnos.usuario_id')
            ->join('profesionales p', 'p.id = turnos.profesional_id')
            ->where('turnos.id', $id)
            ->where('turnos.profesional_id', $profesionalId)
            ->first();

        return $turno ?: null;
    }
}