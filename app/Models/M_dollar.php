<?php

namespace App\Models;

use CodeIgniter\Model;

class M_dollar extends Model
{
    protected $table = 'dollar';
    protected $primaryKey = 'id_harga';

    protected $allowedFields = [
        'harga_rupiah'

    ];
}
