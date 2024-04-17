<?php

namespace App\Controllers;

use App\Models\M_data_produk;
use App\Models\M_stok_toko;


class Produk extends BaseController
{
    public function produk()
    {
        $d_prodModel = new M_data_produk();
        $data['produk'] = $d_prodModel->getProdukWithStok();
        $data['produkAll'] = $d_prodModel->findAll();

        // $data['produk']  = $d_prodModel->findAll();

        return view('produk/data_produk', $data);
    }

    public function simpan_produk()
    {
        // dd($_POST);
        $d_prodModel = new M_data_produk();
        $d_stModel = new M_stok_toko();

        // $gambar = $this->request->getFile('gambar_produk');

        // if ($gambar->isValid() && !$gambar->hasMoved()) {
        //     $newName = 'gambar_' . uniqid() . '.jpg';;
        //     $gambar->move(ROOTPATH . 'public/gambar_produk', $newName);
        // }


        $data = [
            'id_produk' => $this->request->getPost('id_produk'),
            'nama_produk' => $this->request->getPost('nama_produk'),
            'kategori_produk' => $this->request->getPost('kategori_produk'),
            'satuan_produk' => $this->request->getPost('satuan_produk'),
            // 'banyak_produk' => $this->request->getPost('banyak_produk'),
            // 'stok_min_produk' => $this->request->getPost('stok_min_produk'),
            // 'gambar_produk' => $newName ?? 'gambar_produk.png',
        ];

        $data2 = [
            'produk_id' => $this->request->getPost('id_produk'),
            'stok_toko' => $this->request->getPost('banyak_produk'),
            'stok_min' => $this->request->getPost('stok_min_produk'),
            'harga_beli_produk' => $this->request->getPost('harga_beli_produk'),
            'harga_jual_produk' => $this->request->getPost('harga_jual_produk'),
            'id_toko' => user()->toko,
        ];
        // dd($newName);

        $id_produk = $this->request->getPost('id_produk');
        $stok_tokoinp = $this->request->getPost('banyak_produk');

        $db = \Config\Database::connect();

        $query = "SELECT * FROM stok_toko WHERE produk_id = ? AND id_toko = ?";
        $results = $db->query($query, [$id_produk, user()->toko])->getResult();
        $result = $results[0] ?? $results;

        $f = $d_prodModel->find($id_produk);
        // dd($f);

        if (empty($result)) {
            $d_stModel->insert($data2);
            if ($f == null) {
                $d_prodModel->insert($data);
            }
        } else {

            $id_toko = $result->id_toko;
            $stok_toko = $result->stok_toko;

            $byk = floatval($stok_toko) + floatval($stok_tokoinp);
            // dd($byk);

            $query = "UPDATE stok_toko SET stok_toko = ? WHERE produk_id = ? AND id_toko = ?";
            $db->query($query, [$byk, $id_produk, $id_toko]);
        }


        $successMessage = 'Data berhasil disimpan!';
        session()->setFlashdata('success', $successMessage);

        return redirect()->back()->with('reload', true);
    }

    public function ubah_produk()
    {
        // dd($_POST);
        $d_prodModel = new M_data_produk();

        // $gambar = $this->request->getFile('gambar_produk');

        // if ($gambar->isValid() && !$gambar->hasMoved()) {
        //     $newName = 'gambar_' . uniqid() . '.jpg';;
        //     $gambar->move(ROOTPATH . 'public/gambar_produk', $newName);
        // }

        $id_produk = $this->request->getPost('id_produk');
        $stok_toko = $this->request->getPost('banyak_produk');
        $stok_min = $this->request->getPost('stok_min_produk');
        $hbp = $this->request->getPost('harga_beli_produk');
        $hjp = $this->request->getPost('harga_jual_produk');

        $data = [
            'id_produk' => $id_produk,
            'nama_produk' => $this->request->getPost('nama_produk'),
            'kategori_produk' => $this->request->getPost('kategori_produk'),
            'satuan_produk' => $this->request->getPost('satuan_produk'),

            // 'gambar_produk' => $newName ?? $this->request->getPost('gambar_produk_s'),
        ];


        $d_prodModel->update($this->request->getPost('id_produk_s'), $data);

        $db = \Config\Database::connect();

        $query = "UPDATE stok_toko SET stok_toko = ? WHERE produk_id = ? AND id_toko = ?";
        $db->query($query, [$stok_toko, $id_produk, user()->toko]);

        $query = "UPDATE stok_toko SET stok_min = ? WHERE produk_id = ? AND id_toko = ?";
        $db->query($query, [$stok_min, $id_produk, user()->toko]);

        $query = "UPDATE stok_toko SET harga_beli_produk = ? WHERE produk_id = ? AND id_toko = ?";
        $db->query($query, [$hbp, $id_produk, user()->toko]);

        $query = "UPDATE stok_toko SET harga_jual_produk = ? WHERE produk_id = ? AND id_toko = ?";
        $db->query($query, [$hjp, $id_produk, user()->toko]);



        $successMessage = 'Data berhasil diubah!';
        session()->setFlashdata('updates', $successMessage);

        return redirect()->back()->with('reload', true);
    }

    public function hapus_produk($id)
    {
        // dd($_POST);
        // $d_prodModel = new M_data_produk();
        // $d_prodModel->delete($id);

        $db = \Config\Database::connect();


        $query = "DELETE FROM stok_toko WHERE produk_id = ? AND id_toko = ?";
        $db->query($query, [$id, user()->toko]);



        $successMessage = 'Data berhasil dihapus!';
        session()->setFlashdata('deletes', $successMessage);

        return redirect()->back()->with('reload', true);
    }
}
