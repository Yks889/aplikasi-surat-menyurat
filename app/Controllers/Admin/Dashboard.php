<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SuratMasukModel;
use App\Models\SuratKeluarModel;
use App\Models\UserModel;
use App\Models\PerusahaanModel;

class Dashboard extends BaseController
{
    protected $suratMasukModel;
    protected $suratKeluarModel;
    protected $userModel;
    protected $perusahaanModel;

    public function __construct()
    {
        $this->suratMasukModel = new SuratMasukModel();
        $this->suratKeluarModel = new SuratKeluarModel();
        $this->userModel = new UserModel();
        $this->perusahaanModel = new PerusahaanModel();
    }

    public function index()
    {
        $bulan = $this->request->getGet('bulan') ?? date('n'); // bulan sekarang (1-12)
        $tahun = $this->request->getGet('tahun') ?? date('Y'); // tahun sekarang

        // Filter berdasarkan bulan dan tahun untuk surat masuk
        $filteredSuratMasuk = $this->suratMasukModel
            ->where('MONTH(tgl_surat)', $bulan)
            ->where('YEAR(tgl_surat)', $tahun);

        // Filter surat keluar
        $filteredSuratKeluar = $this->suratKeluarModel
            ->where('MONTH(tanggal_surat)', $bulan)
            ->where('YEAR(tanggal_surat)', $tahun);

        $data = [
            'title' => 'Dashboard Admin',
            'bulan' => (int)$bulan,
            'tahun' => (int)$tahun,
            'totalSuratMasuk' => $filteredSuratMasuk->countAllResults(false),
            'totalSuratKeluar' => $filteredSuratKeluar->countAllResults(false),
            'recentSuratMasuk' => $filteredSuratMasuk->orderBy('tgl_surat', 'DESC')->findAll(5),
            'recentSuratKeluar' => $filteredSuratKeluar->orderBy('tanggal_surat', 'DESC')->findAll(5),
        ];

        return view('admin/dashboard', $data);
    }
}
