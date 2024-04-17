<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use \Myth\Auth\Entities\User;
use \Myth\Auth\Models\UserModel;
use \Myth\Auth\Authorization\GroupModel;
use \Myth\Auth\Config\Auth as AuthConfig;
use \Myth\Auth\Password;

use App\Models\M_ag;
use App\Models\M_user;


class Pengguna extends BaseController
{
    protected $auth;

    protected $config;
    protected $d_user;
    protected $agModel;

    public function __construct()
    {
        $this->config = config('Auth');
        $this->auth = service('authentication');
        $this->d_user = new M_user();
        $this->agModel = new M_ag();
    }


    public function pengguna()
    {

        $data = [
            'title' => 'Data Pengguna',
            'config' => $this->config,
            'user' => $this->d_user->findAll(),


        ];


        // dd($this->groupModel->findAll());
        return view('pengguna/data_pengguna', $data);
    }

    public function simpan_pengguna()
    {
        $users = model(UserModel::class);

        $rules = [
            'username' => 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $rules = [
            'password'     => 'required|strong_password',
            'pass_confirm' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Save the user
        $allowedPostFields = array_merge(['password'], $this->config->validFields, $this->config->personalFields);
        $user = new User($this->request->getPost($allowedPostFields));

        $this->config->requireActivation === null ? $user->activate() : $user->generateActivateHash();

        // Ensure default group gets assigned if set
        if (!empty($this->config->defaultUserGroup)) {
            $users = $users->withGroup($this->config->defaultUserGroup);
        }

        if (!$users->save($user)) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }

        if ($this->config->requireActivation !== null) {
            $activator = service('activator');
            $sent = $activator->send($user);

            if (!$sent) {
                return redirect()->back()->withInput()->with('error', $activator->error() ?? lang('Auth.unknownError'));
            }

            // Success!
            $successMessage = 'Data berhasil disimpan!';
            session()->setFlashdata('success', $successMessage);

            return redirect()->back()->with('reload', true);
        }

        // Success!
        $successMessage = 'Data berhasil disimpan!';
        session()->setFlashdata('success', $successMessage);

        return redirect()->back()->with('reload', true);
    }

    public function ubah_PW()
    {
        $id = $this->request->getVar('user_id');
        $rules = [
            'password'     => 'required|strong_password',
            'pass_confirm' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            $data = [
                'id' => $id,
                'title' => 'Update Password',
                'validation' => $this->validator,
            ];

            // unsuccess!
            $successMessage = 'Password gagal diubah!';
            session()->setFlashdata('unsuccess', $successMessage);

            return redirect()->back()->with('reload', true);
        } else {
            $userModel = new UserModel();
            $data = [
                'password_hash' => Password::hash($this->request->getVar('password')),
                'reset_hash' => null,
                'reset_at' => null,
                'reset_expires' => null,
            ];
            $userModel->update($this->request->getVar('user_id'), $data);

            // Success!
            $successMessage = 'Password berhasil diubah!';
            session()->setFlashdata('success', $successMessage);

            return redirect()->back()->with('reload', true);
        }
    }

    public function hapus_pengguna($id)
    {
        // dd($_POST);

        $this->d_user->delete($id);

        $successMessage = 'Data berhasil dihapus!';
        session()->setFlashdata('success', $successMessage);

        return redirect()->back()->with('reload', true);
    }
}
