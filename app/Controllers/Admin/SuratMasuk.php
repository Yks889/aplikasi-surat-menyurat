<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SuratMasukModel;
use App\Models\PerusahaanModel;
use App\Models\DisposisiModel;
use App\Models\DisposisiUserModel;
use App\Models\UserModel;
use CodeIgniter\I18n\Time;


class SuratMasuk extends BaseController
{
    protected $suratMasukModel;
    protected $perusahaanModel;
    protected $disposisiModel;
    protected $userModel;

    public function __construct()
    {
        $this->suratMasukModel = new SuratMasukModel();
        $this->perusahaanModel = new PerusahaanModel();
        $this->disposisiModel = new DisposisiModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $bulan = $this->request->getGet('bulan') ?? date('n');
        $tahun = $this->request->getGet('tahun') ?? date('Y');
        $perusahaanId = $this->request->getGet('perusahaan_id');

        $builder = $this->suratMasukModel
            ->select('surat_masuk.*, perusahaan.nama AS perusahaan, users.full_name AS pengirim')
            ->join('perusahaan', 'perusahaan.id = surat_masuk.perusahaan_id', 'left')
            ->join('users', 'users.id = surat_masuk.created_by', 'left')
            ->where('MONTH(tgl_surat)', $bulan)
            ->where('YEAR(tgl_surat)', $tahun);

        if (!empty($perusahaanId)) {
            $builder->where('surat_masuk.perusahaan_id', $perusahaanId);
        }

        $data = [
            'title' => 'Surat Masuk',
            'suratMasuk' => $builder->orderBy('tgl_surat', 'DESC')->findAll(),
            'perusahaanList' => $this->perusahaanModel->findAll(),
            'bulan' => $bulan,
            'tahun' => $tahun,
            'perusahaan_id' => $perusahaanId,
            'user' => session()->get('user'),
            'users' => $this->userModel->where('role', 'user')->findAll(), // ✅ hanya user bisa Untuk dropdown disposisi
        ];

        return view('admin/surat_masuk/index', $data);
    }

    public function resetFilter()
    {
        return redirect()->to('/admin/surat-masuk');
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Surat Masuk',
            'perusahaan' => $this->perusahaanModel->getAllPerusahaan(),
            'validation' => \Config\Services::validation(),
            'user' => session()->get('user')
        ];

        return view('admin/surat_masuk/create', $data);
    }

    public function store()
    {
        $createdBy = session()->get('user')['id'];

        if (!$this->validate([
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
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('file_surat');
        $fileName = $file->getRandomName();
        $file->move('uploads/surat_masuk', $fileName);

        $this->suratMasukModel->save([
            'nomor_surat'     => $this->request->getPost('nomor_surat'),
            'perusahaan_id'   => $this->request->getPost('perusahaan_id'),
            'dari'            => $this->request->getPost('dari'),
            'perihal'         => $this->request->getPost('perihal'),
            'file_surat'      => $fileName,
            'tgl_surat'       => $this->request->getPost('tgl_surat'),
            'waktu_diterima'  => date('Y-m-d H:i:s'),
            'created_by'      => $createdBy
        ]);

        return redirect()->to('/admin/surat-masuk')->with('message', 'Surat masuk berhasil ditambahkan');
    }

    public function edit($id)
    {
        $surat = $this->suratMasukModel->find($id);

        if (!$surat) {
            return redirect()->to('/admin/surat-masuk')->with('error', 'Data surat tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit Surat Masuk',
            'surat' => $surat,
            'perusahaan' => $this->perusahaanModel->getAllPerusahaan(),
            'validation' => \Config\Services::validation(),
            'user' => session()->get('user')
        ];

        return view('admin/surat_masuk/edit', $data);
    }

    public function update($id)
    {
        $surat = $this->suratMasukModel->find($id);
        if (!$surat) {
            return redirect()->to('/admin/surat-masuk')->with('error', 'Data surat tidak ditemukan.');
        }

        $rules = [
            'nomor_surat' => 'required',
            'perusahaan_id' => 'required',
            'dari' => 'required',
            'perihal' => 'required',
            'tgl_surat' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $dataUpdate = [
            'nomor_surat' => $this->request->getPost('nomor_surat'),
            'perusahaan_id' => $this->request->getPost('perusahaan_id'),
            'dari' => $this->request->getPost('dari'),
            'perihal' => $this->request->getPost('perihal'),
            'tgl_surat' => $this->request->getPost('tgl_surat'),
        ];

        $file = $this->request->getFile('file_surat');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newFileName = $file->getRandomName();
            $file->move('uploads/surat_masuk', $newFileName);

            if (is_file('uploads/surat_masuk/' . $surat['file_surat'])) {
                unlink('uploads/surat_masuk/' . $surat['file_surat']);
            }

            $dataUpdate['file_surat'] = $newFileName;
        }

        $this->suratMasukModel->update($id, $dataUpdate);

        return redirect()->to('/admin/surat-masuk')->with('message', 'Surat berhasil diperbarui.');
    }

    public function delete($id)
    {
        $surat = $this->suratMasukModel->find($id);
        if (!$surat) {
            return redirect()->to('/admin/surat-masuk')->with('error', 'Data surat tidak ditemukan.');
        }

        if (!empty($surat['file_surat']) && file_exists('uploads/surat_masuk/' . $surat['file_surat'])) {
            unlink('uploads/surat_masuk/' . $surat['file_surat']);
        }

        $this->suratMasukModel->delete($id);

        return redirect()->to('/admin/surat-masuk')->with('message', 'Surat berhasil dihapus.');
    }

    public function kirimDisposisi($id)
    {
        $disposisiModel = new DisposisiModel();
        $disposisiUserModel = new DisposisiUserModel();

        $dariUserId = session()->get('user')['id'];
        $keUserIds = $this->request->getPost('ke_user_ids'); // array checkbox
        $catatan = $this->request->getPost('catatan');

        if (empty($keUserIds)) {
            return redirect()->back()->with('error', 'Pilih minimal satu pengguna tujuan.');
        }

        // Cek apakah sudah ada disposisi sebelumnya
        $existingDisposisi = $disposisiModel
            ->where('surat_id', $id)
            ->where('dari_user_id', $dariUserId)
            ->first();

        if ($existingDisposisi) {
            // Update catatan dan waktu
            $disposisiModel->update($existingDisposisi['id'], [
                'catatan' => $catatan,
                'dibaca_pada' => Time::now('Asia/Jakarta'),
                'created_at' => Time::now('Asia/Jakarta')
            ]);

            // Hapus semua user tujuan lama
            $disposisiUserModel->where('disposisi_id', $existingDisposisi['id'])->delete();

            // Tambahkan user tujuan baru
            foreach ($keUserIds as $keUserId) {
                $disposisiUserModel->insert([
                    'disposisi_id' => $existingDisposisi['id'],
                    'ke_user_id'   => $keUserId,
                    'status'       => 'belum dibaca'
                ]);
            }

            return redirect()->back()->with('message', 'Disposisi berhasil diperbarui.');
        }

        // Jika belum ada disposisi, buat baru
        $disposisiId = $disposisiModel->insert([
            'surat_id'     => $id,
            'dari_user_id' => $dariUserId,
            'catatan'      => $catatan,
            'dibaca_pada'  => Time::now('Asia/Jakarta'),
            'created_at'   => Time::now('Asia/Jakarta')
        ]);

        foreach ($keUserIds as $keUserId) {
            $disposisiUserModel->insert([
                'disposisi_id' => $disposisiId,
                'ke_user_id'   => $keUserId,
                'status'       => 'belum dibaca'
            ]);
        }

        return redirect()->back()->with('message', 'Disposisi berhasil dikirim.');
    }
}