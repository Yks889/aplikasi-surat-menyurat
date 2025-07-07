<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SuratKeluarModel;
use App\Models\PerusahaanModel;
use App\Models\UserModel;
use App\Models\JenisSuratModel;

class SuratKeluar extends BaseController
{
    protected $suratKeluarModel;
    protected $perusahaanModel;
    protected $userModel;
    protected $jenisSuratModel;

    public function __construct()
    {
        $this->suratKeluarModel = new SuratKeluarModel();
        $this->perusahaanModel = new PerusahaanModel();
        $this->userModel = new UserModel();
        $this->jenisSuratModel = new JenisSuratModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Surat Keluar',
            'user' => session()->get(),
            'suratKeluar' => $this->suratKeluarModel->getSuratKeluarWithRelations(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/surat_keluar/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Surat Keluar',
            'user' => session()->get(),
            'perusahaan' => $this->perusahaanModel->findAll(),
            'penandatangan' => $this->userModel->where('role', 'admin')->findAll(),
            'jenis_surat' => $this->jenisSuratModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/surat_keluar/create', $data);
    }

    private function generateNomorSurat($jenisSuratSingkatan, $perusahaanSingkatan, $tanggalSurat)
    {
        $date = date_create($tanggalSurat);
        $bulan = (int)date_format($date, 'm');
        $tahun = (int)date_format($date, 'Y');

        $jumlah = $this->suratKeluarModel
            ->where('MONTH(tanggal_surat)', $bulan)
            ->where('YEAR(tanggal_surat)', $tahun)
            ->countAllResults();

        $nomorUrut = str_pad($jumlah + 1, 3, '0', STR_PAD_LEFT);
        $bulanRomawi = ["I","II","III","IV","V","VI","VII","VIII","IX","X","XI","XII"];

        return "{$nomorUrut}/{$perusahaanSingkatan}-{$jenisSuratSingkatan}/{$bulanRomawi[$bulan - 1]}/{$tahun}";
    }

    public function store()
    {
        $createdBy = session()->get('user')['id'];
        if (!$createdBy) {
            return redirect()->back()->with('error', 'User belum login.');
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

        $perusahaan = $this->perusahaanModel->asArray()->find($this->request->getPost('perusahaan_id'));
        $jenisSurat = $this->jenisSuratModel->asArray()->find($this->request->getPost('jenis_surat'));

        $nomorSurat = $this->generateNomorSurat($jenisSurat['singkatan'], $perusahaan['singkatan'], $this->request->getPost('tanggal_surat'));

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
            'isi_surat' => $this->request->getPost('isi_surat'),
            'file_surat' => $fileName,
            'created_by' => $createdBy
        ]);

        return redirect()->to('/admin/surat-keluar')->with('message', 'Surat keluar berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Surat Keluar',
            'user' => session()->get(),
            'surat' => $this->suratKeluarModel->find($id),
            'perusahaan' => $this->perusahaanModel->findAll(),
            'penandatangan' => $this->userModel->where('role', 'admin')->findAll(),
            'jenis_surat' => $this->jenisSuratModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/surat_keluar/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'nomor_surat' => 'required',
            'untuk' => 'required',
            'perusahaan_id' => 'required',
            'tanggal_surat' => 'required',
            'perihal' => 'required',
            'penandatangan_id' => 'required',
            'isi_surat' => 'required',
            'file_surat' => [
                'mime_in[file_surat,application/pdf,image/jpeg,image/png,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document]',
                'max_size[file_surat,5120]'
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $surat = $this->suratKeluarModel->find($id);
        $file = $this->request->getFile('file_surat');

        $data = [
            'nomor_surat' => $this->request->getPost('nomor_surat'),
            'untuk' => $this->request->getPost('untuk'),
            'perusahaan_id' => $this->request->getPost('perusahaan_id'),
            'tanggal_surat' => $this->request->getPost('tanggal_surat'),
            'perihal' => $this->request->getPost('perihal'),
            'penandatangan_id' => $this->request->getPost('penandatangan_id'),
            'isi_surat' => $this->request->getPost('isi_surat')
        ];

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move('uploads/surat_keluar', $fileName);

            if ($surat['file_surat'] && file_exists('uploads/surat_keluar/' . $surat['file_surat'])) {
                unlink('uploads/surat_keluar/' . $surat['file_surat']);
            }

            $data['file_surat'] = $fileName;
        }

        $this->suratKeluarModel->update($id, $data);

        return redirect()->to('/admin/surat-keluar')->with('message', 'Surat keluar berhasil diperbarui');
    }

    public function delete($id)
    {
        $surat = $this->suratKeluarModel->find($id);

        if ($surat['file_surat'] && file_exists('uploads/surat_keluar/' . $surat['file_surat'])) {
            unlink('uploads/surat_keluar/' . $surat['file_surat']);
        }

        $this->suratKeluarModel->delete($id);

        return redirect()->to('/admin/surat-keluar')->with('message', 'Surat keluar berhasil dihapus');
    }
}
