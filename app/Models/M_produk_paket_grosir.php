<?php

namespace App\Models;

use CodeIgniter\Model;

class M_produk_paket_grosir extends Model
{
    protected $table = 'produk_paket_grosir';
    protected $primaryKey = 'id_produk_paket';

    protected $allowedFields = [
        'produk_id', 'id_paket', 'id_toko', 'harga', 'jenis_harga'
    ];


    public function getPktWithMpg()
    {
        // Lakukan join antara tabel produk dan stok_toko berdasarkan produk_id
        $builder = $this->db->table('produk_paket_grosir');
        $builder->select('*');
        $builder->join('paket_harga_grosir', 'paket_harga_grosir.id_paket = produk_paket_grosir.id_paket', 'left');

        // Eksekusi query
        $query = $builder->get();

        // Mengembalikan hasil query
        return $query->getResult();
    }
}
