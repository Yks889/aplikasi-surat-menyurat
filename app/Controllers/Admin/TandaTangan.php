<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TandaTanganModel;
use App\Models\UserModel;

class TandaTangan extends BaseController
{
    protected $tandaTanganModel;
    protected $userModel;

    public function __construct()
    {
        $this->tandaTanganModel = new TandaTanganModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Tanda Tangan Digital',
            'user' => session()->get('user'),
            'tandaTangan' => $this->tandaTanganModel->getAllTandaTangan(), // ambil semua ttd
            'admins' => $this->userModel->where('role', 'admin')->findAll(), // ⬅️ penting: untuk dropdown admin
            'validation' => \Config\Services::validation()
        ];

        return view('admin/tanda_tangan/index', $data);
    }

    public function upload()
    {
        $rules = [
            'user_id' => 'required',
            'file_ttd' => [
                'uploaded[file_ttd]',
                'mime_in[file_ttd,image/jpeg,image/png,image/gif]',
                'max_size[file_ttd,1024]'
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userId = $this->request->getPost('user_id');
        $file = $this->request->getFile('file_ttd');
        $fileName = $file->getRandomName();
        $file->move('uploads/tanda_tangan', $fileName);

        // Cek apakah user sudah punya tanda tangan
        $existingTtd = $this->tandaTanganModel->where('user_id', $userId)->first();

        if ($existingTtd) {
            // Hapus file lama jika ada
            if (file_exists('uploads/tanda_tangan/' . $existingTtd['file'])) {
                unlink('uploads/tanda_tangan/' . $existingTtd['file']);
            }

            // Update tanda tangan
            $this->tandaTanganModel->update($existingTtd['id'], [
                'file' => $fileName,
                'uploaded_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            // Simpan baru
            $this->tandaTanganModel->save([
                'user_id' => $userId,
                'file' => $fileName,
                'uploaded_at' => date('Y-m-d H:i:s')
            ]);
        }

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
