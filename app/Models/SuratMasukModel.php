<?php

namespace App\Models;

use CodeIgniter\Model;

class SuratMasukModel extends Model
{
    protected $table = 'surat_masuk';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nomor_surat',
        'perusahaan_id',
        'dari',
        'perihal',
        'file_surat',
        'tgl_surat',
        'waktu_diterima',
        'created_by',
    ];

    public function getSuratMasukWithRelations()
    {
        return $this->select('surat_masuk.*, perusahaan.nama as perusahaan, users.full_name as pengirim')
            ->join('perusahaan', 'perusahaan.id = surat_masuk.perusahaan_id')
            ->join('users', 'users.id = surat_masuk.created_by')
            ->orderBy('tgl_surat', 'DESC') // Urut dari tanggal terbaru
            ->findAll();
    }

    public function getSuratMasukByUser($userId)
    {
        return $this->select('surat_masuk.*, perusahaan.nama as perusahaan')
            ->join('perusahaan', 'perusahaan.id = surat_masuk.perusahaan_id')
            ->where('created_by', $userId)
            ->orderBy('tgl_surat', 'DESC') // Bisa juga diurutkan jika perlu
            ->findAll();
    }
}
