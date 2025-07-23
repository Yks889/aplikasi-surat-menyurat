<?php

namespace App\Controllers\Operator;

use App\Controllers\BaseController;
use App\Models\SuratMasukModel;
use App\Models\SuratKeluarModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    protected $suratMasukModel;
    protected $suratKeluarModel;
    protected $userModel;

    public function __construct()
    {
        $this->suratMasukModel = new SuratMasukModel();
        $this->suratKeluarModel = new SuratKeluarModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Ambil bulan & tahun dari query string
        $bulan = $this->request->getGet('bulan') ?? date('m');
        $tahun = $this->request->getGet('tahun') ?? date('Y');

        // Konversi ke integer
        $bulan = (int)$bulan;
        $tahun = (int)$tahun;

        // Total surat masuk berdasarkan bulan/tahun
        $totalSuratMasuk = $this->suratMasukModel
            ->where('MONTH(tgl_surat)', $bulan)
            ->where('YEAR(tgl_surat)', $tahun)
            ->countAllResults();

        $totalSuratKeluar = $this->suratKeluarModel
            ->where('MONTH(tanggal_surat)', $bulan)
            ->where('YEAR(tanggal_surat)', $tahun)
            ->countAllResults();

        // Data surat masuk dan keluar terbaru (limit 5)
        $recentSuratMasuk = $this->suratMasukModel
            ->where('MONTH(tgl_surat)', $bulan)
            ->where('YEAR(tgl_surat)', $tahun)
            ->orderBy('waktu_diterima', 'DESC')
            ->findAll(5);

        $recentSuratKeluar = $this->suratKeluarModel
            ->where('MONTH(tanggal_surat)', $bulan)
            ->where('YEAR(tanggal_surat)', $tahun)
            ->orderBy('tanggal_surat', 'DESC')
            ->findAll(5);

        $data = [
            'title' => 'Dashboard Operator',
            'user' => session()->get(),
            'bulan' => $bulan,
            'tahun' => $tahun,
            'totalSuratMasuk' => $totalSuratMasuk,
            'totalSuratKeluar' => $totalSuratKeluar,
            'totalUsers' => $this->userModel->where('role', 'user')->countAllResults(),
            'recentSuratMasuk' => $recentSuratMasuk,
            'recentSuratKeluar' => $recentSuratKeluar
        ];

        return view('operator/dashboard', $data);
    }
}
