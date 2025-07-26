<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use Config\Database;
use CodeIgniter\I18n\Time;
<<<<<<< HEAD
=======
use App\Models\DisposisiModel;
use App\Models\UserModel;
>>>>>>> a2b31bd635cdc5ebfe38673510c2d7bdbde1b4cf


class Disposisi extends BaseController
{
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
<<<<<<< HEAD
    $db = Database::connect();
    
    // Ambil data disposisi
    $disposisi = $db->table('disposisi')
        ->select('disposisi.*, surat_masuk.nomor_surat, surat_masuk.file_surat, surat_masuk.dari, dari.full_name AS dari_nama, ke.full_name AS ke_nama, disposisi_user.status, disposisi_user.ke_user_id')
        ->join('surat_masuk', 'surat_masuk.id = disposisi.surat_id', 'left')
        ->join('users as dari', 'dari.id = disposisi.dari_user_id', 'left')
        ->join('disposisi_user', 'disposisi_user.disposisi_id = disposisi.id', 'left')
        ->join('users as ke', 'ke.id = disposisi_user.ke_user_id', 'left')
=======
    $disposisi = $this->DisposisiModel
        ->select('disposisi.*, surat_masuk.nomor_surat, surat_masuk.file_surat, surat_masuk.dari, dari.full_name AS dari_nama')
        ->join('surat_masuk', 'surat_masuk.id = disposisi.surat_id')
        ->join('users as dari', 'dari.id = disposisi.dari_user_id')
>>>>>>> a2b31bd635cdc5ebfe38673510c2d7bdbde1b4cf
        ->where('disposisi.id', $id)
        ->get()
        ->getRowArray();
    
    if (!$disposisi) {
        session()->setFlashdata('error', 'Disposisi tidak ditemukan');
        return redirect()->to(base_url('admin/disposisi'));
    }
    
    // Ambil list users untuk dropdown
    $usersList = $db->table('users')
        ->select('id, full_name as nama')
        ->where('role', 'user') // ✅ Hanya user biasa
        ->get()
        ->getResultArray();
    
    return view('admin/disposisi/edit', [
        'disposisi' => $disposisi,
        'usersList' => $usersList,
        'validation' => session()->get('validation') ?? \Config\Services::validation()
    ]);
}

public function update($id)
{
    $db = Database::connect();

    // DEBUG #1: Pastikan fungsi terpanggil
    log_message('debug', 'DEBUG: Masuk ke fungsi update() dengan ID: ' . $id);
    // Optional: langsung berhenti untuk memastikan
    // die('Masuk ke fungsi update()');

    // DEBUG #2: Tampilkan semua data POST
    log_message('debug', 'DEBUG: Data POST: ' . print_r($this->request->getPost(), true));

    // Validasi input
    $validation = \Config\Services::validation();
    $validation->setRules([
        'ke_user_id' => 'required|numeric',
        'catatan' => 'required|min_length[5]'
    ], [
        'ke_user_id' => [
            'required' => 'Penerima disposisi harus dipilih',
            'numeric' => 'Penerima disposisi tidak valid'
        ],
        'catatan' => [
            'required' => 'Catatan disposisi harus diisi',
            'min_length' => 'Catatan minimal 5 karakter'
        ]
    ]);

    if (!$validation->withRequest($this->request)->run()) {
        // DEBUG #3: Validasi gagal, log error
        log_message('debug', 'DEBUG: Validasi GAGAL');
        log_message('debug', 'DEBUG: Error: ' . print_r($validation->getErrors(), true));

        session()->setFlashdata('validation', $validation);
        return redirect()->back()->withInput();
    }

    try {
        $data = [
            'catatan' => $this->request->getPost('catatan'),

        ];

        log_message('debug', 'DEBUG: Data untuk update disposisi: ' . print_r($data, true));

        // Update disposisi
        $db->table('disposisi')->where('id', $id)->update($data);

        $disposisiUserData = [
            'ke_user_id' => $this->request->getPost('ke_user_id'),
            'status' => 'belum dibaca',
            'dibaca_pada' => null
        ];

        log_message('debug', 'DEBUG: Data untuk update disposisi_user: ' . print_r($disposisiUserData, true));

        $db->table('disposisi_user')->where('disposisi_id', $id)->update($disposisiUserData);

        session()->setFlashdata('success', 'Disposisi berhasil diperbarui');

        log_message('debug', 'DEBUG: Update BERHASIL. Redirect ke /admin/disposisi');
        return redirect()->to(base_url('admin/disposisi'));

    } catch (\Exception $e) {
        log_message('error', 'ERROR saat update disposisi: ' . $e->getMessage());

        session()->setFlashdata('error', 'Gagal memperbarui disposisi');
        return redirect()->back()->withInput();
    }
}
<<<<<<< HEAD
=======
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


>>>>>>> a2b31bd635cdc5ebfe38673510c2d7bdbde1b4cf

}
