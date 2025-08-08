<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PengajuanSuratKeluarModel;
use App\Models\UserModel;

class AjukanSurat extends BaseController
{
    protected $pengajuanSuratKeluarModel;
    protected $userModel;

    public function __construct()
    {
        $this->pengajuanSuratKeluarModel = new PengajuanSuratKeluarModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $pengajuanSuratKeluar = $this->pengajuanSuratKeluarModel
            ->select('pengajuan_surat_keluar.*, surat_masuk.nomor_surat, surat_masuk.dari AS dari_surat_masuk, surat_masuk.perihal, surat_masuk.tgl_surat, surat_masuk.waktu_diterima, surat_masuk.file_surat')
            ->join('surat_masuk', 'surat_masuk.id = pengajuan_surat_keluar.surat_masuk_id', 'left')
            ->orderBy('pengajuan_surat_keluar.created_at', 'DESC')
            ->findAll();

        return view('admin/ajukan/index.php', [
            'pengajuanSuratKeluar' => $pengajuanSuratKeluar
        ]);
    }

    public function terima($id)
    {
        $this->pengajuanSuratKeluarModel->update($id, ['status' => 'diterima']);
        return redirect()->back()->with('message', 'Pengajuan berhasil diterima.');
    }

    public function tolak($id)
    {
        $this->pengajuanSuratKeluarModel->update($id, ['status' => 'ditolak']);
        return redirect()->back()->with('message', 'Pengajuan ditolak.');
    }
    public function detail($id)
    {
        $pengajuan = $this->pengajuanSuratKeluarModel
            ->select('pengajuan_surat_keluar.*, surat_masuk.nomor_surat, surat_masuk.dari AS dari_surat_masuk, surat_masuk.perihal, surat_masuk.tgl_surat, surat_masuk.waktu_diterima, surat_masuk.file_surat')
            ->join('surat_masuk', 'surat_masuk.id = pengajuan_surat_keluar.surat_masuk_id', 'left')
            ->find($id);

        if (!$pengajuan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Pengajuan dengan ID $id tidak ditemukan.");
        }

        $pengajuanForms = $this->pengajuanSuratKeluarModel
            ->where('surat_masuk_id', $pengajuan['surat_masuk_id'])
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('admin/ajukan/detail', [
            'pengajuan' => $pengajuan,
            'pengajuanForms' => $pengajuanForms
        ]);
    }
    
}
