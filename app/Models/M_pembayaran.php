<?php

namespace App\Models;

use CodeIgniter\Model;

class M_pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';
    protected $useTimestamps = true;

    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $allowedFields = [
        'id_penjualan', 'total_bayar', 'jenis_pembayaran', 'membayar', 'status_pembayaran', 'hutang', 'tempo'
    ];


    public function getBayarWithJual()
    {
        // Lakukan join antara tabel produk dan stok_toko berdasarkan produk_id
        $builder = $this->db->table('pembayaran');
        $builder->select('*');
        $builder->join('penjualan_eceran', 'penjualan_eceran.id_penjualan = pembayaran.id_penjualan', 'left');
        // $builder->join('penjualan_grosir', 'penjualan_grosir.id_penjualan = pembayaran.id_penjualan', 'left');

        // Eksekusi query
        $query = $builder->get();

        // Mengembalikan hasil query
        return $query->getResult();
    }
}
