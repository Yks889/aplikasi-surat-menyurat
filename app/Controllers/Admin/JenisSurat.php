<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\JenisSuratModel;

class JenisSurat extends BaseController
{
    protected $jenisSuratModel;

    public function __construct()
    {
        $this->jenisSuratModel = new JenisSuratModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Jenis Surat',
            'user' => session()->get('user'),
            'jenisSurat' => $this->jenisSuratModel->findAll()
        ];

        return view('admin/jenis_surat/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Jenis Surat',
            'user' => session()->get('user'),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/jenis_surat/create', $data);
    }

    public function store()
    {
        if (!$this->validate([
            'nama' => 'required',
            'singkatan' => 'required'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->jenisSuratModel->save([
            'nama' => $this->request->getPost('nama'),
            'singkatan' => strtoupper($this->request->getPost('singkatan'))
        ]);

        return redirect()->to('/admin/jenis-surat')->with('success', 'Jenis surat berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Jenis Surat',
            'user' => session()->get('user'),
            'jenisSurat' => $this->jenisSuratModel->find($id),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/jenis_surat/edit', $data);
    }

    public function update($id)
    {
        if (!$this->validate([
            'nama' => 'required',
            'singkatan' => 'required'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->jenisSuratModel->update($id, [
            'nama' => $this->request->getPost('nama'),
            'singkatan' => strtoupper($this->request->getPost('singkatan'))
        ]);

        return redirect()->to('/admin/jenis-surat')->with('success', 'Jenis surat berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->jenisSuratModel->delete($id);
        return redirect()->to('/admin/jenis-surat')->with('success', 'Jenis surat berhasil dihapus.');
    }
}
