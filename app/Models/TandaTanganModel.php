<?php

namespace App\Models;

use CodeIgniter\Model;

class TandaTanganModel extends Model
{
    protected $table = 'tanda_tangan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama', 'file', 'uploaded_at']; // sudah ganti user_id jadi nama

    // Ambil semua tanda tangan
    public function getAllTandaTangan()
    {
        return $this->findAll(); // tidak perlu join ke tabel users
    }
}
