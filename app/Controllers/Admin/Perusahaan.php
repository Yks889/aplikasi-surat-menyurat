<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PerusahaanModel;

class Perusahaan extends BaseController
{
    protected $perusahaanModel;

    public function __construct()
    {
        $this->perusahaanModel = new PerusahaanModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Daftar Perusahaan',
            'perusahaan' => $this->perusahaanModel->findAll(),
        ];

        return view('admin/perusahaan/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Perusahaan',
            'validation' => \Config\Services::validation()
        ];

        return view('admin/perusahaan/create', $data);
    }

    public function store()
    {
        if (!$this->validate([
            'nama' => 'required|is_unique[perusahaan.nama]',
            'singkatan' => 'required|alpha_numeric|max_length[10]'
        ])) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $this->perusahaanModel->save([
            'nama' => $this->request->getPost('nama'),
            'singkatan' => strtoupper($this->request->getPost('singkatan')),
        ]);

        return redirect()->to('/admin/perusahaan')->with('success', 'Data perusahaan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $perusahaan = $this->perusahaanModel->find($id);
        if (!$perusahaan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Perusahaan tidak ditemukan");
        }

        $data = [
            'title' => 'Edit Perusahaan',
            'perusahaan' => $perusahaan,
            'validation' => \Config\Services::validation()
        ];

        return view('admin/perusahaan/edit', $data);
    }

    public function update($id)
    {
        $perusahaanLama = $this->perusahaanModel->find($id);

        $namaRule = 'required';
        if ($perusahaanLama['nama'] !== $this->request->getPost('nama')) {
            $namaRule .= '|is_unique[perusahaan.nama]';
        }

        if (!$this->validate([
            'nama' => $namaRule,
            'singkatan' => 'required|alpha_numeric|max_length[10]'
        ])) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $this->perusahaanModel->update($id, [
            'nama' => $this->request->getPost('nama'),
            'singkatan' => strtoupper($this->request->getPost('singkatan')),
        ]);

        return redirect()->to('/admin/perusahaan')->with('success', 'Data perusahaan berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->perusahaanModel->delete($id);
        return redirect()->to('/admin/perusahaan')->with('success', 'Data perusahaan berhasil dihapus.');
    }
}
