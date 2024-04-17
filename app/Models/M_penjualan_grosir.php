<?php

namespace App\Models;

use CodeIgniter\Model;

class M_penjualan_grosir extends Model
{
    protected $table = 'penjualan_grosir';
    protected $primaryKey = 'id_jual';
    protected $useTimestamps = true;

    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $allowedFields = [
        'id_penjualan', 'produk_id', 'paket_id', 'banyak', 'harga_produk', 'harga_awal', 'diskon', 'harga_jadi', 'kasir_id', 'toko_id', 'keterangan', 'pembeli_id'
    ];
}
