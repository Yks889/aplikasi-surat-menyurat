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

}
