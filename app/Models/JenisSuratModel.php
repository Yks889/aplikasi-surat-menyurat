<?php

namespace App\Models;

use CodeIgniter\Model;

class JenisSuratModel extends Model
{
    protected $table            = 'jenis_surat';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nama', 'singkatan'];
    protected $useTimestamps    = false; // ubah jadi true jika tabel punya kolom created_at/updated_at
}
