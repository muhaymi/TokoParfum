<?php

namespace App\Controllers;

use App\Models\M_toko;
use App\Models\M_data_produk;


class Toko extends BaseController
{

    // toko
    public function toko()
    {
        $data['segment'] = 'Store';

        // $userModel = new M_user();
        $tokoModel = new M_toko();

        $data['tokoAll']  = $tokoModel->findAll();



        $data['title'] = 'Toko';
        // $data['users'] = $userModel->getUsersWithGroups();

        return view('pages/toko.php', $data);
    }


    public function toko_baru()
    {
        // dd($_POST);

        $tokoModel = new M_toko();

        $logo = $this->request->getFile('logo_toko');

        if ($logo->isValid() && !$logo->hasMoved()) {
            $newName = 'logo_' . uniqid() . '.jpg';;
            $logo->move(ROOTPATH . 'public/logo', $newName);
        }

        $data = [
            'nama_toko' => $this->request->getPost('nama_toko'),
            'alamat_toko' => $this->request->getPost('alamat_toko'),
            'hp_toko' => $this->request->getPost('hp_toko'),
            'email_toko' => $this->request->getPost('email_toko'),
            'logo_toko' => $newName ?? 'logo.png',
        ];
        // dd($newName);

        $tokoModel->insert($data);

        $successMessage = 'Data berhasil disimpan!';
        session()->setFlashdata('success', $successMessage);

        return redirect()->back()->with('reload', true);
    }

    public function ubah_toko()
    {

        $tokoModel = new M_toko();

        $id = $this->request->getPost('id_toko');
        $logos = $this->request->getPost('logo_toko_s');
        $logo = $this->request->getFile('logo_toko');

        if ($logo->isValid() && !$logo->hasMoved()) {
            $newName = 'logo_' . uniqid() . '.png';;
            $logo->move(ROOTPATH . 'public/logo', $newName);
        }

        $data = [
            'nama_toko' => $this->request->getPost('nama_toko'),
            'alamat_toko' => $this->request->getPost('alamat_toko'),
            'hp_toko' => $this->request->getPost('hp_toko'),
            'email_toko' => $this->request->getPost('email_toko'),
            'sup_acc' => $this->request->getPost('sup_acc'),
            'logo_toko' => $newName ?? $logos,
        ];

        $tokoModel->update($id, $data);

        $successMessage = 'Data berhasil diubah!';
        session()->setFlashdata('success', $successMessage);

        return redirect()->back()->with('reload', true);
    }


    public function hapus_toko($id)
    {

        // dd($_POST);
        $tokoModel = new M_toko();

        $tokoModel->delete($id);

        $successMessage = 'Data berhasil dihapus!';
        session()->setFlashdata('success', $successMessage);

        return redirect()->back()->with('reload', true);
    }
}
