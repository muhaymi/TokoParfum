<?php

namespace App\Models;

use CodeIgniter\Model;

class M_member extends Model
{
    protected $table = 'member';
    protected $primaryKey = 'id_member';
    protected $useTimestamps = true;

    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $allowedFields = [
        'id_member', 'nama_member', 'alamat_member', 'no_hp', 'toko_id', 'tipe_member'
    ];
}
