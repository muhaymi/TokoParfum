<?php

namespace App\Models;

use CodeIgniter\Model;

class M_presensi extends Model
{
    protected $table = 'presensi';
    protected $primaryKey = 'id_presensi';
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';


    protected $allowedFields = [
        'foto_presensi', 'presensi_userid', 'foto_presensi', 'presensi_nama_toko', 'waktu_presensi', 'nama_presensi'

    ];
}
