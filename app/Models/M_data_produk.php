<?php

namespace App\Models;

use CodeIgniter\Model;

class M_data_produk extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';

    protected $allowedFields = [
        'id_produk', 'nama_produk', 'kategori_produk', 'satuan_produk',
    ];

    public function getProdukWithStok()
    {
        // Lakukan join antara tabel produk dan stok_toko berdasarkan produk_id
        $builder = $this->db->table('produk');
        $builder->select('*');
        $builder->join('stok_toko', 'produk.id_produk = stok_toko.produk_id', 'left');
        $builder->where('stok_toko.id_toko', user()->toko);

        // Eksekusi query
        $query = $builder->get();

        // Mengembalikan hasil query
        return $query->getResult();
    }
}
