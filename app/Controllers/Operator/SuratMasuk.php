<?php

namespace App\Controllers\Operator;

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

    public function index()
    {
        $bulan = $this->request->getGet('bulan') ?? date('n'); // Default bulan sekarang
        $tahun = $this->request->getGet('tahun') ?? date('Y');  // Default tahun sekarang
        $perusahaanId = $this->request->getGet('perusahaan_id');

        // Builder surat masuk dengan join ke perusahaan dan user
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
            'user' => session()->get('user')
        ];

        return view('operator/surat_masuk/index', $data);
    }

    public function resetFilter()
    {
        return redirect()->to('/operator/surat-masuk');
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Surat Masuk',
            'perusahaan' => $this->perusahaanModel->getAllPerusahaan(),
            'validation' => \Config\Services::validation(),
            'user' => session()->get('user')
        ];

        return view('operator/surat_masuk/create', $data);
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

        return redirect()->to('/operator/surat-masuk')->with('message', 'Surat masuk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $surat = $this->suratMasukModel->find($id);
        if (!$surat) {
            return redirect()->to('/operator/surat-masuk')->with('error', 'Data surat tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit Surat Masuk',
            'surat' => $surat,
            'perusahaan' => $this->perusahaanModel->getAllPerusahaan(),
            'validation' => \Config\Services::validation(),
            'user' => session()->get('user')
        ];

        return view('operator/surat_masuk/edit', $data);
    }

    public function update($id)
    {
        $surat = $this->suratMasukModel->find($id);
        if (!$surat) {
            return redirect()->to('/operator/surat-masuk')->with('error', 'Data surat tidak ditemukan.');
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
            'nomor_surat'     => $this->request->getPost('nomor_surat'),
            'perusahaan_id'   => $this->request->getPost('perusahaan_id'),
            'dari'            => $this->request->getPost('dari'),
            'perihal'         => $this->request->getPost('perihal'),
            'tgl_surat'       => $this->request->getPost('tgl_surat'),
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

        return redirect()->to('/operator/surat-masuk')->with('message', 'Surat berhasil diperbarui.');
    }

    public function delete($id)
    {
        $surat = $this->suratMasukModel->find($id);
        if (!$surat) {
            return redirect()->to('/operator/surat-masuk')->with('error', 'Data surat tidak ditemukan.');
        }

        if (!empty($surat['file_surat']) && file_exists('uploads/surat_masuk/' . $surat['file_surat'])) {
            unlink('uploads/surat_masuk/' . $surat['file_surat']);
        }

        $this->suratMasukModel->delete($id);

        return redirect()->to('/operator/surat-masuk')->with('message', 'Surat berhasil dihapus.');
    }
}
