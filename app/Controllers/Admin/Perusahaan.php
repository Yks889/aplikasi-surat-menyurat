<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PerusahaanModel;

class Perusahaan extends BaseController
{
    protected $perusahaanModel;
    protected $helpers = ['form', 'activity'];

    public function __construct()
    {
        $this->perusahaanModel = new PerusahaanModel();
    }

    public function index()
    {
        $adminId = session()->get('user')['id'] ?? null;
        if (!$adminId) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $data = [
            'title' => 'Daftar Perusahaan',
            'perusahaan' => $this->perusahaanModel->orderBy('nama', 'ASC')->findAll(),
            'user' => session()->get('user')
        ];

        return view('admin/perusahaan/index', $data);
    }

    public function create()
    {
        $adminId = session()->get('user')['id'] ?? null;
        if (!$adminId) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $data = [
            'title' => 'Tambah Perusahaan',
            'validation' => \Config\Services::validation(),
            'user' => session()->get('user')
        ];

        return view('admin/perusahaan/create', $data);
    }

    public function store()
    {
        $adminId = session()->get('user')['id'] ?? null;
        if (!$adminId) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $validationRules = [
            'nama' => [
                'rules' => 'required|is_unique[perusahaan.nama]|max_length[100]',
                'errors' => [
                    'is_unique' => 'Nama perusahaan sudah terdaftar'
                ]
            ],
            'singkatan' => [
                'rules' => 'required|alpha_numeric|max_length[10]|is_unique[perusahaan.singkatan]',
                'errors' => [
                    'is_unique' => 'Singkatan perusahaan sudah digunakan'
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()
                ->withInput()
                ->with('validation', $this->validator);
        }

        try {
            $perusahaanData = [
                'nama' => $this->request->getPost('nama'),
                'singkatan' => strtoupper($this->request->getPost('singkatan')),
                'created_by' => $adminId
            ];

            $this->perusahaanModel->save($perusahaanData);
            $perusahaanId = $this->perusahaanModel->getInsertID();

            // Log activity
            activity_log(
                $adminId,
                'Menambahkan Perusahaan',
                'Menambahkan perusahaan baru: ' . $perusahaanData['nama'] . ' (' . $perusahaanData['singkatan'] . ')',
                'perusahaan'
            );

            return redirect()->to('/admin/perusahaan')
                ->with('success', 'Data perusahaan berhasil ditambahkan.');

        } catch (\Exception $e) {
            log_message('error', 'Gagal menambahkan perusahaan: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan perusahaan. Silakan coba lagi.');
        }
    }

    public function edit($id)
    {
        $adminId = session()->get('user')['id'] ?? null;
        if (!$adminId) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $perusahaan = $this->perusahaanModel->find($id);
        if (!$perusahaan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Perusahaan tidak ditemukan");
        }

        $data = [
            'title' => 'Edit Perusahaan',
            'perusahaan' => $perusahaan,
            'validation' => \Config\Services::validation(),
            'user' => session()->get('user')
        ];

        return view('admin/perusahaan/edit', $data);
    }

    public function update($id)
    {
        $adminId = session()->get('user')['id'] ?? null;
        if (!$adminId) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $perusahaanLama = $this->perusahaanModel->find($id);
        if (!$perusahaanLama) {
            return redirect()->to('/admin/perusahaan')
                ->with('error', 'Perusahaan tidak ditemukan');
        }

        $namaRule = 'required|max_length[100]';
        $singkatanRule = 'required|alpha_numeric|max_length[10]';

        if ($perusahaanLama['nama'] !== $this->request->getPost('nama')) {
            $namaRule .= '|is_unique[perusahaan.nama]';
        }

        if ($perusahaanLama['singkatan'] !== $this->request->getPost('singkatan')) {
            $singkatanRule .= '|is_unique[perusahaan.singkatan]';
        }

        $validationRules = [
            'nama' => [
                'rules' => $namaRule,
                'errors' => [
                    'is_unique' => 'Nama perusahaan sudah terdaftar'
                ]
            ],
            'singkatan' => [
                'rules' => $singkatanRule,
                'errors' => [
                    'is_unique' => 'Singkatan perusahaan sudah digunakan'
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()
                ->withInput()
                ->with('validation', $this->validator);
        }

        try {
            $perusahaanData = [
                'id' => $id,
                'nama' => $this->request->getPost('nama'),
                'singkatan' => strtoupper($this->request->getPost('singkatan')),
                'updated_by' => $adminId
            ];

            $this->perusahaanModel->save($perusahaanData);

            // Log activity
            activity_log(
                $adminId,
                'Memperbarui Perusahaan',
                'Memperbarui data perusahaan: ' . $perusahaanData['nama'] . ' (' . $perusahaanData['singkatan'] . ')',
                'perusahaan'
            );

            return redirect()->to('/admin/perusahaan')
                ->with('success', 'Data perusahaan berhasil diperbarui.');

        } catch (\Exception $e) {
            log_message('error', 'Gagal memperbarui perusahaan: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui perusahaan. Silakan coba lagi.');
        }
    }

    public function delete($id)
    {
        $adminId = session()->get('user')['id'] ?? null;
        if (!$adminId) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $perusahaan = $this->perusahaanModel->find($id);
        if (!$perusahaan) {
            return redirect()->to('/admin/perusahaan')
                ->with('error', 'Perusahaan tidak ditemukan');
        }

        try {
            // Log activity before deletion
            activity_log(
                $adminId,
                'Menghapus Perusahaan',
                'Menghapus perusahaan: ' . $perusahaan['nama'] . ' (' . $perusahaan['singkatan'] . ')',
                'perusahaan'
            );

            $this->perusahaanModel->delete($id);

            return redirect()->to('/admin/perusahaan')
                ->with('success', 'Data perusahaan berhasil dihapus.');

        } catch (\Exception $e) {
            log_message('error', 'Gagal menghapus perusahaan: ' . $e->getMessage());
            return redirect()->to('/admin/perusahaan')
                ->with('error', 'Gagal menghapus perusahaan. Silakan coba lagi.');
        }
    }
}