<?php

namespace App\Models;

use CodeIgniter\Model;

class M_waktu_absen extends Model
{
    protected $table = 'set_waktu_absen';
    protected $primaryKey = 'id_waktuAbsen';

    protected $allowedFields = [
        'waktu_absen', 'waktu_mulai'

    ];
}
