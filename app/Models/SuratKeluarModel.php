<?php

namespace App\Models;

use CodeIgniter\Model;

class SuratKeluarModel extends Model
{
    protected $table = 'surat_keluar';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'kode_surat',
        'nomor_surat',
        'untuk',
        'perusahaan_id',
        'tanggal_surat',
        'perihal',
        'penandatangan_id',
        'file_surat',
        'created_by'
    ];

    /**
     * Ambil semua surat keluar beserta relasinya: perusahaan, jenis surat, penandatangan.
     */
    public function getSuratKeluarWithRelations()
    {
        return $this->select('
                surat_keluar.*, 
                perusahaan.nama AS perusahaan, 
                perusahaan.singkatan AS perusahaan_singkatan,
                jenis_surat.nama AS jenis_surat_nama,
                jenis_surat.singkatan AS jenis_surat_singkatan,
                users.full_name AS penandatangan
            ')
            ->join('perusahaan', 'perusahaan.id = surat_keluar.perusahaan_id')
            ->join('users', 'users.id = surat_keluar.penandatangan_id')
            ->join('jenis_surat', 'jenis_surat.id = surat_keluar.kode_surat', 'left')
            ->orderBy('tanggal_surat', 'DESC')
            ->findAll();
    }

    /**
     * Ambil surat keluar berdasarkan penandatangan tertentu.
     */
    public function getSuratKeluarByPenandatangan($userId)
    {
        return $this->select('
                surat_keluar.*, 
                perusahaan.nama AS perusahaan, 
                users.full_name AS penandatangan,
                jenis_surat.nama AS jenis_surat_nama
            ')
            ->join('perusahaan', 'perusahaan.id = surat_keluar.perusahaan_id')
            ->join('users', 'users.id = surat_keluar.penandatangan_id')
            ->join('jenis_surat', 'jenis_surat.id = surat_keluar.kode_surat', 'left')
            ->where('penandatangan_id', $userId)
            ->orderBy('tanggal_surat', 'DESC')
            ->findAll();
    }

    /**
     * Ambil jumlah surat keluar pada bulan dan tahun tertentu (untuk penomoran).
     */
    public function getLastNumberThisMonth($bulan, $tahun)
    {
        return $this->where('MONTH(tanggal_surat)', $bulan)
                    ->where('YEAR(tanggal_surat)', $tahun)
                    ->countAllResults();
    }
}
