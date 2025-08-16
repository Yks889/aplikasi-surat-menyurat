<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TandaTanganModel;

class TandaTangan extends BaseController
{
    protected $tandaTanganModel;

    public function __construct()
    {
        $this->tandaTanganModel = new TandaTanganModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Tanda Tangan Digital',
            'user' => session()->get('user'),
            'tandaTangan' => $this->tandaTanganModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/tanda_tangan/index', $data);
    }

    public function upload()
    {
        $rules = [
            'nama' => 'required|min_length[3]',
            'file_ttd' => [
                'uploaded[file_ttd]',
                'mime_in[file_ttd,image/jpeg,image/png,image/gif]',
                'max_size[file_ttd,1024]'
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $nama = $this->request->getPost('nama');
        $file = $this->request->getFile('file_ttd');
        $fileName = $file->getRandomName();
        $file->move('uploads/tanda_tangan', $fileName);

        // Simpan langsung dengan nama, tanpa user_id
        $this->tandaTanganModel->save([
            'nama' => $nama,
            'file' => $fileName,
            'uploaded_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/admin/tanda-tangan')->with('message', 'Tanda tangan berhasil diupload');
    }

    public function delete($id)
    {
        $ttd = $this->tandaTanganModel->find($id);

        if ($ttd && file_exists('uploads/tanda_tangan/' . $ttd['file'])) {
            unlink('uploads/tanda_tangan/' . $ttd['file']);
        }

        $this->tandaTanganModel->delete($id);

        return redirect()->to('/admin/tanda-tangan')->with('message', 'Tanda tangan berhasil dihapus');
    }
}
