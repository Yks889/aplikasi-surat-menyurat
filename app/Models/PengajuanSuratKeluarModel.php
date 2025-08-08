<?php

namespace App\Models;

use CodeIgniter\Model;

class PengajuanSuratKeluarModel extends Model
{
    protected $table = 'pengajuan_surat_keluar';
    protected $primaryKey = 'id';
    protected $allowedFields = ['judul', 'deskripsi', 'dari', 'kepada', 'surat_masuk_id', 'status'];
    protected $useTimestamps = true;
}
    