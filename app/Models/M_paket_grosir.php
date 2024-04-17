<?php

namespace App\Models;

use CodeIgniter\Model;

class M_paket_grosir extends Model
{
    protected $table = 'paket_harga_grosir';
    protected $primaryKey = 'id_paket';

    protected $allowedFields = [
        'nama_paket', 'jenis_paket', 'tipe_paket', 'toko_id'
    ];
}
