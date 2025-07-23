<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\SuratMasukModel;
use App\Models\ActivityModel;


class Dashboard extends BaseController
{
    protected $suratMasukModel;
    protected $suratKeluarModel;

    public function __construct()
    {
        $this->suratMasukModel  = new SuratMasukModel();
    }

    public function index()
{
    $createdBy = session()->get('user')['id'];
    if (!$createdBy) {
        return redirect()->back()->with('error', 'User belum login.');
    }

    $activityModel = new ActivityModel();

    $data = [
        'title'             => 'Dashboard User',
        'user'              => session()->get(),
        'totalSuratMasuk'   => $this->suratMasukModel->where('created_by', $createdBy)->countAllResults(),
        'totalDisposisi'    => 0,
        'recentActivities'  => $activityModel->where('user_id', $createdBy)
                                              ->orderBy('created_at', 'DESC')
                                              ->limit(5)
                                              ->findAll(),
    ];

    return view('user/dashboard', $data);
}

}
