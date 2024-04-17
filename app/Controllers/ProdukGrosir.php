<?php

namespace App\Controllers;

use App\Models\M_data_produk_grosir;
use App\Models\M_stok_toko_grosir;
use App\Models\M_paket_grosir;
use App\Models\M_grosir_paket;
use App\Models\M_produk_paket_grosir;


class ProdukGrosir extends BaseController
{
    public function produk_grosir()
    {
        $d_prodModel = new M_data_produk_grosir();
        $data['produk'] = $d_prodModel->getProdukGrosirWithStok();
        $data['produkAll'] = $d_prodModel->findAll();

        $d_pktModel = new M_paket_grosir();
        $data['paket']  = $d_pktModel->findAll();

        $d_mpgModel = new M_produk_paket_grosir();
        // $data['mpg']  = $d_mpgModel->findAll();
        $data['mpg']  = $d_mpgModel->getPktWithMpg();

        // dd($data['mpg'] );

        return view('produk/data_produk_grosir', $data);
    }

    public function simpan_produk_grosir()
    {

        $keys = array_keys($_POST);
        $db = \Config\Database::connect();

        $query = $db->query("SELECT id_paket FROM paket_harga_grosir");
        $results1 = $query->getResult();
        $jenis_paket_array = array();
        $key_array = array();

        foreach ($results1 as $row) {
            $jenis_paket_array[] = strval($row->id_paket);
        }
        foreach ($keys as $key) {
            $key_array[] = strval($key);
        }

        $nilai_sama = array_intersect($jenis_paket_array, $key_array);
        $nilai_sama_values = array_values($nilai_sama);

        $d_prodModel = new M_data_produk_grosir();
        $d_stModel = new M_stok_toko_grosir();
        $d_mgpModel = new M_grosir_paket();


        $data = [
            'id_produk' => $this->request->getPost('id_produk'),
            'nama_produk' => $this->request->getPost('nama_produk'),
            'kategori_produk' => $this->request->getPost('kategori_produk'),
            'satuan_produk' => $this->request->getPost('satuan_produk'),
        ];

        $data2 = [
            'produk_id' => $this->request->getPost('id_produk'),
            'stok_toko' => $this->request->getPost('banyak_produk'),
            'stok_min' => $this->request->getPost('stok_min_produk'),
            'harga_beli_produk' => $this->request->getPost('harga_beli_produk'),
            'harga_jual_produk' => $this->request->getPost('harga_jual_produk'),
            'jenis_harga' => $this->request->getPost('mataUang'),
            'id_toko' => user()->toko,
        ];


        $id_produk = $this->request->getPost('id_produk');
        $stok_tokoinp = $this->request->getPost('banyak_produk');

        $db = \Config\Database::connect();

        $query = "SELECT * FROM stok_toko_grosir WHERE produk_id = ? AND id_toko = ?";
        $results = $db->query($query, [$id_produk, user()->toko])->getResult();
        $result = $results[0] ?? $results;

        $f = $d_prodModel->find($id_produk);
        // dd($f);

        if (empty($result)) {

            $i = 0;
            foreach ($results1 as $row) {
                $data3 = [
                    'produk_id' => $this->request->getPost('id_produk'),
                    'id_paket' => $jenis_paket_array[$i],
                    'harga' => $this->request->getPost($nilai_sama_values[$i]),
                    'jenis_harga' => $this->request->getPost('mataUang'),
                    'id_toko' => user()->toko,
                ];
                $d_mgpModel->insert($data3);

                $i++;
            }

            $d_stModel->insert($data2);
            if ($f == null) {
                $d_prodModel->insert($data);
            }
        } else {

            $id_toko = $result->id_toko;
            $stok_toko = $result->stok_toko;

            $byk = floatval($stok_toko) + floatval($stok_tokoinp);

            $query = "UPDATE stok_toko_grosir SET stok_toko = ? WHERE produk_id = ? AND id_toko = ?";
            $db->query($query, [$byk, $id_produk, $id_toko]);
        }

        $successMessage = 'Data berhasil disimpan!';
        session()->setFlashdata('success', $successMessage);

        return redirect()->back()->with('reload', true);
    }

    public function ubah_produk_grosir()
    {

        // dd($_POST);
        $keys = array_keys($_POST);
        $db = \Config\Database::connect();

        $query = $db->query("SELECT id_paket FROM paket_harga_grosir");
        $results1 = $query->getResult();
        $jenis_paket_array = array();
        $key_array = array();

        foreach ($results1 as $row) {
            $jenis_paket_array[] = strval($row->id_paket);
        }
        foreach ($keys as $key) {
            $key_array[] = strval($key);
        }

        $nilai_sama = array_intersect($jenis_paket_array, $key_array);
        $nilai_sama_values = array_values($nilai_sama);

        $d_prodModel = new M_data_produk_grosir();
        $d_stModel = new M_stok_toko_grosir();
        $d_mgpModel = new M_grosir_paket();


        $data = [
            'id_produk' => $this->request->getPost('id_produk'),
            'nama_produk' => $this->request->getPost('nama_produk'),
            'kategori_produk' => $this->request->getPost('kategori_produk'),
            'satuan_produk' => $this->request->getPost('satuan_produk'),
        ];

        $d_prodModel->update($this->request->getPost('id_produk'), $data);
        // update 1 


        $data2 = [
            'produk_id' => $this->request->getPost('id_produk'),
            'stok_toko' => $this->request->getPost('banyak_produk'),
            'stok_min' => $this->request->getPost('stok_min_produk'),
            'harga_beli_produk' => $this->request->getPost('harga_beli_produk'),
            'harga_jual_produk' => $this->request->getPost('harga_jual_produk'),
            'jenis_harga' => $this->request->getPost('mataUang'),
            'id_toko' => user()->toko,
        ];

        $d_stModel->update($this->request->getPost('id_stok_toko'), $data2);
        // update 2 

        $id_produk = $this->request->getPost('id_produk');

        $db = \Config\Database::connect();
        $query = "DELETE FROM produk_paket_grosir WHERE produk_id = ? AND id_toko = ?";
        $db->query($query, [$id_produk, user()->toko]);


        $i = 0;
        foreach ($results1 as $row) {
            $data3 = [
                'produk_id' => $this->request->getPost('id_produk'),
                'id_paket' => $jenis_paket_array[$i],
                'harga' => $this->request->getPost($nilai_sama_values[$i]),
                'jenis_harga' => $this->request->getPost('mataUang'),
                'id_toko' => user()->toko,
            ];
            $d_mgpModel->insert($data3);

            $i++;
        }

        $successMessage = 'Data berhasil disimpan!';
        session()->setFlashdata('success', $successMessage);

        return redirect()->back()->with('reload', true);
    }


    public function hapus_produk_grosir($id)
    {

        $db = \Config\Database::connect();


        $query = "DELETE FROM stok_toko_grosir WHERE produk_id = ? AND id_toko = ?";
        $db->query($query, [$id, user()->toko]);

        $query = "DELETE FROM produk_grosir WHERE id_produk = ?";
        $db->query($query, [$id]);


        $db = \Config\Database::connect();
        $query = "DELETE FROM produk_paket_grosir WHERE produk_id = ? AND id_toko = ?";
        $db->query($query, [$id, user()->toko]);



        $successMessage = 'Data berhasil dihapus!';
        session()->setFlashdata('deletes', $successMessage);

        return redirect()->back()->with('reload', true);
    }
}
