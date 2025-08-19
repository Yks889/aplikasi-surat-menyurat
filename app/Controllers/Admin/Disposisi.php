<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use Config\Database;
use CodeIgniter\I18n\Time;
use App\Models\DisposisiModel;
use App\Models\UserModel;
use App\Models\SuratMasukModel;

class Disposisi extends BaseController
{
    protected $disposisiModel;
    protected $userModel;
    protected $suratMasukModel;
    protected $helpers = ['form', 'activity'];

    public function __construct()
    {
        $this->disposisiModel = new DisposisiModel();
        $this->userModel = new UserModel();
        $this->suratMasukModel = new SuratMasukModel();
    }

    public function index()
    {
        $db = Database::connect();
        $user = session()->get('user');
        $adminId = $user['id'] ?? null;

        if (!$adminId) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        // Mark as read if user is regular user
        if ($user['role'] === 'user') {
            $db->table('disposisi_user')
                ->where('ke_user_id', $user['id'])
                ->where('status', 'belum dibaca')
                ->update(['status' => 'dibaca', 'dibaca_pada' => Time::now('Asia/Jakarta')]);
        }

        // Get filter parameters
        $filter_bulan = $this->request->getGet('bulan');
        $filter_tahun = $this->request->getGet('tahun');
        $filter_status = $this->request->getGet('status');
        $filter_pengirim = $this->request->getGet('pengirim');

        // Query builder for disposisi
        $builder = $db->table('disposisi')
            ->select('disposisi.*, surat_masuk.nomor_surat, surat_masuk.file_surat, 
                     dari.full_name AS dari_nama, ke.full_name AS ke_nama, 
                     disposisi_user.status, disposisi_user.dibaca_pada')
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

        // Get sender list for filter dropdown
        $pengirimList = $db->table('users')
            ->select('id, full_name as nama')
            ->whereIn('role', ['admin', 'operator'])
            ->get()
            ->getResultArray();

        return view('admin/disposisi/index', [
            'title' => 'Manajemen Disposisi',
            'disposisi' => $disposisiList,
            'pengirimList' => $pengirimList,
            'filter_bulan' => $filter_bulan,
            'filter_tahun' => $filter_tahun,
            'filter_status' => $filter_status,
            'filter_pengirim' => $filter_pengirim,
            'user' => $user
        ]);
    }

    public function delete($id)
    {
        $adminId = session()->get('user')['id'] ?? null;
        if (!$adminId) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $db = Database::connect();
        
        try {
            // Get disposisi data before deletion for logging
            $disposisi = $this->disposisiModel->find($id);
            $surat = $this->suratMasukModel->find($disposisi['surat_id']);

            // Delete from disposisi_user first
            $db->table('disposisi_user')->where('disposisi_id', $id)->delete();
            
            // Then delete from disposisi
            $db->table('disposisi')->where('id', $id)->delete();
            
            // Log activity
            activity_log(
                $adminId,
                'Menghapus Disposisi',
                'Menghapus disposisi untuk surat: ' . ($surat['nomor_surat'] ?? 'unknown'),
                'disposisi'
            );

            session()->setFlashdata('success', 'Disposisi berhasil dihapus');
        } catch (\Exception $e) {
            log_message('error', 'Error deleting disposisi: ' . $e->getMessage());
            session()->setFlashdata('error', 'Gagal menghapus disposisi');
        }
        
        return redirect()->to(base_url('admin/disposisi'));
    }

    public function edit($id)
    {
        $adminId = session()->get('user')['id'] ?? null;
        if (!$adminId) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $disposisi = $this->disposisiModel
            ->select('disposisi.*, surat_masuk.nomor_surat, surat_masuk.file_surat, surat_masuk.dari, dari.full_name AS dari_nama')
            ->join('surat_masuk', 'surat_masuk.id = disposisi.surat_id')
            ->join('users as dari', 'dari.id = disposisi.dari_user_id')
            ->where('disposisi.id', $id)
            ->first();

        if (!$disposisi) {
            return redirect()->back()->with('error', 'Data disposisi tidak ditemukan');
        }

        // Get all non-admin users
        $usersList = $this->userModel
            ->whereNotIn('role', ['admin', 'operator'])
            ->findAll();

        // Get all ke_user_id that have been added to this disposisi
        $db = Database::connect();
        $selectedUserIds = $db->table('disposisi_user')
            ->select('ke_user_id')
            ->where('disposisi_id', $id)
            ->get()
            ->getResultArray();
        $selectedUserIds = array_column($selectedUserIds, 'ke_user_id');

        return view('admin/disposisi/edit', [
            'title' => 'Edit Disposisi',
            'disposisi' => $disposisi,
            'usersList' => $usersList,
            'selectedUserIds' => $selectedUserIds,
            'validation' => session()->get('validation') ?? \Config\Services::validation(),
            'user' => session()->get('user')
        ]);
    }

    public function update($id)
    {
        $adminId = session()->get('user')['id'] ?? null;
        if (!$adminId) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $db = Database::connect();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'ke_user_ids' => 'required',
            'catatan' => 'required|min_length[5]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            session()->setFlashdata('validation', $validation);
            return redirect()->back()->withInput();
        }

        try {
            // Get disposisi and surat data for logging
            $disposisi = $this->disposisiModel->find($id);
            $surat = $this->suratMasukModel->find($disposisi['surat_id']);

            // Update disposisi
            $db->table('disposisi')->where('id', $id)->update([
                'catatan' => $this->request->getPost('catatan'),
                'updated_at' => Time::now('Asia/Jakarta')
            ]);

            // Delete old disposisi_user
            $db->table('disposisi_user')->where('disposisi_id', $id)->delete();

            // Insert new disposisi_user
            $keUserIds = $this->request->getPost('ke_user_ids');
            foreach ($keUserIds as $keUserId) {
                $db->table('disposisi_user')->insert([
                    'disposisi_id' => $id,
                    'ke_user_id' => $keUserId,
                    'status' => 'belum dibaca',
                    'dibaca_pada' => null
                ]);
            }

            // Log activity
            activity_log(
                $adminId,
                'Memperbarui Disposisi',
                'Memperbarui disposisi untuk surat: ' . ($surat['nomor_surat'] ?? 'unknown') . 
                ' ke ' . count($keUserIds) . ' penerima',
                'disposisi'
            );

            session()->setFlashdata('success', 'Disposisi berhasil diperbarui');
            return redirect()->to(base_url('admin/disposisi'));

        } catch (\Exception $e) {
            log_message('error', 'Error updating disposisi: ' . $e->getMessage());
            session()->setFlashdata('error', 'Gagal memperbarui disposisi');
            return redirect()->back()->withInput();
        }
    }

    public function detail($surat_id)
    {
        $user = session()->get('user');
        if (!$user) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $db = Database::connect();
        
        // Get letter data
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

        // Get disposisi data for this letter
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
            'user' => $user
        ]);
    }
}