<?php

namespace App\Models;

use CodeIgniter\Model;

class PerusahaanModel extends Model
{
    protected $table = 'perusahaan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama', 'singkatan'];

    public function getAllPerusahaan()
    {
        return $this->findAll();
    }
}