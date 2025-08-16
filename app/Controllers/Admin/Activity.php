<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use Config\Database;

class Activity extends BaseController
{
    public function index()
    {
        $db = Database::connect();
        $activity = $db->table('user_activity')
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResult();

        return view('admin/activity/index', [
            'title' => 'Activity User',
            'activity' => $activity
        ]);
    }
}
