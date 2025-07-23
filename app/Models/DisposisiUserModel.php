<?php

namespace App\Models;

use CodeIgniter\Model;

class DisposisiUserModel extends Model
{
    protected $table = 'disposisi_user';
    protected $primaryKey = 'id';
    protected $allowedFields = ['disposisi_id', 'ke_user_id', 'status'];
    public $timestamps = false;
}
