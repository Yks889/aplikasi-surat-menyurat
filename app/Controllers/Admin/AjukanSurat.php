<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PengajuanSuratKeluarModel;
use App\Models\UserModel;
use Config\Services;

class AjukanSurat extends BaseController
{
    protected $pengajuanSuratKeluarModel;
    protected $userModel;
    protected $helpers = ['activity']; // Add activity helper

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
        $userId = session()->get('user')['id'];
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $this->pengajuanSuratKeluarModel->update($id, ['status' => 'diterima']);

        // Log activity
        activity_log(
            $userId,
            'Menerima Pengajuan Surat',
            'Menerima pengajuan surat keluar dengan ID ' . $id,
            'pengajuan_surat'
        );

        return redirect()->back()->with('message', 'Pengajuan berhasil diterima.');
    }

    public function tolak($id)
    {
        $userId = session()->get('user')['id'];
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $this->pengajuanSuratKeluarModel->update($id, ['status' => 'ditolak']);

        // Log activity
        activity_log(
            $userId,
            'Menolak Pengajuan Surat',
            'Menolak pengajuan surat keluar dengan ID ' . $id,
            'pengajuan_surat'
        );

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

    public function formSurat($id)
    {
        $userId = session()->get('user')['id'];
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $pengajuanModel = new \App\Models\PengajuanSuratKeluarModel();
        $pengajuan = $pengajuanModel->find($id);

        if (!$pengajuan) {
            return redirect()->back()->with('error', 'Data pengajuan tidak ditemukan.');
        }

        // Data dropdown
        $perusahaan = (new \App\Models\PerusahaanModel())->findAll();
        $jenisSurat = (new \App\Models\JenisSuratModel())->findAll();
        $penandatangan = (new \App\Models\TandaTanganModel())->findAll();

        // Log activity
        activity_log(
            $userId,
            'Mengakses Form Surat',
            'Mengakses form surat untuk pengajuan ID ' . $id,
            'pengajuan_surat'
        );

        $data = [
            'pengajuan' => $pengajuan,
            'perusahaan' => $perusahaan,
            'jenis_surat' => $jenisSurat,
            'penandatangan' => $penandatangan,
            'validation' => Services::validation()
        ];

        return view('admin/surat_keluar/form_pengajuan', $data);
    }
}