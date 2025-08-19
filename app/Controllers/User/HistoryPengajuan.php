<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\PengajuanSuratKeluarModel;
use App\Models\UserModel; // tambahkan
use Config\Services;

class HistoryPengajuan extends BaseController
{
    protected $pengajuanModel;
    protected $userModel;
    protected $helpers = ['activity'];

    public function __construct()
    {
        $this->pengajuanModel = new PengajuanSuratKeluarModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $user = session()->get('user');
        if (!$user) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $pengajuanAll = $this->pengajuanModel
            ->select('pengajuan_surat_keluar.*, users.full_name, surat_masuk.nomor_surat, surat_masuk.dari AS dari_surat_masuk, surat_masuk.perihal, surat_masuk.tgl_surat, surat_masuk.waktu_diterima, surat_masuk.file_surat')
            ->join('users', 'users.id = pengajuan_surat_keluar.user_id')
            ->join('surat_masuk', 'surat_masuk.id = pengajuan_surat_keluar.surat_masuk_id', 'left')
            ->where('pengajuan_surat_keluar.user_id', $user['id'])
            ->orderBy('pengajuan_surat_keluar.created_at', 'DESC')
            ->findAll();

        return view('user/pengajuan/index', [
            'pengajuanSuratKeluar' => $pengajuanAll
        ]);
    }

    public function create()
    {
        return view('user/pengajuan/create');
    }

    public function store()
    {
        $user = session()->get('user');
        if (!$user) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $judul = $this->request->getPost('judul');
        $deskripsi = $this->request->getPost('deskripsi');

        if (!$judul || !$deskripsi) {
            return redirect()->back()->withInput()->with('error', 'Judul dan Deskripsi wajib diisi.');
        }

        $this->pengajuanModel->insert([
            'judul' => $judul,
            'deskripsi' => $deskripsi,
            'user_id' => $user['id'], // pakai id user
            'dari'           => $user['full_name'],
            'kepada' => 'Admin',
            'status' => 'belum',
            'surat_masuk_id' => null
        ]);

        activity_log(
            $user['id'],
            'Membuat Pengajuan Baru',
            "Membuat pengajuan baru dengan judul: $judul",
            'pengajuan'
        );

        return redirect()->to('/user/history-pengajuan')->with('message', 'Pengajuan surat keluar berhasil dikirim.');
    }

    public function detail($id)
    {
        $user = session()->get('user');
        if (!$user) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $pengajuan = $this->pengajuanModel
            ->select('pengajuan_surat_keluar.*, users.full_name, surat_masuk.nomor_surat, surat_masuk.dari AS dari_surat_masuk, surat_masuk.perihal, surat_masuk.tgl_surat, surat_masuk.waktu_diterima, surat_masuk.file_surat')
            ->join('users', 'users.id = pengajuan_surat_keluar.user_id')
            ->join('surat_masuk', 'surat_masuk.id = pengajuan_surat_keluar.surat_masuk_id', 'left')
            ->where('pengajuan_surat_keluar.id', $id)
            ->where('pengajuan_surat_keluar.user_id', $user['id']) // filter by user_id
            ->first();

        if (!$pengajuan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Pengajuan tidak ditemukan.");
        }

        $pengajuanForms = $this->pengajuanModel
            ->where('surat_masuk_id', $pengajuan['surat_masuk_id'])
            ->where('user_id', $user['id'])
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('user/pengajuan/detail', [
            'pengajuan' => $pengajuan,
            'pengajuanForms' => $pengajuanForms
        ]);
    }
}
