<?php

namespace App\Controllers;

use App\Models\ProfesionalModel;

class AuthController extends BaseController
{
    /**
     * Muestra el formulario de login.
     */
    public function login()
    {
        // Si ya hay un barbero logueado, va directo a su lista de turnos.
        if (session()->get('profesional_id')) {
            return redirect()->to('/turnos');
        }

        return view('login');
    }

    /**
     * Procesa el login de un barbero.
     */
    public function procesarLogin()
    {
        $email    = trim($this->request->getPost('email'));
        $password = (string) $this->request->getPost('password');

        if ($email === '' || $password === '') {
            return redirect()->back()->withInput()->with('error', 'Ingresá tu email y contraseña.');
        }

        $profesional = (new ProfesionalModel())->findByLogin($email);

        if ($profesional === null || !password_verify($password, $profesional['password'])) {
            return redirect()->back()->withInput()->with('error', 'Credenciales inválidas.');
        }

        session()->set([
            'profesional_id' => $profesional['id'],
            'profesional_nombre' => $profesional['nombre'],
            'profesional_email'  => $profesional['email'],
        ]);

        return redirect()->to('/turnos')->with('mensaje', 'Bienvenido, ' . $profesional['nombre'] . '!');
    }

    /**
     * Cierra la sesión del barbero.
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/inicio');
    }
}
