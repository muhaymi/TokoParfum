<?php

namespace App\Models;

use CodeIgniter\Model;

class M_keuangan_grosir extends Model
{
    protected $table = 'keuangan_grosir';
    protected $primaryKey = 'id';
    protected $allowedFields = ['jenis', 'jumlah', 'deskripsi', 'tanggal'];
}
