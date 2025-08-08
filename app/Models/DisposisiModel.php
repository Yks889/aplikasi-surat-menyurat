<?php

namespace App\Models;

use CodeIgniter\Model;

class DisposisiModel extends Model
{
    protected $table = 'disposisi';
    protected $primaryKey = 'id';
    protected $allowedFields = ['surat_id', 'dari_user_id', 'catatan', 'created_at'];
    protected $useTimestamps = false;

}
