<?php

namespace App\Controllers;

use App\Models\M_paket;
use App\Models\M_paket_grosir;
use App\Models\M_member;


class Set extends BaseController
{
    // paket eceran
    public function paket_harga()
    {
        $d_pktModel = new M_paket();
        $data['paket']  = $d_pktModel->where('toko_id', user()->toko)->findAll();


        return view('set/paket_harga', $data);
    }

    public function tambah_paket()
    {
        // dd($_POST);
        $d_pktModel = new M_paket();



        $data = [
            'nama_paket' => $this->request->getPost('nama_paket'),
            'jenis_paket' => $this->request->getPost('jenis_paket'),
            'tipe_paket' => $this->request->getPost('tipe_paket'),
            'harga_paket' => $this->request->getPost('harga_paket'),
            'banyak_ml' => $this->request->getPost('banyak_ml'),
            'toko_id' => user()->toko,
        ];
        // dd($newName);

        $d_pktModel->insert($data);

        $successMessage = 'Data berhasil disimpan!';
        session()->setFlashdata('success', $successMessage);

        return redirect()->back()->with('reload', true);
    }

    public function edit_paket()
    {
        // dd($_POST);
        $d_pktModel = new M_paket();

        $data = [
            'nama_paket' => $this->request->getPost('nama_paket'),
            'tipe_paket' => $this->request->getPost('tipe_paket'),
            'jenis_paket' => $this->request->getPost('jenis_paket'),
            'harga_paket' => $this->request->getPost('harga_paket'),
            'banyak_ml' => $this->request->getPost('banyak_ml'),
            'toko_id' => user()->toko,
        ];
        // dd($newName);

        $d_pktModel->update($this->request->getPost('id_paket'), $data);

        $successMessage = 'Data berhasil diubah!';
        session()->setFlashdata('success', $successMessage);

        return redirect()->back()->with('reload', true);
    }

    public function hapus_paket($id)
    {
        // dd($_POST);
        $d_pktModel = new M_paket();

        $d_pktModel->delete($id);

        $successMessage = 'Data berhasil dihapus!';
        session()->setFlashdata('success', $successMessage);

        return redirect()->back()->with('reload', true);
    }

    // member

    public function member()
    {
        $d_pktModel = new M_paket();
        $data['paket']  = $d_pktModel->findAll();


        return view('set/paket_harga', $data);
    }

    public function tambah_member()
    {
        // dd($_POST);
        $d_mbrModel = new M_member();

        $data = [
            'id_member' => $this->request->getPost('id_member'),
            'nama_member' => $this->request->getPost('nama_member'),
            'alamat_member' => $this->request->getPost('alamat_member'),
            'no_hp' => $this->request->getPost('no_hp'),
            'toko_id' => user()->toko,
        ];
        // dd(user()->toko);

        $d_mbrModel->insert($data);

        $successMessage = 'Member berhasil ditambahkan!';
        session()->setFlashdata('success', $successMessage);

        return redirect()->back()->with('reload', true);
    }

    public function edit_member()
    {
        // dd($_POST);
        $d_pktModel = new M_member();

        $data = [
            'id_member' => $this->request->getPost('id_member'),
            'nama_paket' => $this->request->getPost('nama_paket'),
            'tipe_paket' => $this->request->getPost('tipe_paket'),
            'jenis_paket' => $this->request->getPost('jenis_paket'),
            'harga_paket' => $this->request->getPost('harga_paket'),
            'banyak_ml' => $this->request->getPost('banyak_ml'),
        ];
        // dd($newName);

        $d_pktModel->update($this->request->getPost('id_paket'), $data);

        $successMessage = 'Data berhasil diubah!';
        session()->setFlashdata('success', $successMessage);

        return redirect()->back()->with('reload', true);
    }

    public function hapus_member($id)
    {
        // dd($_POST);
        $d_pktModel = new M_paket();

        $d_pktModel->delete($id);

        $successMessage = 'Data berhasil dihapus!';
        session()->setFlashdata('success', $successMessage);

        return redirect()->back()->with('reload', true);
    }

    // paket grosir
    public function paket_harga_grosir()
    {
        $d_pktModel = new M_paket_grosir();
        $data['paket']  = $d_pktModel->where('toko_id', user()->toko)->findAll();


        return view('set/paket_harga_grosir', $data);
    }

    public function tambah_paket_grosir()
    {
        // dd($_POST);
        $d_pktModel = new M_paket_grosir();

        $data = [
            'nama_paket' => $this->request->getPost('nama_paket'),
            'jenis_paket' => $this->request->getPost('jenis_paket'),
            'tipe_paket' => $this->request->getPost('tipe_paket'),
            'toko_id' => user()->toko,
        ];
        // dd($newName);

        $d_pktModel->insert($data);

        $successMessage = 'Data berhasil disimpan!';
        session()->setFlashdata('success', $successMessage);

        return redirect()->back()->with('reload', true);
    }

    public function edit_paket_grosir()
    {
        // dd($_POST);
        $d_pktModel = new M_paket_grosir();

        $data = [
            'nama_paket' => $this->request->getPost('nama_paket'),
            'tipe_paket' => $this->request->getPost('tipe_paket'),
            'jenis_paket' => $this->request->getPost('jenis_paket'),
            'toko_id' => user()->toko,
        ];
        // dd($newName);

        $d_pktModel->update($this->request->getPost('id_paket'), $data);

        $successMessage = 'Data berhasil diubah!';
        session()->setFlashdata('success', $successMessage);

        return redirect()->back()->with('reload', true);
    }

    public function hapus_paket_grosir($id)
    {
        // dd($_POST);
        $d_pktModel = new M_paket_grosir();

        $d_pktModel->delete($id);

        $successMessage = 'Data berhasil dihapus!';
        session()->setFlashdata('success', $successMessage);

        return redirect()->back()->with('reload', true);
    }
}
