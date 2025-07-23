<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\SuratMasukModel;
use App\Models\PerusahaanModel;

class SuratMasuk extends BaseController
{
    protected $suratMasukModel;
    protected $perusahaanModel;

    public function __construct()
    {
        $this->suratMasukModel = new SuratMasukModel();
        $this->perusahaanModel = new PerusahaanModel();
    }

    public function create()
    {
        $data = [
            'title' => 'Kirim Surat Masuk',
            'user' => session()->get(),
            'perusahaan' => $this->perusahaanModel->findAll(),
            'validation' => \Config\Services::validation()
        ];
        
        return view('user/surat_masuk/create', $data);
    }

    public function store()
    {
        $createdBy = session()->get('user')['id'];
        if (!$createdBy) {
            return redirect()->back()->with('error', 'User belum login.');
        }

        $rules = [
            'nomor_surat' => 'required',
            'perusahaan_id' => 'required',
            'dari' => 'required',
            'perihal' => 'required',
            'tgl_surat' => 'required',
            'file_surat' => [
                'uploaded[file_surat]',
                'mime_in[file_surat,application/pdf,image/jpeg,image/png,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document]',
                'max_size[file_surat,5120]'
            ]
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $file = $this->request->getFile('file_surat');
        $fileName = $file->getRandomName();
        $file->move('uploads/surat_masuk', $fileName);
        
        $this->suratMasukModel->save([
            'nomor_surat' => $this->request->getPost('nomor_surat'),
            'perusahaan_id' => $this->request->getPost('perusahaan_id'),
            'dari' => $this->request->getPost('dari'),
            'perihal' => $this->request->getPost('perihal'),
            'file_surat' => $fileName,
            'tgl_surat' => $this->request->getPost('tgl_surat'),
            'waktu_diterima' => date('Y-m-d H:i:s'),
            'created_by' => $createdBy
        ]);

        $activityModel = new \App\Models\ActivityModel();
        $nomorSurat = $this->request->getPost('nomor_surat');
        $activityModel->insert([
            'user_id' => session()->get('user')['id'],
            'title' => 'Mengirim Surat',
            'description' => 'Anda mengirim surat dengan nomor: ' . $nomorSurat,
            'type' => 'surat-masuk'
        ]);

        
        return redirect()->to('/user/kirim-surat')->with('message', 'Surat masuk berhasil dikirim');
    }
}