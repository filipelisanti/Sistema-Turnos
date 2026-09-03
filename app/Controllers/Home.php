<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }

    public function inicio(): string
    {
        return view('inicio');
    }

    public function quienes_somos(): string
    {
        return view('quienes_somos');
    }
}
