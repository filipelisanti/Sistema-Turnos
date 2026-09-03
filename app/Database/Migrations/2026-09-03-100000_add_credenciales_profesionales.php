<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCredencialesProfesionales extends Migration
{
    public function up()
    {
        $this->forge->addColumn('profesionales', [
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'especialidad',
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'email',
            ],
            'telefono' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'after'      => 'password',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('profesionales', ['email', 'password', 'telefono']);
    }
}
