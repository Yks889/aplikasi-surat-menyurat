<?php
namespace App\Controllers\Operator;

use App\Controllers\BaseController;
use Config\Database;

class Disposisi extends BaseController
{
    public function index()
    {
        $db = Database::connect();

        $disposisiList = $db->table('disposisi')
            ->select('disposisi.*, surat_masuk.nomor_surat, dari.full_name AS dari_nama, ke.full_name AS ke_nama, disposisi_user.status')
            ->join('surat_masuk', 'surat_masuk.id = disposisi.surat_id', 'left')
            ->join('users as dari', 'dari.id = disposisi.dari_user_id', 'left') // GANTI jadi LEFT JOIN
            ->join('disposisi_user', 'disposisi_user.disposisi_id = disposisi.id', 'left')
            ->join('users as ke', 'ke.id = disposisi_user.ke_user_id', 'left')
            ->orderBy('disposisi.created_at', 'DESC')
            ->get()
            ->getResultArray();

        return view('operator/disposisi/index', [
            'disposisi' => $disposisiList
        ]);
    }
}
