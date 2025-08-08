<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use Config\Database;

class Disposisi extends BaseController
{
    public function index()
{
    $db = Database::connect();
    $userId = session()->get('user')['id'];

    // ✅ Update status dan catat waktu dibaca
    $db->table('disposisi_user')
        ->where('ke_user_id', $userId)
        ->where('status', 'belum dibaca')
        ->update([
            'status' => 'dibaca',
            'dibaca_pada' => date('Y-m-d H:i:s')
        ]);

    // 🔄 Ambil data disposisi yang masuk
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

    return view('user/disposisi/index', [
        'disposisi' => $query
    ]);
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

        // Ambil data disposisi untuk surat ini, hanya untuk user yang sedang login
        $currentUserId = session()->get('user')['id'];
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

        return view('user/disposisi/detail', [
            'title' => 'Detail Disposisi Surat',
            'surat' => $surat,
            'disposisi' => $disposisiList,
            'user' => session()->get('user')
        ]);
    }

}
