<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TandaTanganModel;

class TandaTangan extends BaseController
{
    protected $tandaTanganModel;
    protected $helpers = ['form', 'activity'];

    public function __construct()
    {
        $this->tandaTanganModel = new TandaTanganModel();
    }

    public function index()
    {
        $adminId = session()->get('user')['id'] ?? null;
        if (!$adminId) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $data = [
            'title' => 'Tanda Tangan Digital',
            'user' => session()->get('user'),
            'tandaTangan' => $this->tandaTanganModel->orderBy('uploaded_at', 'DESC')->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/tanda_tangan/index', $data);
    }

    public function upload()
    {
        $adminId = session()->get('user')['id'] ?? null;
        if (!$adminId) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $rules = [
            'nama' => 'required|min_length[3]|max_length[100]',
            'file_ttd' => [
                'uploaded[file_ttd]',
                'mime_in[file_ttd,image/png,image/jpeg,image/gif]',
                'max_size[file_ttd,1024]',
                'is_image[file_ttd]'
            ]
        ];

        $messages = [
            'file_ttd' => [
                'mime_in' => 'Format file harus PNG, JPG, atau GIF',
                'max_size' => 'Ukuran file maksimal 1MB'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $nama = $this->request->getPost('nama');
        $file = $this->request->getFile('file_ttd');

        // Generate unique filename
        $fileName = 'ttd_' . time() . '_' . $file->getRandomName();
        $file->move('uploads/tanda_tangan', $fileName);

        try {
            $this->tandaTanganModel->save([
                'nama' => $nama,
                'file' => $fileName,
                'uploaded_by' => $adminId,
                'uploaded_at' => date('Y-m-d H:i:s')
            ]);

            // Log activity
            activity_log(
                $adminId,
                'Mengupload Tanda Tangan',
                'Mengupload tanda tangan digital: ' . $nama,
                'tanda-tangan'
            );

            return redirect()->to('/admin/tanda-tangan')
                ->with('message', 'Tanda tangan berhasil diupload');

        } catch (\Exception $e) {
            // Clean up if error occurs
            if (file_exists('uploads/tanda_tangan/' . $fileName)) {
                unlink('uploads/tanda_tangan/' . $fileName);
            }

            log_message('error', 'Error uploading tanda tangan: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengupload tanda tangan. Silakan coba lagi.');
        }
    }

    public function delete($id)
    {
        $adminId = session()->get('user')['id'] ?? null;
        if (!$adminId) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $ttd = $this->tandaTanganModel->find($id);
        if (!$ttd) {
            return redirect()->to('/admin/tanda-tangan')
                ->with('error', 'Tanda tangan tidak ditemukan');
        }

        try {
            // Log activity before deletion
            activity_log(
                $adminId,
                'Menghapus Tanda Tangan',
                'Menghapus tanda tangan digital: ' . $ttd['nama'],
                'tanda-tangan'
            );

            // Delete file if exists
            if ($ttd['file'] && file_exists('uploads/tanda_tangan/' . $ttd['file'])) {
                unlink('uploads/tanda_tangan/' . $ttd['file']);
            }

            $this->tandaTanganModel->delete($id);

            return redirect()->to('/admin/tanda-tangan')
                ->with('message', 'Tanda tangan berhasil dihapus');

        } catch (\Exception $e) {
            log_message('error', 'Error deleting tanda tangan: ' . $e->getMessage());
            return redirect()->to('/admin/tanda-tangan')
                ->with('error', 'Gagal menghapus tanda tangan. Silakan coba lagi.');
        }
    }
}