<?php

namespace App\Models;

use CodeIgniter\Model;

class M_role extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $created_at = true;
    protected $updated_at = true;
    protected $deleted_at = true;

    protected $allowedFields = [
        'name', 'description'
      ];
}
	
	
	