<?php

namespace App\Models;

use CodeIgniter\Model;

class M_grosir_paket extends Model
{
    protected $table = 'produk_paket_grosir';
    protected $primaryKey = 'id_produk_paket';
    protected $allowedFields = ['produk_id', 'id_paket', 'id_toko', 'harga', 'jenis_harga'];


    public function phgPpg()
    {
        // Lakukan join antara tabel produk dan stok_toko berdasarkan produk_id
        // $builder = $this->db->table('paket_harga_grosir');
        $builder = $this->db->table('produk_paket_grosir');
        $builder->select('*');
        $builder->join('paket_harga_grosir', 'produk_paket_grosir.id_paket = paket_harga_grosir.id_paket', 'left');
        $builder->where('produk_paket_grosir.id_toko', user()->toko);
        $builder->orderBy('paket_harga_grosir.jenis_paket', 'ASC');

        // Eksekusi query
        $query = $builder->get();

        // Mengembalikan hasil query
        return $query->getResult();
    }
}
