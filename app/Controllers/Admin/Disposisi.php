<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use Config\Database;
use CodeIgniter\I18n\Time;


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

    // Ambil semua data disposisi, untuk semua role (admin/operator/user)
    $disposisiList = $db->table('disposisi')
            ->select('disposisi.*, surat_masuk.nomor_surat, dari.full_name AS dari_nama, ke.full_name AS ke_nama, disposisi_user.status, disposisi_user.dibaca_pada') // 🟢 Tambahkan ini
            ->join('surat_masuk', 'surat_masuk.id = disposisi.surat_id', 'left')
            ->join('users as dari', 'dari.id = disposisi.dari_user_id', 'left')
            ->join('disposisi_user', 'disposisi_user.disposisi_id = disposisi.id', 'left')
            ->join('users as ke', 'ke.id = disposisi_user.ke_user_id', 'left')
            ->orderBy('disposisi.created_at', 'DESC')
            ->get()
            ->getResultArray();


    return view('admin/disposisi/index', [
        'disposisi' => $disposisiList
    ]);
}

}
