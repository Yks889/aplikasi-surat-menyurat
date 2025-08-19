<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SuratKeluarModel;
use App\Models\PerusahaanModel;
use App\Models\UserModel;
use App\Models\JenisSuratModel;
use App\Models\TandaTanganModel;

class SuratKeluar extends BaseController
{
    protected $suratKeluarModel;
    protected $perusahaanModel;
    protected $userModel;
    protected $jenisSuratModel;
    protected $tandaTanganModel;
    protected $helpers = ['form', 'activity']; // Add activity helper

    public function __construct()
    {
        $this->suratKeluarModel = new SuratKeluarModel();
        $this->perusahaanModel = new PerusahaanModel();
        $this->userModel = new UserModel();
        $this->jenisSuratModel = new JenisSuratModel();
        $this->tandaTanganModel = new TandaTanganModel();
    }

    public function index()
    {
        $bulan = $this->request->getGet('bulan') ?? date('n');
        $tahun = $this->request->getGet('tahun') ?? date('Y');
        $perusahaanId = $this->request->getGet('perusahaan_id');

        $builder = $this->suratKeluarModel
            ->select('surat_keluar.*, perusahaan.nama AS perusahaan, tanda_tangan.nama AS penandatangan')
            ->join('perusahaan', 'perusahaan.id = surat_keluar.perusahaan_id', 'left')
            ->join('tanda_tangan', 'tanda_tangan.id = surat_keluar.penandatangan_id', 'left')
            ->where('MONTH(tanggal_surat)', $bulan)
            ->where('YEAR(tanggal_surat)', $tahun);

        if (!empty($perusahaanId)) {
            $builder->where('surat_keluar.perusahaan_id', $perusahaanId);
        }

        $data = [
            'title' => 'Surat Keluar',
            'suratKeluar' => $builder->orderBy('tanggal_surat', 'DESC')->findAll(),
            'perusahaanList' => $this->perusahaanModel->findAll(),
            'bulan' => $bulan,
            'tahun' => $tahun,
            'perusahaan_id' => $perusahaanId,
            'user' => session()->get('user')
        ];

        return view('admin/surat_keluar/index', $data);
    }

    public function resetFilter()
    {
        return redirect()->to('/admin/surat-keluar');
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Surat Keluar',
            'user' => session()->get(),
            'perusahaan' => $this->perusahaanModel->findAll(),
            'penandatangan' => $this->tandaTanganModel->findAll(),
            'jenis_surat' => $this->jenisSuratModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/surat_keluar/create', $data);
    }

    public function generateNomorSurat($jenisSuratSingkatan, $perusahaanSingkatan, $tanggalSurat)
    {
        $bulan = (int)date('m', strtotime($tanggalSurat));
        $tahun = (int)date('Y', strtotime($tanggalSurat));

        $jumlah = $this->suratKeluarModel
            ->where('MONTH(tanggal_surat)', $bulan)
            ->where('YEAR(tanggal_surat)', $tahun)
            ->countAllResults();

        $nomorUrut = str_pad($jumlah + 1, 3, '0', STR_PAD_LEFT);
        $bulanRomawi = ['I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'];

        return "{$nomorUrut}/{$perusahaanSingkatan}-{$jenisSuratSingkatan}/{$bulanRomawi[$bulan - 1]}/{$tahun}";
    }

    public function store()
    {
        $adminId = session()->get('user')['id'];
        if (!$adminId) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $rules = [
            'jenis_surat' => 'required',
            'untuk' => 'required',
            'perusahaan_id' => 'required',
            'tanggal_surat' => 'required',
            'perihal' => 'required',
            'penandatangan_id' => 'required',
            'file_surat' => [
                'uploaded[file_surat]',
                'mime_in[file_surat,application/pdf,image/jpeg,image/png,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document]',
                'max_size[file_surat,5120]'
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $perusahaan = $this->perusahaanModel->find($this->request->getPost('perusahaan_id'));
        $jenisSurat = $this->jenisSuratModel->find($this->request->getPost('jenis_surat'));
        $tanggalSurat = $this->request->getPost('tanggal_surat');
        $nomorSurat = $this->generateNomorSurat($jenisSurat['singkatan'], $perusahaan['singkatan'], $tanggalSurat);

        $file = $this->request->getFile('file_surat');
        $fileName = $file->getRandomName();
        $file->move('uploads/surat_keluar', $fileName);

        $this->suratKeluarModel->save([
            'kode_surat' => $jenisSurat['singkatan'],
            'nomor_surat' => $nomorSurat,
            'untuk' => $this->request->getPost('untuk'),
            'perusahaan_id' => $this->request->getPost('perusahaan_id'),
            'tanggal_surat' => $this->request->getPost('tanggal_surat'),
            'perihal' => $this->request->getPost('perihal'),
            'penandatangan_id' => $this->request->getPost('penandatangan_id'),
            'file_surat' => $fileName,
            'created_by' => $adminId
        ]);

        $suratId = $this->suratKeluarModel->getInsertID();

        // Log activity
        activity_log(
            $adminId,
            'Menambahkan Surat Keluar',
            'Menambahkan surat keluar dengan nomor: ' . $nomorSurat . ' untuk: ' . $this->request->getPost('untuk'),
            'surat-keluar'
        );

        return redirect()->to('/admin/surat-keluar')->with('message', 'Surat keluar berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Surat Keluar',
            'user' => session()->get(),
            'surat' => $this->suratKeluarModel->find($id),
            'perusahaan' => $this->perusahaanModel->findAll(),
            'penandatangan' => $this->tandaTanganModel->findAll(),
            'jenis_surat' => $this->jenisSuratModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/surat_keluar/edit', $data);
    }

    public function update($id)
    {
        $adminId = session()->get('user')['id'];
        if (!$adminId) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $surat = $this->suratKeluarModel->find($id);
        if (!$surat) {
            return redirect()->to('/admin/surat-keluar')->with('error', 'Surat tidak ditemukan.');
        }

        $rules = [
            'jenis_surat' => 'required',
            'untuk' => 'required',
            'perusahaan_id' => 'required',
            'tanggal_surat' => 'required',
            'perihal' => 'required',
            'penandatangan_id' => 'required',
            'file_surat' => [
                'permit_empty',
                'mime_in[file_surat,application/pdf,image/jpeg,image/png,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document]',
                'max_size[file_surat,5120]'
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $jenisSurat = $this->jenisSuratModel->find($this->request->getPost('jenis_surat'));
        $perusahaan = $this->perusahaanModel->find($this->request->getPost('perusahaan_id'));
        $tanggalSurat = $this->request->getPost('tanggal_surat');
        $nomorSurat = $this->generateNomorSurat($jenisSurat['singkatan'], $perusahaan['singkatan'], $tanggalSurat);

        $file = $this->request->getFile('file_surat');

        $data = [
            'kode_surat' => $jenisSurat['singkatan'],
            'nomor_surat' => $nomorSurat,
            'untuk' => $this->request->getPost('untuk'),
            'perusahaan_id' => $this->request->getPost('perusahaan_id'),
            'tanggal_surat' => $tanggalSurat,
            'perihal' => $this->request->getPost('perihal'),
            'penandatangan_id' => $this->request->getPost('penandatangan_id'),
        ];

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move('uploads/surat_keluar', $fileName);

            if (is_file('uploads/surat_keluar/' . $surat['file_surat'])) {
                unlink('uploads/surat_keluar/' . $surat['file_surat']);
            }

            $data['file_surat'] = $fileName;
        }

        $this->suratKeluarModel->update($id, $data);

        // Log activity
        activity_log(
            $adminId,
            'Memperbarui Surat Keluar',
            'Memperbarui surat keluar dengan ID: ' . $id . ' (Nomor: ' . $nomorSurat . ')',
            'surat-keluar'
        );

        return redirect()->to('/admin/surat-keluar')->with('message', 'Surat keluar berhasil diperbarui');
    }

    public function delete($id)
    {
        $adminId = session()->get('user')['id'];
        if (!$adminId) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $surat = $this->suratKeluarModel->find($id);
        if (!$surat) {
            return redirect()->to('/admin/surat-keluar')->with('error', 'Surat tidak ditemukan.');
        }

        // Log activity before deletion
        activity_log(
            $adminId,
            'Menghapus Surat Keluar',
            'Menghapus surat keluar dengan nomor: ' . $surat['nomor_surat'],
            'surat-keluar'
        );

        // Delete related activities
        $activityModel = new \App\Models\ActivityModel();
        $activityModel->where('type', 'surat-keluar')
            ->like('description', $surat['nomor_surat'])
            ->delete();

        // Delete file if exists
        if (!empty($surat['file_surat']) && file_exists('uploads/surat_keluar/' . $surat['file_surat'])) {
            unlink('uploads/surat_keluar/' . $surat['file_surat']);
        }

        $this->suratKeluarModel->delete($id);

        return redirect()->to('/admin/surat-keluar')->with('message', 'Surat keluar berhasil dihapus');
    }
}