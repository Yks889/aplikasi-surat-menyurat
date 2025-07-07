<?php

namespace App\Models;

use CodeIgniter\Model;

class TandaTanganModel extends Model
{
    protected $table = 'tanda_tangan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'file', 'uploaded_at'];

    public function getTandaTanganByUser($userId)
    {
        return $this->where('user_id', $userId)->first();
    }

    public function getAllTandaTangan()
    {
        return $this->select('tanda_tangan.*, users.full_name')
            ->join('users', 'users.id = tanda_tangan.user_id')
            ->findAll();
    }
}