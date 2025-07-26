<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use Config\Database;
use CodeIgniter\I18n\Time;
use App\Models\DisposisiModel;
use App\Models\UserModel;


class Disposisi extends BaseController
{

    protected $DisposisiModel;
    protected $userModel;

    public function __construct()
    {
        $this->DisposisiModel = new DisposisiModel();
        $this->userModel = new UserModel();
    }

   public function index()
{
    $db = Database::connect();
    $user = session()->get('user');

    // Cek jika yang login adalah user biasa
    if ($user && $user['role'] === 'user') {
        // Update semua disposisi_user untuk user ini yang belum dibaca
        $db->table('disposisi_user')
            ->where('ke_user_id', $user['id'])
            ->where('status', 'belum dibaca')
            ->update(['status' => 'dibaca']);
    }

    // Ambil parameter filter
    $filter_bulan = $this->request->getGet('bulan');
    $filter_tahun = $this->request->getGet('tahun');
    $filter_status = $this->request->getGet('status');
    $filter_pengirim = $this->request->getGet('pengirim');

    // Query builder untuk disposisi
    $builder = $db->table('disposisi')
            ->select('disposisi.*, surat_masuk.nomor_surat, surat_masuk.file_surat, dari.full_name AS dari_nama, ke.full_name AS ke_nama, disposisi_user.status, disposisi_user.dibaca_pada')
            ->join('surat_masuk', 'surat_masuk.id = disposisi.surat_id', 'left')
            ->join('users as dari', 'dari.id = disposisi.dari_user_id', 'left')
            ->join('disposisi_user', 'disposisi_user.disposisi_id = disposisi.id', 'left')
            ->join('users as ke', 'ke.id = disposisi_user.ke_user_id', 'left');

    // Apply filters
    if ($filter_bulan) {
        $builder->where('MONTH(disposisi.created_at)', $filter_bulan);
    }
    
    if ($filter_tahun) {
        $builder->where('YEAR(disposisi.created_at)', $filter_tahun);
    }
    
    if ($filter_status) {
        $builder->where('disposisi_user.status', $filter_status);
    }
    
    if ($filter_pengirim) {
        $builder->where('disposisi.dari_user_id', $filter_pengirim);
    }

    $disposisiList = $builder->orderBy('disposisi.created_at', 'DESC')
            ->get()
            ->getResultArray();
    
    

    // Ambil list pengirim untuk dropdown filter
    $pengirimList = $db->table('users')
            ->select('id, full_name as nama')
            ->whereIn('role', ['admin', 'operator'])
            ->get()
            ->getResultArray();

    return view('admin/disposisi/index', [
        'disposisi' => $disposisiList,
        'pengirimList' => $pengirimList,
        'filter_bulan' => $filter_bulan,
        'filter_tahun' => $filter_tahun,
        'filter_status' => $filter_status,
        'filter_pengirim' => $filter_pengirim
    ]);
}

public function delete($id)
{
    $db = Database::connect();
    
    try {
        // Hapus data dari disposisi_user terlebih dahulu
        $db->table('disposisi_user')->where('disposisi_id', $id)->delete();
        
        // Kemudian hapus data dari disposisi
        $db->table('disposisi')->where('id', $id)->delete();
        
        session()->setFlashdata('success', 'Disposisi berhasil dihapus');
    } catch (\Exception $e) {
        session()->setFlashdata('error', 'Gagal menghapus disposisi');
    }
    
    return redirect()->to(base_url('admin/disposisi'));
}

public function edit($id)
{
    $disposisi = $this->DisposisiModel
        ->select('disposisi.*, surat_masuk.nomor_surat, surat_masuk.file_surat, surat_masuk.dari, dari.full_name AS dari_nama')
        ->join('surat_masuk', 'surat_masuk.id = disposisi.surat_id')
        ->join('users as dari', 'dari.id = disposisi.dari_user_id')
        ->where('disposisi.id', $id)
        ->first();

    if (!$disposisi) {
        return redirect()->back()->with('message', 'Data disposisi tidak ditemukan');
    }

    // Ambil semua user selain admin
    $usersList = $this->userModel
    ->whereNotIn('role', ['admin', 'operator'])
    ->findAll();

    // Ambil semua ke_user_id yang pernah ditambahkan ke disposisi ini
    $db = \Config\Database::connect();
    $selectedUserIds = $db->table('disposisi_user')
        ->select('ke_user_id')
        ->where('disposisi_id', $id)
        ->get()
        ->getResultArray();
    $selectedUserIds = array_column($selectedUserIds, 'ke_user_id');

    return view('admin/disposisi/edit', [
        'disposisi' => $disposisi,
        'usersList' => $usersList,
        'selectedUserIds' => $selectedUserIds,
        'validation' => session()->get('validation') ?? \Config\Services::validation()
    ]);
}

public function update($id)
{
    $db = Database::connect();

    log_message('debug', 'Masuk ke update(), ID: ' . $id);
    log_message('debug', 'POST: ' . print_r($this->request->getPost(), true));

    $validation = \Config\Services::validation();
    $validation->setRules([
        'ke_user_ids' => 'required',
        'catatan' => 'required|min_length[5]'
    ]);

    if (!$validation->withRequest($this->request)->run()) {
        log_message('debug', 'VALIDASI GAGAL: ' . print_r($validation->getErrors(), true));
        session()->setFlashdata('validation', $validation);
        return redirect()->back()->withInput();
    }

    try {
        // Update disposisi
        $db->table('disposisi')->where('id', $id)->update([
            'catatan' => $this->request->getPost('catatan')
        ]);

        // Hapus disposisi_user lama
        $db->table('disposisi_user')->where('disposisi_id', $id)->delete();

        $keUserIds = $this->request->getPost('ke_user_ids');
        foreach ($keUserIds as $keUserId) {
            $db->table('disposisi_user')->insert([
                'disposisi_id' => $id,
                'ke_user_id' => $keUserId,
                'status' => 'belum dibaca',
                'dibaca_pada' => null
            ]);
        }

        session()->setFlashdata('success', 'Disposisi berhasil diperbarui');
        return redirect()->to(base_url('admin/disposisi'));

    } catch (\Exception $e) {
        log_message('error', 'ERROR saat update: ' . $e->getMessage());
        session()->setFlashdata('error', 'Gagal memperbarui disposisi');
        return redirect()->back()->withInput();
    }
}
public function detail($surat_id)
{
    $db = \Config\Database::connect();
    
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

    // Ambil data disposisi untuk surat ini
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
        ->orderBy('disposisi.created_at', 'DESC')
        ->get()
        ->getResultArray();

    return view('admin/disposisi/detail', [
        'title' => 'Detail Disposisi Surat',
        'surat' => $surat,
        'disposisi' => $disposisiList,
        'user' => session()->get('user')
    ]);
}



}
