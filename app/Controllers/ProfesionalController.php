<?php

namespace App\Controllers;

use App\Models\ProfesionalModel;

class ProfesionalController extends BaseController
{
    /**
     * Muestra la información del barbero logueado.
     */
    public function miCuenta()
    {
        $profesionalId = (int) session()->get('profesional_id');

        if ($profesionalId <= 0) {
            return redirect()->to('/login');
        }

        $profesional = (new ProfesionalModel())->find($profesionalId);

        if ($profesional === null) {
            session()->destroy();
            return redirect()->to('/login')->with('error', 'La sesión expiró.');
        }

        return view('mi_cuenta', ['profesional' => $profesional]);
    }

    /**
     * Actualiza los datos del barbero logueado.
     */
    public function actualizarMiCuenta()
    {
        $profesionalId = (int) session()->get('profesional_id');

        if ($profesionalId <= 0) {
            return redirect()->to('/login');
        }

        $model = new ProfesionalModel();
        $profesional = $model->find($profesionalId);

        if ($profesional === null) {
            session()->destroy();
            return redirect()->to('/login')->with('error', 'La sesión expiró.');
        }

        $nombre     = trim((string) $this->request->getPost('nombre'));
        $especialidad = trim((string) $this->request->getPost('especialidad'));
        $email      = trim((string) $this->request->getPost('email'));
        $telefono   = trim((string) $this->request->getPost('telefono'));
        $password   = (string) $this->request->getPost('password');
        $password2  = (string) $this->request->getPost('password_confirm');

        // Validaciones
        if ($nombre === '' || $especialidad === '' || $email === '') {
            return redirect()->back()->withInput()->with('error', 'Nombre, especialidad y email son obligatorios.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->withInput()->with('error', 'El email no es válido.');
        }

        if ($password !== '' && $password !== $password2) {
            return redirect()->back()->withInput()->with('error', 'Las contraseñas no coinciden.');
        }

        // El email no debe estar en uso por otro profesional
        $existe = $model->where('email', $email)->where('id !=', $profesionalId)->first();
        if ($existe !== null) {
            return redirect()->back()->withInput()->with('error', 'Ese email ya está registrado por otro barbero.');
        }

        $datos = [
            'nombre'       => $nombre,
            'especialidad' => $especialidad,
            'email'        => $email,
            'telefono'     => $telefono ?: null,
        ];

        if ($password !== '') {
            $datos['password'] = $password;
        }

        if (!$model->update($profesionalId, $datos)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $model->errors()));
        }

        // Refrescar datos de sesión
        session()->set([
            'profesional_nombre' => $nombre,
            'profesional_email'  => $email,
        ]);

        return redirect()->to('/mi-cuenta')->with('mensaje', 'Tus datos fueron actualizados correctamente.');
    }
}
