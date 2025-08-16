<?php

namespace App\Controllers\Operator;

use App\Controllers\BaseController;
use App\Models\DisposisiModel;
use App\Models\UserModel;
use App\Models\SuratMasukModel;
use App\Models\PerusahaanModel;
use Config\Database;
use Config\Services;
use CodeIgniter\I18n\Time;

class Disposisi extends BaseController
{
    protected $disposisiModel;
    protected $userModel;
    protected $suratMasukModel;
    protected $perusahaanModel;
    protected $helpers = ['form', 'activity'];

    public function __construct()
    {
        $this->disposisiModel = new DisposisiModel();
        $this->userModel = new UserModel();
        $this->suratMasukModel = new SuratMasukModel();
        $this->perusahaanModel = new PerusahaanModel();
    }

    public function index()
    {
        $db = Database::connect();
        $user = session()->get('user');

        // Update status for user role
        if ($user && $user['role'] === 'user') {
            $db->table('disposisi_user')
                ->where('ke_user_id', $user['id'])
                ->where('status', 'belum dibaca')
                ->update([
                    'status' => 'dibaca',
                    'dibaca_pada' => date('Y-m-d H:i:s')
                ]);
        }

        // Get filter parameters
        $filterBulan = $this->request->getGet('bulan');
        $filterTahun = $this->request->getGet('tahun');
        $filterStatus = $this->request->getGet('status');
        $filterPengirim = $this->request->getGet('pengirim');

        // Build query
        $builder = $db->table('disposisi')
            ->select('
                disposisi.id,
                disposisi.catatan,
                disposisi.created_at,
                surat_masuk.id as surat_id,
                surat_masuk.nomor_surat,
                surat_masuk.file_surat,
                dari.full_name AS dari_nama,
                ke.full_name AS ke_nama,
                disposisi_user.status,
                disposisi_user.dibaca_pada
            ')
            ->join('surat_masuk', 'surat_masuk.id = disposisi.surat_id', 'left')
            ->join('users as dari', 'dari.id = disposisi.dari_user_id', 'left')
            ->join('disposisi_user', 'disposisi_user.disposisi_id = disposisi.id', 'left')
            ->join('users as ke', 'ke.id = disposisi_user.ke_user_id', 'left');

        // Apply filters
        if ($filterBulan) {
            $builder->where('MONTH(disposisi.created_at)', $filterBulan);
        }
        if ($filterTahun) {
            $builder->where('YEAR(disposisi.created_at)', $filterTahun);
        }
        if ($filterStatus) {
            $builder->where('disposisi_user.status', $filterStatus);
        }
        if ($filterPengirim) {
            $builder->where('disposisi.dari_user_id', $filterPengirim);
        }

        $disposisiList = $builder->orderBy('disposisi.created_at', 'DESC')
            ->get()
            ->getResultArray();

        // Get list of senders (admin/operator)
        $pengirimList = $db->table('users')
            ->select('id, full_name as nama')
            ->whereIn('role', ['admin', 'operator'])
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Manajemen Disposisi',
            'user' => $user,
            'disposisi' => $disposisiList,
            'pengirimList' => $pengirimList,
            'filter_bulan' => $filterBulan,
            'filter_tahun' => $filterTahun,
            'filter_status' => $filterStatus,
            'filter_pengirim' => $filterPengirim
        ];

        return view('operator/disposisi/index', $data);
    }

    public function detail($surat_id)
    {
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

        // Get all dispositions for this letter
        $disposisiList = $db->table('disposisi')
            ->select('
                disposisi.*,
                dari.full_name as dari_nama,
                ke.full_name as ke_nama,
                disposisi_user.status,
                disposisi_user.dibaca_pada
            ')
            ->join('users as dari', 'dari.id = disposisi.dari_user_id', 'left')
            ->join('disposisi_user', 'disposisi_user.disposisi_id = disposisi.id', 'left')
            ->join('users as ke', 'ke.id = disposisi_user.ke_user_id', 'left')
            ->where('disposisi.surat_id', $surat_id)
            ->orderBy('disposisi.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Detail Disposisi Surat',
            'user' => session()->get('user'),
            'surat' => $surat,
            'disposisi' => $disposisiList
        ];

        return view('operator/disposisi/detail', $data);
    }

    public function edit($id)
    {
        $disposisi = $this->disposisiModel
            ->select('
                disposisi.*,
                surat_masuk.nomor_surat,
                surat_masuk.file_surat,
                surat_masuk.dari,
                dari.full_name AS dari_nama
            ')
            ->join('surat_masuk', 'surat_masuk.id = disposisi.surat_id')
            ->join('users as dari', 'dari.id = disposisi.dari_user_id')
            ->where('disposisi.id', $id)
            ->first();

        if (!$disposisi) {
            return redirect()->back()->with('error', 'Data disposisi tidak ditemukan');
        }

        // Get regular users (non-admin/operator)
        $usersList = $this->userModel
            ->whereNotIn('role', ['admin', 'operator'])
            ->findAll();

        // Get currently selected users for this disposition
        $db = Database::connect();
        $selectedUserIds = $db->table('disposisi_user')
            ->select('ke_user_id')
            ->where('disposisi_id', $id)
            ->get()
            ->getResultArray();
        $selectedUserIds = array_column($selectedUserIds, 'ke_user_id');

        $data = [
            'title' => 'Edit Disposisi',
            'user' => session()->get('user'),
            'disposisi' => $disposisi,
            'usersList' => $usersList,
            'selectedUserIds' => $selectedUserIds,
            'validation' => Services::validation()
        ];

        return view('operator/disposisi/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'ke_user_ids' => 'required',
            'catatan' => 'required|min_length[5]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $db = Database::connect();
        $db->transStart();

        try {
            // Update disposition data
            $db->table('disposisi')
                ->where('id', $id)
                ->update([
                    'catatan' => $this->request->getPost('catatan')
                ]);

            // Remove existing user dispositions
            $db->table('disposisi_user')
                ->where('disposisi_id', $id)
                ->delete();

            // Add new user dispositions
            $keUserIds = $this->request->getPost('ke_user_ids');
            foreach ($keUserIds as $keUserId) {
                $db->table('disposisi_user')->insert([
                    'disposisi_id' => $id,
                    'ke_user_id' => $keUserId,
                    'status' => 'belum dibaca',
                    'dibaca_pada' => null
                ]);
            }

            $db->transComplete();

            // Log activity
            activity_log(
                session()->get('user')['id'],
                'Mengupdate Disposisi',
                'Memperbarui data disposisi ID: ' . $id,
                'disposisi'
            );

            return redirect()->to('/operator/disposisi')->with('message', 'Disposisi berhasil diperbarui');
        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Error updating disposition: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui disposisi');
        }
    }

    public function delete($id)
    {
        $db = Database::connect();
        $db->transStart();

        try {
            // Delete from disposisi_user first
            $db->table('disposisi_user')
                ->where('disposisi_id', $id)
                ->delete();

            // Then delete from disposisi
            $db->table('disposisi')
                ->where('id', $id)
                ->delete();

            $db->transComplete();

            // Log activity
            activity_log(
                session()->get('user')['id'],
                'Menghapus Disposisi',
                'Menghapus data disposisi ID: ' . $id,
                'disposisi'
            );

            return redirect()->to('/operator/disposisi')->with('message', 'Disposisi berhasil dihapus');
        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Error deleting disposition: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus disposisi');
        }
    }
}