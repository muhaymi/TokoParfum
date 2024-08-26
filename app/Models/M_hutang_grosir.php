<?php

namespace App\Models;

use CodeIgniter\Model;

class M_hutang_grosir extends Model
{
    protected $table = 'hutang_grosir';
    protected $primaryKey = 'id_hutang_grosir';
    protected $useTimestamps = true;

    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';


    protected $allowedFields = ['hutang_sebelumnya', 'membayar', 'hutang_sekarang', 'id_penjualan'];
}
