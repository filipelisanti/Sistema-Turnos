<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTurnosTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'auto_increment' => true],
            'usuario_id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true],
            'profesional_id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true],
            'fecha' => ['type' => 'DATE'],
            'hora_inicio' => ['type' => 'TIME'],
            'hora_fin' => ['type' => 'TIME'],
            'estado' => [
                'type' => 'ENUM',
                'constraint' => ['pendiente', 'confirmado', 'cancelado', 'completado'],
                'default' => 'pendiente',
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('usuario_id', 'usuarios', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('profesional_id', 'profesionales', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('turnos');
    }

    public function down()
    {
        $this->forge->dropTable('turnos');
    }
}