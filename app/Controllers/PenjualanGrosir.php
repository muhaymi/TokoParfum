<?php

namespace App\Controllers;

use App\Models\M_data_produk;
use App\Models\M_paket;
use App\Models\M_penjualan_grosir;
use App\Models\M_user;
use App\Models\M_toko;
use App\Models\M_pembayaran;
use App\Models\M_member;


use App\Models\M_data_produk_grosir;
use App\Models\M_stok_toko_grosir;
use App\Models\M_paket_grosir;
use App\Models\M_grosir_paket;
use App\Models\M_produk_paket_grosir;


//         $d_prodModel = new M_data_produk_grosir();
// $data['produk'] = $d_prodModel->getProdukGrosirWithStok();
// $data['produkAll'] = $d_prodModel->findAll();

// $d_pktModel = new M_paket_grosir();
// $data['paket']  = $d_pktModel->findAll();

// $d_mpgModel = new M_produk_paket_grosir();
// // $data['mpg']  = $d_mpgModel->findAll();
// $data['mpg']  = $d_mpgModel->getPktWithMpg();

class PenjualanGrosir extends BaseController
{
    public function data_penjualan_grosir()
    {
        $d_prodModel = new M_data_produk();
        // $data['produk']  = $d_prodModel->findAll();
        $data['produk'] = $d_prodModel->getProdukWithStok();
        // dd($data['produk']);
        $d_pktModel = new M_paket();
        $data['paket']  = $d_pktModel->findAll();
        $d_jualModel = new M_penjualan_grosir();
        $data['penjualan'] = $d_jualModel->where('toko_id', user()->toko)->findAll();
        $d_userModel = new M_user();
        $data['userku']  = $d_userModel->findAll();
        $d_tokoModel = new M_toko();
        $data['tokoku']  = $d_tokoModel->findAll();
        $d_mbrModel = new M_member();
        $data['member']  = $d_mbrModel->findAll();


        // dd($data['tokber']);

        return view('data/data_penjualan_grosir', $data);
    }

    public function penjualan_grosir()
    {


        // $d_pktModel = new M_paket_grosir();
        // $data['paket']  = $d_pktModel->findAll();

        $d_tokoModel = new M_toko();
        $data['toko']  = $d_tokoModel->find(user()->toko);
        $data['toko_mbr'] = $d_tokoModel->findAll();

        $d_mbrModel = new M_member();
        $data['member']  = $d_mbrModel->findAll();

        $d_prodModel = new M_data_produk_grosir();
        $data['produk'] = $d_prodModel->getProdukGrosirWithStok();

        $d_ppg = new M_grosir_paket();
        $data['paket'] = $d_ppg->phgPpg();

        // dd($data['paket']);
        return view('transaksi/penjualan_grosir', $data);
    }

    public function tambah_penjualan_grosir()
    {
        dd($_POST);

        $d_jualModel = new M_penjualan_grosir();

        $id_produk = $this->request->getPost('id_produk');
        $id_paket = $this->request->getPost('id_phg');
        $harga_produk = $this->request->getPost('harga_produk');
        $harga_awal = $this->request->getPost('hcek');
        $diskon = $this->request->getPost('diskon');
        $harga_jadi = $this->request->getPost('hartot');
        $banyak = $this->request->getPost('banyak');
        $nama_paket = $this->request->getPost('nama_paket');
        $toko_id = $this->request->getPost('toko_id');
        $id_penjualan = $this->request->getPost('id_penjualan');
        $pembeli_id = $this->request->getPost('pembeli_id');

        // dd($_POST);

        // data penjualan

        for ($i = 0; $i < count($id_produk); $i++) {
            $data = [
                'id_penjualan' => $id_penjualan,
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

            // kurangi stok

            $db = \Config\Database::connect();

            $query = "SELECT * FROM stok_toko WHERE produk_id = ? AND id_toko = ?";
            $results = $db->query($query, [$id_produk[$i], user()->toko])->getResult();
            $result = $results[0];
            $id_toko = $result->id_toko;
            $stok_toko = $result->stok_toko;

            $byk = intval($stok_toko) - intval($banyak[$i]);

            $query = "UPDATE stok_toko SET stok_toko = ? WHERE produk_id = ? AND id_toko = ?";
            $db->query($query, [$byk, $id_produk[$i], $id_toko]);


            // bagian jika dijual ke toko
            $db3 = \Config\Database::connect();
            $query3 = "SELECT * FROM toko WHERE id_toko = ? ";
            $results3 = $db3->query($query3, [$pembeli_id])->getResult();
            if ($results3 && count($results3) > 0) {
                $query = "SELECT * FROM stok_toko WHERE produk_id = ? AND id_toko = ?";
                $results2 = $db->query($query, [$id_produk[$i], $pembeli_id])->getResult();
                $result2 = $results2[0] ?? $results2;

                if ($results2 && count($results2) > 0) {
                    $stok_toko2 = $result2->stok_toko;
                    $byk2 = intval($stok_toko2) + intval($banyak[$i]);

                    $query = "UPDATE stok_toko SET stok_toko = ? WHERE produk_id = ? AND id_toko = ?";
                    $db->query($query, [$byk2, $id_produk[$i], $pembeli_id]);
                } else {

                    $query = "INSERT INTO stok_toko (produk_id, stok_toko, id_toko) VALUES (?, ?, ?)";
                    $db->query($query, [$id_produk[$i], $banyak[$i], $pembeli_id]);
                }
                // dd($results3);
            } else {
            }
        }

        $ht = $this->request->getPost('harga_total');
        $byr = $this->request->getPost('membayar');

        $htg = floatval($ht) - floatval($byr);
        if ($htg > 0) {
            $hutang = 'Belum Lunas';
        } else {
            $hutang = 'Lunas';
        }

        // bagian hutang
        $db = \Config\Database::connect();
        $query = "INSERT INTO hutang_grosir 
                  SET id_penjualan = ?,
                      hutang_sebelumnya = ?,
                      membayar = ?,
                      hutang_sekarang = ?,
                      created_at = ?,	
                      updated_at = ?";

        $db->query($query, [$id_penjualan, $ht, $byr, $htg, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);

        // bagian pembayaran
        $data2 = [
            'jenis_pembayaran' => $this->request->getPost('jenis_pembayaran'),
            'id_penjualan' => $this->request->getPost('id_penjualan'),
            'total_bayar' => $this->request->getPost('harga_total'),
            'membayar' => $this->request->getPost('membayar'),
            'status_pembayaran' => $hutang,
            'hutang' => $htg,
            'toko_id' => $this->request->getPost('toko_id'),
            'tempo' => $this->request->getPost('tempo'),
            'keterangan' => "pembelian",

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
        $d_jualModel = new M_penjualan_grosir();
        $data['penjualan']  = $d_jualModel->findAll();
        $d_userModel = new M_user();
        $data['userku']  = $d_userModel->findAll();
        $d_pembayaranModel = new M_pembayaran();
        $data['pembayaran']  = $d_pembayaranModel->findAll();


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
        $d_jualModel = new M_penjualan_grosir();
        $d_jualModel->delete($id);

        $successMessage = 'Data berhasil dihapus!';
        session()->setFlashdata('success', $successMessage);

        return redirect()->back()->with('reload', true);
    }
}
