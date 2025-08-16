<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\SuratMasukModel;
use App\Models\PerusahaanModel;
use App\Models\UserModel;
use App\Models\PengajuanSuratKeluarModel;
use Config\Database;
use Config\Services;

class Disposisi extends BaseController
{
    protected $suratMasukModel;
    protected $perusahaanModel;
    protected $userModel;
    protected $pengajuanModel;
    protected $helpers = ['form', 'activity']; // Tambah helper activity

    public function __construct()
    {
        $this->suratMasukModel = new SuratMasukModel();
        $this->perusahaanModel = new PerusahaanModel();
        $this->userModel = new UserModel();
        $this->pengajuanModel = new PengajuanSuratKeluarModel();
    }

    public function index()
    {
        $db = Database::connect();
        $userId = session()->get('user')['id'];

        // Update status dan catat waktu dibaca
        $db->table('disposisi_user')
            ->where('ke_user_id', $userId)
            ->where('status', 'belum dibaca')
            ->update([
                'status' => 'dibaca',
                'dibaca_pada' => date('Y-m-d H:i:s')
            ]);

        // Ambil data disposisi yang masuk
        $query = $db->table('disposisi_user')
            ->select('
                disposisi_user.id,
                disposisi_user.status,
                disposisi_user.dibaca_pada,
                surat_masuk.id as surat_id,
                surat_masuk.nomor_surat,
                surat_masuk.file_surat,
                disposisi.catatan,
                disposisi.created_at,
                dari_user.full_name AS dari
            ')
            ->join('disposisi', 'disposisi.id = disposisi_user.disposisi_id', 'left')
            ->join('surat_masuk', 'surat_masuk.id = disposisi.surat_id', 'left')
            ->join('users as dari_user', 'dari_user.id = disposisi.dari_user_id', 'left')
            ->where('disposisi_user.ke_user_id', $userId)
            ->orderBy('disposisi.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Disposisi Surat Masuk',
            'user' => session()->get(),
            'disposisi' => $query
        ];

        return view('user/disposisi/index', $data);
    }

    public function detail($surat_id)
    {
        $db = Database::connect();
        $currentUserId = session()->get('user')['id'];
        
        // Ambil data surat
        $surat = $db->table('surat_masuk')
            ->select('surat_masuk.*, perusahaan.nama as perusahaan_nama, users.full_name as pengirim_nama')
            ->join('perusahaan', 'perusahaan.id = surat_masuk.perusahaan_id', 'left')
            ->join('users', 'users.id = surat_masuk.created_by', 'left')
            ->where('surat_masuk.id', $surat_id)
            ->get()
            ->getRowArray();

        if (!$surat) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Surat tidak ditemukan.');
        }

        // Ambil data disposisi untuk surat ini, hanya untuk user yang sedang login
        $disposisiList = $db->table('disposisi')
            ->select('disposisi.*,
                      dari.full_name as dari_nama,
                      ke.full_name as ke_nama,
                      disposisi_user.status,
                      disposisi_user.dibaca_pada')
            ->join('users as dari', 'dari.id = disposisi.dari_user_id', 'left')
            ->join('disposisi_user', 'disposisi_user.disposisi_id = disposisi.id', 'left')
            ->join('users as ke', 'ke.id = disposisi_user.ke_user_id', 'left')
            ->where('disposisi.surat_id', $surat_id)
            ->where('disposisi_user.ke_user_id', $currentUserId)
            ->orderBy('disposisi.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Detail Disposisi Surat',
            'user' => session()->get(),
            'surat' => $surat,
            'disposisi' => $disposisiList
        ];

        return view('user/disposisi/detail', $data);
    }

    public function ajukan($id)
    {
        $surat = $this->suratMasukModel->find($id);

        if (!$surat) {
            return redirect()->back()->with('error', 'Surat tidak ditemukan.');
        }

        $data = [
            'title' => 'Ajukan Surat Keluar',
            'user' => session()->get(),
            'surat' => $surat,
            'validation' => Services::validation()
        ];

        return view('user/disposisi/ajukan', $data);
    }

    public function kirimPengajuan($id)
    {
        $createdBy = session()->get('user')['id'];
        if (!$createdBy) {
            return redirect()->back()->with('error', 'User belum login.');
        }

        $rules = [
            'judul' => 'required',
            'catatan' => 'required'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $surat = $this->suratMasukModel->find($id);
        if (!$surat) {
            return redirect()->back()->with('error', 'Surat tidak ditemukan.');
        }

        $user = session('user');

        $this->pengajuanModel->save([
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('catatan'),
            'dari' => $user['full_name'],
            'kepada' => 'Admin',
            'surat_masuk_id' => $id,
            'created_by' => $createdBy
        ]);

        // Panggil helper activity_log
        activity_log(
            $createdBy,
            'Mengajukan Surat Keluar',
            'Mengajukan surat keluar untuk surat masuk dengan nomor: ' . $surat['nomor_surat'],
            'pengajuan-surat'
        );

        return redirect()->to('/user/disposisi')->with('message', 'Pengajuan surat keluar berhasil dikirim.');
    }
}