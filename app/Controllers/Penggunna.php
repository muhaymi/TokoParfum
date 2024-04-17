<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\M_user;
use \Myth\Auth\Models\UserModel;
use \Myth\Auth\Password;


class Pengguna extends BaseController
{
    public function editPassword($userId)
    {
        // Kirim data pengguna ke view
        $data['userId'] = $userId;
        return view('pengguna/edit_pw', $data);
    }

    public function updatePassword()
    {
        $id = $this->request->getVar('user_id');
        $rules = [
            'password'     => 'required|strong_password',
            'pass_confirm' => 'required|matches[password]',
        ];
 
        if (! $this->validate($rules))
        {
            $data = [            
                'id' => $id,
                'title' => 'Update Password',
                'validation' => $this->validator,
            ];
 
            return view('users/set_password', $data);
        }
        else
        {
            $userModel = new UserModel();
            $data = [            
                'password_hash' => Password::hash($this->request->getVar('password')),
                'reset_hash' => null,
                'reset_at' => null,
                'reset_expires' => null,
            ];
            $userModel->update($this->request->getVar('user_id'), $data);  
 
            return redirect()->to(base_url('/users/index'));
        }
    }
}

