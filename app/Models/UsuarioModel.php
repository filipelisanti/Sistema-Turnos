<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table            = 'usuarios';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nombre', 'email', 'telefono', 'password', 'rol'];

    protected $useTimestamps    = true;
    protected $dateFormat       = 'datetime';

    protected $validationRules  = [
        'nombre'  => 'required|min_length[3]|max_length[100]',
        'email'   => 'required|valid_email|is_unique[usuarios.email]',
        'telefono' => 'permit_empty|max_length[20]',
    ];
}