<?php

namespace App\Models;

use CodeIgniter\Model;

class M_ag extends Model
{
    protected $table = 'auth_groups';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'name', 'description'];
}
