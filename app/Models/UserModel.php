<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password', 'role', 'full_name', 'email', 'photo'];
    protected $returnType = 'array';

    // Otomatis timestamp
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Aktifkan event untuk hashing password
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    // Hash password sebelum insert/update
    protected function hashPassword(array $data)
    {
        if (!empty($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }

    // Ambil user berdasarkan username
    public function getUserByUsername($username)
    {
        return $this->asArray()
                    ->where('username', $username)
                    ->first();
    }

    // Ambil semua user, bisa filter by role
    public function getAllUsers($role = null)
    {
        if ($role) {
            return $this->asArray()
                        ->where('role', $role)
                        ->findAll();
        }
        return $this->asArray()->findAll();
    }
}
