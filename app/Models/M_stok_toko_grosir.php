<?php

namespace App\Models;

use CodeIgniter\Model;

class M_stok_toko_grosir extends Model
{
    protected $table = 'stok_toko_grosir';
    protected $primaryKey = 'id_stok_toko';

    protected $allowedFields = [
        'produk_id', 'stok_min', 'stok_toko', 'id_toko', 'harga_jual_produk', 'harga_beli_produk', 'jenis_harga'
    ];
}
