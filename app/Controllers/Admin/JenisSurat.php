<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\JenisSuratModel;

class JenisSurat extends BaseController
{
    protected $jenisSuratModel;
    protected $helpers = ['form', 'activity'];

    public function __construct()
    {
        $this->jenisSuratModel = new JenisSuratModel();
    }

    public function index()
    {
        $adminId = session()->get('user')['id'] ?? null;
        if (!$adminId) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $data = [
            'title' => 'Jenis Surat',
            'user' => session()->get('user'),
            'jenisSurat' => $this->jenisSuratModel->orderBy('nama', 'ASC')->findAll()
        ];

        return view('admin/jenis_surat/index', $data);
    }

    public function create()
    {
        $adminId = session()->get('user')['id'] ?? null;
        if (!$adminId) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $data = [
            'title' => 'Tambah Jenis Surat',
            'user' => session()->get('user'),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/jenis_surat/create', $data);
    }

    public function store()
    {
        $adminId = session()->get('user')['id'] ?? null;
        if (!$adminId) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $validationRules = [
            'nama' => [
                'rules' => 'required|is_unique[jenis_surat.nama]|max_length[100]',
                'errors' => [
                    'is_unique' => 'Nama jenis surat sudah terdaftar'
                ]
            ],
            'singkatan' => [
                'rules' => 'required|alpha|max_length[10]|is_unique[jenis_surat.singkatan]',
                'errors' => [
                    'is_unique' => 'Singkatan jenis surat sudah digunakan',
                    'alpha' => 'Singkatan hanya boleh berisi huruf'
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        try {
            $jenisSuratData = [
                'nama' => $this->request->getPost('nama'),
                'singkatan' => strtoupper($this->request->getPost('singkatan')),
                'created_by' => $adminId
            ];

            $this->jenisSuratModel->save($jenisSuratData);

            // Log activity
            activity_log(
                $adminId,
                'Menambahkan Jenis Surat',
                'Menambahkan jenis surat baru: ' . $jenisSuratData['nama'] . ' (' . $jenisSuratData['singkatan'] . ')',
                'jenis-surat'
            );

            return redirect()->to('/admin/jenis-surat')
                ->with('success', 'Jenis surat berhasil ditambahkan.');

        } catch (\Exception $e) {
            log_message('error', 'Gagal menambahkan jenis surat: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan jenis surat. Silakan coba lagi.');
        }
    }

    public function edit($id)
    {
        $adminId = session()->get('user')['id'] ?? null;
        if (!$adminId) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $jenisSurat = $this->jenisSuratModel->find($id);
        if (!$jenisSurat) {
            return redirect()->to('/admin/jenis-surat')
                ->with('error', 'Jenis surat tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Jenis Surat',
            'user' => session()->get('user'),
            'jenisSurat' => $jenisSurat,
            'validation' => \Config\Services::validation()
        ];

        return view('admin/jenis_surat/edit', $data);
    }

    public function update($id)
    {
        $adminId = session()->get('user')['id'] ?? null;
        if (!$adminId) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $jenisSuratLama = $this->jenisSuratModel->find($id);
        if (!$jenisSuratLama) {
            return redirect()->to('/admin/jenis-surat')
                ->with('error', 'Jenis surat tidak ditemukan');
        }

        $namaRule = 'required|max_length[100]';
        $singkatanRule = 'required|alpha|max_length[10]';

        if ($jenisSuratLama['nama'] !== $this->request->getPost('nama')) {
            $namaRule .= '|is_unique[jenis_surat.nama]';
        }

        if ($jenisSuratLama['singkatan'] !== $this->request->getPost('singkatan')) {
            $singkatanRule .= '|is_unique[jenis_surat.singkatan]';
        }

        $validationRules = [
            'nama' => [
                'rules' => $namaRule,
                'errors' => [
                    'is_unique' => 'Nama jenis surat sudah terdaftar'
                ]
            ],
            'singkatan' => [
                'rules' => $singkatanRule,
                'errors' => [
                    'is_unique' => 'Singkatan jenis surat sudah digunakan',
                    'alpha' => 'Singkatan hanya boleh berisi huruf'
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        try {
            $jenisSuratData = [
                'id' => $id,
                'nama' => $this->request->getPost('nama'),
                'singkatan' => strtoupper($this->request->getPost('singkatan')),
                'updated_by' => $adminId
            ];

            $this->jenisSuratModel->save($jenisSuratData);

            // Log activity
            activity_log(
                $adminId,
                'Memperbarui Jenis Surat',
                'Memperbarui jenis surat: ' . $jenisSuratData['nama'] . ' (' . $jenisSuratData['singkatan'] . ')',
                'jenis-surat'
            );

            return redirect()->to('/admin/jenis-surat')
                ->with('success', 'Jenis surat berhasil diperbarui.');

        } catch (\Exception $e) {
            log_message('error', 'Gagal memperbarui jenis surat: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui jenis surat. Silakan coba lagi.');
        }
    }

    public function delete($id)
    {
        $adminId = session()->get('user')['id'] ?? null;
        if (!$adminId) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $jenisSurat = $this->jenisSuratModel->find($id);
        if (!$jenisSurat) {
            return redirect()->to('/admin/jenis-surat')
                ->with('error', 'Jenis surat tidak ditemukan');
        }

        try {
            // Log activity sebelum dihapus
            activity_log(
                $adminId,
                'Menghapus Jenis Surat',
                'Menghapus jenis surat: ' . $jenisSurat['nama'] . ' (' . $jenisSurat['singkatan'] . ')',
                'jenis-surat'
            );

            // Hapus langsung tanpa cek isUsed
            $this->jenisSuratModel->delete($id);

            return redirect()->to('/admin/jenis-surat')
                ->with('success', 'Jenis surat berhasil dihapus.');

        } catch (\Exception $e) {
            log_message('error', 'Gagal menghapus jenis surat: ' . $e->getMessage());
            return redirect()->to('/admin/jenis-surat')
                ->with('error', 'Gagal menghapus jenis surat. Silakan coba lagi.');
        }
    }
}
