<?php

namespace App\Models;

use CodeIgniter\Model;

class ProfesionalModel extends Model
{
    protected $table            = 'profesionales';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nombre', 'especialidad'];

    protected $useTimestamps    = true;
    protected $dateFormat       = 'datetime';

    protected $validationRules  = [
        'nombre'       => 'required|min_length[3]|max_length[100]',
        'especialidad' => 'required|max_length[100]',
    ];
}