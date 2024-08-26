<?php

namespace App\Models;

use CodeIgniter\Model;

class M_user extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $created_at = true;
    protected $updated_at = true;
    protected $deleted_at = true;

    protected $allowedFields = [
        'email', 'username', 'no_hp', 'foto_profile', 'toko', 'password_hash', 'reset_hash', 'reset_at', 'reset_expires', 'activate_hash', 'status', 'status_message', 'active', 'force_pass_reset'
    ];



    public function getUsersWithGroups()
    {
        return $this->db->table('users')
            ->join('auth_groups_users AGU', 'AGU.user_id = users.id')
            // ->join('toko tk', 'tk.id_toko = users.toko')
            // ->join('users usr', 'usr.toko = toko.id_toko')
            ->join('toko', 'users.toko = toko.id_toko')

            ->join('auth_groups AG', 'AG.id = AGU.group_id')
            ->get()
            ->getResultArray();
    }
}
