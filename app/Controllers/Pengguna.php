<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use \Myth\Auth\Entities\User;
use \Myth\Auth\Models\UserModel;
use \Myth\Auth\Authorization\GroupModel;
use \Myth\Auth\Config\Auth as AuthConfig;

use \Myth\Auth\Password;

use App\Models\M_toko;
use App\Models\M_user;
use App\Models\M_ag;


class Pengguna extends BaseController
{

    protected $auth;
    /**
     * @var AuthConfig
     */
    protected $config;

    // protected $config;
    protected $d_user;
    protected $d_toko;
    protected $d_ag;

    public function __construct()
    {

        $this->config = config('Auth');
        $this->auth = service('authentication');
        $this->d_toko = new M_toko();
        $this->d_user = new M_user();
        $this->d_ag = new M_ag();
    }


    public function pengguna()
    {

        $data = [
            'title' => 'Data Pengguna',
            'config' => $this->config,
            'user' => $this->d_user->getUsersWithGroups(),
            'toko' => $this->d_toko->findAll(),
            'ag' => $this->d_ag->findAll(),

        ];


        // dd($this->groupModel->findAll());
        // dd($this->d_user->getUsersWithGroups());

        return view('pengguna/data_pengguna', $data);
    }


    public function simpan_pengguna()
    {
        $users = new UserModel();

        $rules = [
            'username' => 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|strong_password',
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


    public function ubah_data_pengguna()
    {
        // dd($_POST);

        $db = \Config\Database::connect();
        $id_user = $this->request->getPost('id_user');
        $id_agu = $this->request->getPost('id_agu');
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $nope = $this->request->getPost('nope');
        $role = $this->request->getPost('role');
        $toko = $this->request->getPost('toko');

        $query1 = "UPDATE users 
        SET email = ?,
        username = ?,
        no_hp = ?,
        toko = ?
        WHERE id = ? ";
        // WHERE id = ? AND id_jual = ?";

        $db->query($query1, [$email, $username, $nope, $toko, $id_user]);



        $query2 = "UPDATE auth_groups_users 
        SET group_id = ?,
        user_id = ?
        WHERE id_AGU = ? ";

        $db->query($query2, [$role, $id_user, $id_agu]);

        $successMessage = 'Data berhasil diubah!';
        session()->setFlashdata('success', $successMessage);

        return redirect()->back()->with('reload', true);
    }


    public function ubah_data_ku()
    {
        // dd($_POST);

        $db = \Config\Database::connect();
        $id_user = $this->request->getPost('id');
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $nope = $this->request->getPost('phone');
        $fl = $this->request->getPost('foto_lama');

        $fb = $this->request->getFile('foto_baru');

        if ($fb->isValid() && !$fb->hasMoved()) {
            $newName = 'fotoku_' . uniqid() . '.png';;
            $fb->move(ROOTPATH . 'public/pengguna', $newName);
        }


        $query1 = "UPDATE users 
        SET email = ?,
        username = ?,
        no_hp = ?,
        foto_profile = ?
        WHERE id = ? ";
        // WHERE id = ? AND id_jual = ?";

        $db->query($query1, [$email, $username, $nope, $newName ?? $fl, $id_user]);


        $successMessage = 'Data berhasil diubah!';
        session()->setFlashdata('success', $successMessage);

        return redirect()->back()->with('reload', true);
    }
}
