<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\PengajuanSuratKeluarModel;

class HistoryPengajuan extends BaseController
{
    protected $pengajuanModel;

    public function __construct()
    {
        $this->pengajuanModel = new PengajuanSuratKeluarModel();
    }

    public function index()
    {
        $user = session()->get('user');

        if (!$user) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        // Ambil semua pengajuan milik user
        $pengajuanAll = $this->pengajuanModel
            ->where('dari', $user['full_name'])
            ->orderBy('created_at', 'DESC')
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
        $deskripsi= $this->request->getPost('deskripsi');

        // Validasi sederhana
        if (!$judul || !$deskripsi) {
            return redirect()->back()->withInput()->with('error', 'Judul dan Deskripsi wajib diisi.');
        }

        $this->pengajuanModel->insert([
            'judul' => $judul,
            'deskripsi' => $deskripsi,
            'dari' => $user['full_name'],
            'kepada' => 'Admin', // Default
            'status' => 'belum',  // Default
            'surat_masuk_id' => null
        ]);

        return redirect()->to('/user/history-pengajuan')->with('message', 'Pengajuan surat keluar berhasil dikirim.');
    }

    public function detail($id)
    {
        $user = session()->get('user');

        if (!$user) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $pengajuan = $this->pengajuanModel
            ->where('id', $id)
            ->where('dari', $user['full_name'])
            ->first();

        if (!$pengajuan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Pengajuan tidak ditemukan.");
        }

        return view('user/pengajuan/detail', [
            'pengajuan' => $pengajuan
        ]);
    }
}
