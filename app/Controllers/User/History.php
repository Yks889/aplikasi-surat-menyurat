<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\SuratMasukModel;
use App\Models\SuratKeluarModel;

class History extends BaseController
{
    protected $suratMasukModel;
    protected $suratKeluarModel;

    public function __construct()
    {
        $this->suratMasukModel = new SuratMasukModel();
        $this->suratKeluarModel = new SuratKeluarModel();
    }

    public function suratMasuk()
    {
        $createdBy = session()->get('user')['id'];
        if (!$createdBy) {
            return redirect()->back()->with('error', 'User belum login.');
        }

        
        $data = [
            'title' => 'History Surat Masuk',
            'user' => session()->get(),
            'suratMasuk' => $this->suratMasukModel->getSuratMasukByUser($createdBy)
        ];
        
        return view('user/history/surat_masuk', $data);
    }

}