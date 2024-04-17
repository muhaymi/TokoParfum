<?php

namespace App\Models;

use CodeIgniter\Model;

class M_data_produk_grosir extends Model
{
    protected $table = 'produk_grosir';
    protected $primaryKey = 'id_produk';

    protected $allowedFields = [
        'id_produk', 'nama_produk', 'kategori_produk', 'satuan_produk',
    ];

    public function getProdukGrosirWithStok()
    {
        // Lakukan join antara tabel produk dan stok_toko berdasarkan produk_id
        $builder = $this->db->table('produk_grosir');
        $builder->select('*');
        $builder->join('stok_toko_grosir', 'produk_grosir.id_produk = stok_toko_grosir.produk_id', 'left');
        // $builder->join('produk_paket_grosir', 'produk_grosir.id_produk = produk_paket_grosir.produk_id', 'left');
        $builder->where('stok_toko_grosir.id_toko', user()->toko);

        // Eksekusi query
        $query = $builder->get();

        // Mengembalikan hasil query
        return $query->getResult();
    }
}
