<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\ProfesionalModel;

class BarberoPruebaSeeder extends Seeder
{
    public function run()
    {
        $model = new ProfesionalModel();

        $data = [
            'nombre'       => 'Carlos Barber',
            'especialidad' => 'Corte clásico y barba',
            'email'        => 'barbero@cortetop.com',
            'password'     => 'barbero123',
            'telefono'     => '11 5555-1234',
        ];

        $model->insert($data);
        echo "Barbero de prueba creado con email barbero@cortetop.com y contraseña barbero123.\n";
    }
}
