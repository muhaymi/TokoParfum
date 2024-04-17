<?php

namespace App\Models;

use CodeIgniter\Model;

class M_toko extends Model
{
    protected $table = 'toko';
    protected $primaryKey = 'id_toko';

    protected $allowedFields = [
        'id_toko', 'nama_toko', 'alamat_toko', 'hp_toko', 'email_toko', 'sup_acc', 'logo_toko'
    ];
}
