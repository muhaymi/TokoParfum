<?php

namespace App\Models;

use CodeIgniter\Model;

class M_ag extends Model
{
    protected $table = 'auth_groups';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'name', 'description'];


    // public function Groups()
    // {
    //     return $this->db->table('auth_groups_users')
    //         ->join('auth_groups AG', 'AG.id = users.id')
    //         // ->join('toko tk', 'tk.id_toko = users.toko')
    //         // ->join('users usr', 'usr.toko = toko.id_toko')
    //         ->join('toko', 'users.toko = toko.id_toko')

    //         ->join('auth_groups AG', 'AG.id = AGU.group_id')
    //         ->get()
    //         ->getResultArray();
    // }
}
