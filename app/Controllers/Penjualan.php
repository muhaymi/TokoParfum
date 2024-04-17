<?php

namespace App\Controllers;

use App\Models\M_data_produk;
use App\Models\M_paket;
use App\Models\M_penjualan;
use App\Models\M_user;
use App\Models\M_toko;
use App\Models\M_pembayaran;
use App\Models\M_member;



class Penjualan extends BaseController
{
    public function data_penjualan()
    {
        $d_prodModel = new M_data_produk();
        // $data['produk']  = $d_prodModel->findAll();
        $data['produk'] = $d_prodModel->getProdukWithStok();

        $d_pktModel = new M_paket();
        $data['paket']  = $d_pktModel->findAll();
        $d_jualModel = new M_penjualan();
        $data['penjualan'] = $d_jualModel->where('toko_id', user()->toko)->findAll();
        $d_userModel = new M_user();
        $data['userku']  = $d_userModel->findAll();
        $d_tokoModel = new M_toko();
        $data['tokoku']  = $d_tokoModel->findAll();
        $d_mbrModel = new M_member();
        $data['member']  = $d_mbrModel->findAll();

        return view('data/data_penjualan', $data);
    }

    public function penjualan()
    {
        // $d_prodModel = new M_data_produk();
        // $data['produk']  = $d_prodModel->findAll();
        $d_pktModel = new M_paket();
        $data['paket']  = $d_pktModel->where('toko_id', user()->toko)->findAll();
        $d_mbrModel = new M_member();
        $data['member']  = $d_mbrModel->findAll();
        $d_tokoModel = new M_toko();
        $data['toko']  = $d_tokoModel->find(user()->toko);


        $d_prodModel = new M_data_produk();
        $data['produk'] = $d_prodModel->getProdukWithStok();


        return view('transaksi/penjualan_eceran', $data);
    }

    public function tambah_penjualan()
    {
        // dd($_POST);

        $d_jualModel = new M_penjualan();

        $id_produk = $this->request->getPost('id_produk');
        $id_paket = $this->request->getPost('id_paket');
        $harga_produk = $this->request->getPost('harga_produk');
        $harga_awal = $this->request->getPost('hcek');
        $diskon = $this->request->getPost('diskon');
        $harga_jadi = $this->request->getPost('hartot');
        $banyak = $this->request->getPost('banyak');
        $nama_paket = $this->request->getPost('nama_paket');
        $toko_id = $this->request->getPost('toko_id');
        $pembeli_id = $this->request->getPost('pembeli_id');
        // dd($_POST);



        for ($i = 0; $i < count($id_produk); $i++) {
            $data = [
                'id_penjualan' => $this->request->getPost('id_penjualan'),
                'produk_id' => $id_produk[$i],
                'paket_id' => $id_paket[$i],
                'banyak' => $banyak[$i],
                'harga_produk' => $harga_produk[$i],
                'harga_awal' => $harga_awal[$i],
                'diskon' => $diskon[$i],
                'harga_jadi' => $harga_jadi[$i],
                'kasir_id' => $this->request->getPost('kasir_id'),
                'toko_id' => $toko_id,
                'pembeli_id' => $pembeli_id,
                'keterangan' => $nama_paket[$i],
            ];


            $d_jualModel->insert($data);



            $db = \Config\Database::connect();

            $query = "SELECT * FROM stok_toko WHERE produk_id = ? AND id_toko = ?";
            $results = $db->query($query, [$id_produk[$i], user()->toko])->getResult();
            $result = $results[0];
            $id_toko = $result->id_toko;
            $stok_toko = $result->stok_toko;

            $byk = intval($stok_toko) - intval($banyak[$i]);

            $query = "UPDATE stok_toko SET stok_toko = ? WHERE produk_id = ? AND id_toko = ?";
            $db->query($query, [$byk, $id_produk[$i], $id_toko]);


            // $db = \Config\Database::connect();

            // $query = "UPDATE produk SET banyak_produk = ? WHERE id_produk = ?";
            // $db->query($query, [$byk, $id_produk[$i]]);
        }

        $data2 = [
            'jenis_pembayaran' => $this->request->getPost('jenis_pembayaran'),
            'id_penjualan' => $this->request->getPost('id_penjualan'),
            'total_bayar' => $this->request->getPost('harga_total'),
            'membayar' => $this->request->getPost('harga_total'),
            'hutang' => 0,
            'tempo' => date('Y-m-d H:i:s'),
            'status_pembayaran' => 'Lunas',

        ];
        $d_pembayaranModel = new M_pembayaran();

        $d_pembayaranModel->insert($data2);


        $successMessage = 'Data berhasil disimpan! ' . $this->request->getPost('id_penjualan');
        session()->setFlashdata('success', $successMessage);

        return redirect()->to('/data_pembayaran')->with('reload', true);
    }

    public function data_pembayaran()
    {
        $d_prodModel = new M_data_produk();
        $data['produk']  = $d_prodModel->findAll();
        $d_pktModel = new M_paket();
        $data['paket']  = $d_pktModel->findAll();
        $d_jualModel = new M_penjualan();
        $data['penjualan']  = $d_jualModel->findAll();
        $d_userModel = new M_user();
        $data['userku']  = $d_userModel->findAll();
        $d_pembayaranModel = new M_pembayaran();
        $data['pembayaran']  = $d_pembayaranModel->getBayarWithJual();


        return view('data/data_pembayaran', $data);
    }


    public function ubah_penjualan()
    {

        $jual = $this->request->getPost('jual');
        $id_penjualan = $this->request->getPost('id_penjualan');
        $produk_id_awal = $this->request->getPost('produk_id_awal');
        $banyak_produk_awal = $this->request->getPost('banyak_produk_awal');
        $toko_id = $this->request->getPost('toko_id');
        $paket = $this->request->getPost('paket');
        $produk = $this->request->getPost('produk');
        $banyak = $this->request->getPost('banyak');
        $diskon = $this->request->getPost('diskon');
        $harga_produk = $this->request->getPost('harga_produk');
        $harga_awal = $this->request->getPost('harga_awal');
        $harga_jadi = $this->request->getPost('harga_jadi');
        $keterangan = $this->request->getPost('keterangan');
        // dd($produk);

        $db = \Config\Database::connect();

        $query = "SELECT * FROM stok_toko WHERE produk_id = ? AND id_toko = ?";
        $results = $db->query($query, [$produk_id_awal, $toko_id])->getResult();
        $result = $results[0];

        $stok_toko = $result->stok_toko;

        $kembalikan = floatval($banyak_produk_awal) + floatval($stok_toko);

        $query = "UPDATE stok_toko SET stok_toko = ? WHERE produk_id = ? AND id_toko = ?";
        $db->query($query, [$kembalikan, $produk_id_awal, $toko_id]);


        $db = \Config\Database::connect();

        $query2 = "SELECT * FROM stok_toko WHERE produk_id = ? AND id_toko = ?";
        $results2 = $db->query($query2, [$produk, $toko_id])->getResult();
        $result2 = $results2[0];

        $stok_toko2 = $result2->stok_toko;
        $kirimkan = floatval($stok_toko2) - floatval($banyak);

        $query2 = "UPDATE stok_toko SET stok_toko = ? WHERE produk_id = ? AND id_toko = ?";
        $db->query($query2, [$kirimkan, $produk, $toko_id]);

        $query3 = "UPDATE penjualan_eceran 
        SET produk_id = ?,
        paket_id = ?,
        banyak = ?,
        harga_produk = ?,
        harga_awal = ?,
        diskon = ?,
        harga_jadi = ?,
        keterangan = ?
        WHERE id_penjualan = ? AND id_jual = ?";

        $db->query($query3, [$produk, $paket, $banyak, $harga_produk, $harga_awal, $diskon, $harga_jadi, $keterangan, $id_penjualan, $jual]);

        $successMessage = 'Data berhasil disimpan! ' . $this->request->getPost('id_penjualan');
        session()->setFlashdata('success', $successMessage);

        return redirect()->to('/data_penjualan')->with('reload', true);
    }


    public function batalkan_penjualan($id, $produk, $banyak, $toko)
    {
        $db = \Config\Database::connect();
        // dd($_POST);

        $query = "SELECT * FROM stok_toko WHERE produk_id = ? AND id_toko = ?";
        $results = $db->query($query, [$produk, $toko])->getResult();
        $result = $results[0];

        // $id_toko = $result->id_toko;
        $stok_toko = $result->stok_toko;

        $kembalikan =  floatval($stok_toko) + floatval($banyak);

        $query = "UPDATE stok_toko SET stok_toko = ? WHERE produk_id = ? AND id_toko = ?";
        $db->query($query, [$kembalikan, $produk, $toko]);

        $query2 = "DELETE FROM penjualan_eceran WHERE id_jual = ? ";
        $db->query($query2, [$id]);

        $successMessage = 'Data Pembelian berhasil dibatalkan! ' . $this->request->getPost('id_penjualan');
        session()->setFlashdata('success', $successMessage);

        return redirect()->to('/data_penjualan')->with('reload', true);
    }

    public function hapus_penjualan($id)
    {
        $d_jualModel = new M_penjualan();
        $d_jualModel->delete($id);

        $successMessage = 'Data berhasil dihapus!';
        session()->setFlashdata('success', $successMessage);

        return redirect()->back()->with('reload', true);
    }
}
