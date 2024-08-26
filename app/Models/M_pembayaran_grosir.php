<?php

namespace App\Models;

use CodeIgniter\Model;

class M_pembayaran_grosir extends Model
{
    protected $table = 'pembayaran_grosir';
    protected $primaryKey = 'id_pembayaran';
    protected $useTimestamps = true;

    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $allowedFields = [
        'id_penjualan', 'total_bayar', 'jenis_pembayaran', 'membayar', 'status_pembayaran', 'hutang', 'tempo', 'pembeli_id', 'kasir_id', 'toko_id', 'nama_pembeli'
    ];


    public function getBayarWithJual()
    {
        // Lakukan join antara tabel produk dan stok_toko berdasarkan produk_id
        $builder = $this->db->table('pembayaran_grosir');
        $builder->select('*');
        $builder->join('penjualan_grosir', 'penjualan_grosir.id_penjualan = pembayaran_grosir.id_penjualan', 'left');
        // $builder->join('penjualan_grosir', 'penjualan_grosir.id_penjualan = pembayaran.id_penjualan', 'left');

        // Eksekusi query
        $query = $builder->get();

        // Mengembalikan hasil query
        return $query->getResult();
    }
}
