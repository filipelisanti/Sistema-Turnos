<?php

namespace App\Controllers;


class TestController extends BaseController
{

    public function insertar()
    {

        $model = new \App\Models\ProfesionalModel();
        $model->insert([
            'nombre' => 'Matias Calvo',
            'especialidad' => 'Barbero',
        ]);

        echo 'Insertado con éxito, ID: ' . $model->getInsertID();
    }

}


