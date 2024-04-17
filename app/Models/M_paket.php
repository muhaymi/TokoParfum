<?php

namespace App\Models;

use CodeIgniter\Model;

class M_paket extends Model
{
    protected $table = 'paket_harga';
    protected $primaryKey = 'id_paket';

    protected $allowedFields = [
        'nama_paket', 'jenis_paket', 'tipe_paket', 'harga_paket', 'banyak_ml','toko_id'
    ];
}
