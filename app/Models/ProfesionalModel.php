<?php

namespace App\Models;

use CodeIgniter\Model;

class ProfesionalModel extends Model
{
    protected $table            = 'profesionales';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nombre', 'especialidad', 'email', 'password', 'telefono'];

    protected $useTimestamps    = true;
    protected $dateFormat       = 'datetime';

    protected $validationRules  = [
        'nombre'       => 'required|min_length[3]|max_length[100]',
        'especialidad' => 'required|max_length[100]',
        'email'        => 'permit_empty|valid_email|max_length[100]',
        'telefono'     => 'permit_empty|max_length[20]',
    ];

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data): array
    {
        if (isset($data['data']['password']) && $data['data']['password'] !== '') {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['data']['password']);
        }

        return $data;
    }

    public function findByLogin(string $email): ?array
    {
        return $this->where('email', $email)->first();
    }
}