<?php

namespace App\Controllers;

use App\Models\M_stok_toko_grosir;
use App\Models\M_penjualan_grosir;
use App\Models\M_paket;
use App\Models\M_user;
use App\Models\M_toko;
use App\Models\M_dollar;
use App\Models\M_member;


use App\Models\M_data_produk_grosir;
use App\Models\M_pembayaran_grosir;
use App\Models\M_grosir_paket;
use App\Models\M_hutang_grosir;
use App\Models\M_keuangan_grosir;



class PenjualanGrosir extends BaseController
{

    public function data_penjualan_grosir()
    {
        $d_prodModel = new M_data_produk_grosir();
        // $data['produk']  = $d_prodModel->findAll();
        $data['produk'] = $d_prodModel->getProdukGrosirWithStok();
        // dd($data['produk']);
        // $d_pktModel = new M_paket();
        // $data['paket']  = $d_pktModel->findAll();
        $d_ppg = new M_grosir_paket();
        $data['paket'] = $d_ppg->phgPpg();
        $d_jualModel = new M_penjualan_grosir();

        // Menangkap parameter query dari URL
        $id_penjualan = $this->request->getGet('id_penjualan');
        if ($id_penjualan) {
            $data['penjualan'] = $d_jualModel->where('toko_id', user()->toko)->where('id_penjualan', $id_penjualan)->orderBy('created_at', 'DESC')->findAll();
        } else {
            $data['penjualan'] = $d_jualModel->where('toko_id', user()->toko)->orderBy('created_at', 'DESC')->findAll();
        }



        $d_userModel = new M_user();
        $data['userku']  = $d_userModel->findAll();
        $d_tokoModel = new M_toko();
        $data['tokoku']  = $d_tokoModel->findAll();
        $d_mbrModel = new M_member();
        $data['member']  = $d_mbrModel->findAll();

        // dd($data['produk']);

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

        $d_dlr = new M_dollar();
        $data['dlr']  = $d_dlr->find(1);

        // dd($data['paket']);
        return view('transaksi/penjualan_grosir2', $data);
    }

    public function tambah_penjualan_grosir()
    {
        // dd($_POST);
        $d_jualModel = new M_penjualan_grosir();

        $id_produk = $this->request->getPost('id_produk');
        $harga_produk = $this->request->getPost('harga_produk');
        $harga_awal = $this->request->getPost('harwal');
        $diskon = $this->request->getPost('diskon');
        $harga_jadi = $this->request->getPost('hartot');
        $banyak = $this->request->getPost('banyak');
        $nama_paket = $this->request->getPost('phg');
        $toko_id = $this->request->getPost('toko_id');
        $id_penjualan = $this->request->getPost('id_penjualan');
        $pembeli_id = $this->request->getPost('pembeli_id');
        $kasir_id = $this->request->getPost('kasir_id');
        $h_dlr = $this->request->getPost('harga_dlr');
        $h_cek = $this->request->getPost('hcek');

        $d_mbrModel = new M_member();
        $data['member']  = $d_mbrModel->findAll();
        $d_tokoModel = new M_toko();
        $data['tokoku']  = $d_tokoModel->findAll();
        $Pid = '';
        $Pnm = $pembeli_id;
        $cek_m = 0;

        foreach ($data['member'] as $m) {
            if ($m['id_member'] == $pembeli_id) {
                $Pid = $m['id_member'];
                $Pnm = $m['nama_member'];
                $cek_m = 1;
            }
        }

        foreach ($data['tokoku'] as $tk) {
            if ($tk['id_toko'] == $pembeli_id) {
                $Pid = $tk['id_toko'];
                $Pnm = $tk['nama_toko'];
            }
        }
        // dd($data['tokoku'], $_POST);


        // data penjualan

        for ($i = 0; $i < count($id_produk); $i++) {
            $data = [
                'id_penjualan' => $id_penjualan,
                'produk_id' => $id_produk[$i],
                'banyak' => $banyak[$i],
                'harga_produk' => $harga_produk[$i],
                'harga_dlr' => $h_dlr[$i],
                'harga_awal' => $harga_awal[$i],
                'diskon' => $diskon[$i],
                'harga_jadi' => $harga_jadi[$i],
                'keterangan' => $nama_paket[$i],
                'h_cek' => $h_cek[$i],
                'kasir_id' => $kasir_id,
                'toko_id' => $toko_id,
                'pembeli_id' => $Pid,
                'nama_pembeli' => $Pnm,
            ];


            $d_jualModel->insert($data);

            // kurangi stok

            $db = \Config\Database::connect();

            $query = "SELECT * FROM stok_toko_grosir WHERE produk_id = ? AND id_toko = ?";
            $results = $db->query($query, [$id_produk[$i], user()->toko])->getResult();
            $result = $results[0];
            $id_toko = $result->id_toko;
            $stok_toko = $result->stok_toko;

            $byk = intval($stok_toko) - intval($banyak[$i]);

            $query = "UPDATE stok_toko_grosir SET stok_toko = ? WHERE produk_id = ? AND id_toko = ?";
            $db->query($query, [$byk, $id_produk[$i], $id_toko]);
            // dd($byk);


            // bagian jika dijual ke toko
            // $db3 = \Config\Database::connect();
            // $query3 = "SELECT * FROM toko WHERE id_toko = ? ";
            // $results3 = $db3->query($query3, [$Pid])->getResult();
            // if ($results3 && count($results3) > 0) {
            //     $query = "SELECT * FROM stok_toko WHERE produk_id = ? AND id_toko = ?";
            //     $results2 = $db->query($query, [$id_produk[$i], $Pid])->getResult();
            //     $result2 = $results2[0] ?? $results2;

            //     if ($results2 && count($results2) > 0) {
            //         $stok_toko2 = $result2->stok_toko;
            //         $byk2 = intval($stok_toko2) + intval($banyak[$i]);

            //         $query = "UPDATE stok_toko SET stok_toko = ? WHERE produk_id = ? AND id_toko = ?";
            //         $db->query($query, [$byk2, $id_produk[$i], $Pid]);
            //     } else {

            //         $query = "INSERT INTO stok_toko (produk_id, stok_toko, id_toko) VALUES (?, ?, ?)";
            //         $db->query($query, [$id_produk[$i], $banyak[$i], $Pid]);
            //     }
            //     // dd($results3);
            // } else {
            // }
        }

        $ht = $this->request->getPost('ttlall');
        $byr = $this->request->getPost('membayar');

        $htg = floatval($ht) - floatval($byr);
        if ($htg > 0) {
            $hutang = 'Belum Lunas';
        } elseif ($htg < 0) {
            $hutang = 'Belum Tuntas';
        } else {
            $hutang = 'Lunas';

            // bagian point member
            if ($cek_m == 1) {
                $db = \Config\Database::connect();
                $query = "UPDATE member 
          SET poin_member = poin_member + 1
          WHERE id_member = ?";
                $db->query($query, [$Pid]);
            };
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
            'total_bayar' => $this->request->getPost('ttlall'),
            'membayar' => $this->request->getPost('membayar'),
            'status_pembayaran' => $hutang,
            'hutang' => $htg,
            'toko_id' => $this->request->getPost('toko_id'),
            'tempo' => $this->request->getPost('tempo'),
            'kasir_id' => $kasir_id,
            'toko_id' => $toko_id,
            'pembeli_id' => $Pid,
            'nama_pembeli' => $Pnm,
            'keterangan' => "pembelian",

        ];
        $d_pembayaranModel = new M_pembayaran_grosir();

        $d_pembayaranModel->insert($data2);


        $idpp = [
            'id_penjualan' => $id_penjualan,
        ];


        $successMessage = 'Data berhasil disimpan! ' . $this->request->getPost('id_penjualan');
        session()->setFlashdata('success', $successMessage);

        return redirect()->to('/data_pembayaran_grosir')->with('reload', true)->with('idpp', $idpp);
    }


    public function ubah_penjualan_grosir()
    {

        // dd($_POST);


        $jual = $this->request->getPost('jual');
        $id_produk = $this->request->getPost('id_produk');
        $produk_id_awal = $this->request->getPost('produk_id_awal');
        $banyak = $this->request->getPost('banyak');
        $banyak_produk_awal = $this->request->getPost('banyak_awal');
        $toko_id = $this->request->getPost('toko_id');
        $id_penjualan = $this->request->getPost('id_penjualan');
        $banyak = $this->request->getPost('banyak');
        $diskon = $this->request->getPost('diskon');
        $harga_awal = $this->request->getPost('harga_awal');
        $harga_produk = $this->request->getPost('harga_produk');
        $harga_jadi = $this->request->getPost('harga_jadi');
        $keterangan = $this->request->getPost('keterangan');
        $dlr = $this->request->getPost('dlr');

        // dd($produk);



        $db = \Config\Database::connect();

        $query = "SELECT * FROM stok_toko_grosir WHERE produk_id = ? AND id_toko = ?";
        $results = $db->query($query, [$produk_id_awal, $toko_id])->getResult();
        $result = $results[0];

        $stok_toko = $result->stok_toko;

        $kembalikan = floatval($banyak_produk_awal) + floatval($stok_toko);

        $query = "UPDATE stok_toko_grosir SET stok_toko = ? WHERE produk_id = ? AND id_toko = ?";
        $db->query($query, [$kembalikan, $produk_id_awal, $toko_id]); //kembalikan stok


        $db = \Config\Database::connect();

        $query2 = "SELECT * FROM stok_toko_grosir WHERE produk_id = ? AND id_toko = ?";
        $results2 = $db->query($query2, [$id_produk, $toko_id])->getResult();
        $result2 = $results2[0];

        $stok_toko2 = $result2->stok_toko;
        $kirimkan = floatval($stok_toko2) - floatval($banyak);
        // dd($kirimkan);

        $query2 = "UPDATE stok_toko_grosir SET stok_toko = ? WHERE produk_id = ? AND id_toko = ?";
        $db->query($query2, [$kirimkan, $id_produk, $toko_id]); //kirim data baru

        $query3 = "UPDATE penjualan_grosir 
        SET produk_id = ?,
        harga_dlr = ?,
        banyak = ?,
        harga_produk = ?,
        harga_awal = ?,
        diskon = ?,
        harga_jadi = ?,
        keterangan = ?
        WHERE id_penjualan = ? AND id_jual = ?";

        $db->query($query3, [$id_produk, $dlr, $banyak, $harga_produk, $harga_awal, $diskon, $harga_jadi, $keterangan, $id_penjualan, $jual]);



        $db = \Config\Database::connect();

        $queryt = "SELECT * FROM penjualan_grosir WHERE id_penjualan = ?";
        $resultst = $db->query($queryt, [$id_penjualan])->getResult();
        // dd(count($results));
        $all_c = 0;
        foreach ($resultst as $r) {
            $all_c += $r->harga_jadi;
        }

        $db = \Config\Database::connect();

        $querys = "UPDATE pembayaran_grosir SET total_bayar = ? WHERE id_penjualan = ? ";
        $db->query($querys, [$all_c, $id_penjualan]); //kirim data baru total pembayaran grosir


        // hutang
        $db = \Config\Database::connect();
        $queryh = "SELECT * FROM pembayaran_grosir WHERE id_penjualan = ?";
        $r = $db->query($queryh, [$id_penjualan])->getResult();
        $mbyr = $r[0]->membayar;

        $db = \Config\Database::connect();
        $queryh = "DELETE FROM hutang_grosir WHERE id_penjualan = ?";
        $db->query($queryh, [$id_penjualan]);

        $d_htgModel = new M_hutang_grosir();

        $data = [
            'hutang_sebelumnya' => $all_c,
            'membayar' => floatval($mbyr),
            'hutang_sekarang' => $all_c - floatval($mbyr),
            'id_penjualan' => $id_penjualan,
        ];


        $d_htgModel->insert($data);





        $successMessage = 'Data berhasil diperbaharui! ' . $this->request->getPost('id_penjualan');
        session()->setFlashdata('success', $successMessage);

        return redirect()->to('/data_penjualan_grosir')->with('reload', true);
    }


    public function batalkan_penjualan_grosir($id_penjualan)
    {

        // dd($_POST,$id_penjualan);
        $db1 = \Config\Database::connect();

        $queryt = "SELECT * FROM penjualan_grosir WHERE id_penjualan = ?";
        $resultst = $db1->query($queryt, [$id_penjualan])->getResult();
        // dd(count($results));


        foreach ($resultst as $r) {
            $produk =  $r->produk_id;
            $toko =  $r->toko_id;
            $banyak =  $r->banyak;

            $db1 = \Config\Database::connect();

            $query = "SELECT * FROM stok_toko_grosir WHERE produk_id = ? AND id_toko = ?";
            $results = $db1->query($query, [$produk, $toko])->getResult();
            $result = $results[0];
            $stok_toko = $result->stok_toko;

            $kembalikan =  floatval($stok_toko) + floatval($banyak);

            // echo ($kembalikan);

            $query = "UPDATE stok_toko_grosir SET stok_toko = ? WHERE produk_id = ? AND id_toko = ?";
            $db1->query($query, [$kembalikan, $produk, $toko]);
        }

        $db2 = \Config\Database::connect();

        $query2 = "DELETE FROM penjualan_grosir WHERE id_penjualan = ? ";
        $db2->query($query2, [$id_penjualan]);

        $db3 = \Config\Database::connect();

        $query3 = "DELETE FROM pembayaran_grosir WHERE id_penjualan = ? ";
        $db3->query($query3, [$id_penjualan]);

        $db4 = \Config\Database::connect();

        $query4 = "DELETE FROM hutang_grosir WHERE id_penjualan = ? ";
        $db4->query($query4, [$id_penjualan]);

        // dd($resultst);

        $successMessage = 'Data Pembelian berhasil dibatalkan! ' . $this->request->getPost('id_penjualan');
        session()->setFlashdata('success', $successMessage);

        return redirect()->to('/data_pembayaran_grosir')->with('reload', true);
    }


    public function data_pembayaran_grosir()
    {
        $d_prodModel = new M_data_produk_grosir();
        $data['produk']  = $d_prodModel->findAll();
        $d_pktModel = new M_paket();
        $data['paket']  = $d_pktModel->findAll();
        $d_jualModel = new M_penjualan_grosir();
        $data['penjualan']  = $d_jualModel->findAll();
        $d_userModel = new M_user();
        $data['userku']  = $d_userModel->findAll();
        $d_pembayaranModel = new M_pembayaran_grosir();
        $data['pembayaran']  = $d_pembayaranModel->orderBy('created_at', 'DESC')->findAll();
        $d_htgModel = new M_hutang_grosir();
        $data['hutang']  = $d_htgModel->findAll();
        $d_tokoModel = new M_toko();
        $data['tokoku']  = $d_tokoModel->findAll();

        // Mengambil data flash dari session
        if (session()->has('idpp')) {
            $data['idpp'] = session()->get('idpp');
        } else {
            $data['idpp'] = ['id_penjualan' => 0];
        }

        return view('data/data_pembayaran_grosir', $data);
    }



    public function bayar_hutang_grosir()
    {
        // dd($_POST);
        $d_htgModel = new M_hutang_grosir();

        $d_mbrModel = new M_member();
        $data['member']  = $d_mbrModel->findAll();

        $jual = $this->request->getPost('id_jual');
        $membayar = $this->request->getPost('membayar');
        $member = $this->request->getPost('id_member');
        $hs = $this->request->getPost('hs');
        $hn = floatval($hs) - floatval($membayar);

        $cek_m = 0;
        foreach ($data['member'] as $m) {
            if ($m['id_member'] == $member) {
                $cek_m = 1;
            }
        }


        $stts = "Belum Lunas";
        if ($hn < 0) {
            $stts = 'Belum Tuntas';
        } elseif ($hn == 0) {
            $stts = "Lunas";

            // bagian point member
            if ($cek_m == 1) {
                $db = \Config\Database::connect();
                $query = "UPDATE member 
          SET poin_member = poin_member + 1
          WHERE id_member = ?";
                $db->query($query, [$member]);
            };
        }


        $data = [
            'hutang_sebelumnya' => $hs,
            'membayar' => $membayar,
            'hutang_sekarang' => $hn,
            'id_penjualan' => $jual

        ];


        $d_htgModel->insert($data);

        $db = \Config\Database::connect();
        $querys = "UPDATE pembayaran_grosir SET status_pembayaran = ? WHERE id_penjualan = ? ";
        $db->query($querys, [$stts, $jual]); //kirim data baru total pembayaran grosir


        $idpp = [
            'id_penjualan' => $jual,
        ];


        $successMessage = 'Hutang berhasil dibayar!';
        session()->setFlashdata('success', $successMessage);

        return redirect()->to('/data_pembayaran_grosir')->with('reload', true)->with('idpp', $idpp);
    }

    public function hapus_penjualan_grosir($id)
    {
        $d_jualModel = new M_penjualan_grosir();
        $d_jualModel->delete($id);

        $successMessage = 'Data berhasil dihapus!';
        session()->setFlashdata('success', $successMessage);

        return redirect()->back()->with('reload', true);
    }

    public function ubah_dolar()
    {
        $hr = $this->request->getPost('harga_rupiah');

        $data = ['harga_rupiah' => $hr];

        $d_dlr = new M_dollar();
        $d_dlr->update(1, $data);

        $successMessage = 'Dollar berhasil diubah!';
        session()->setFlashdata('success', $successMessage);

        return redirect()->back()->with('reload', true);
    }

    public function data_laba_grosir()
    {
        $d_prodModel = new M_data_produk_grosir();
        $data['produk']  = $d_prodModel->findAll();
        $d_pktModel = new M_paket();
        $data['paket']  = $d_pktModel->findAll();
        $d_jualModel = new M_penjualan_grosir();
        $data['penjualan']  = $d_jualModel->findAll();
        $d_userModel = new M_user();
        $data['userku']  = $d_userModel->findAll();
        $d_pembayaranModel = new M_pembayaran_grosir();
        $data['pembayaran']  = $d_pembayaranModel->orderBy('created_at', 'DESC')->findAll();
        $d_htgModel = new M_hutang_grosir();
        $data['hutang']  = $d_htgModel->findAll();
        $d_tokoModel = new M_member();
        $data['mbr']  = $d_tokoModel->findAll();


        $lg_model = new M_keuangan_grosir();
        $data['keuangan_grosir'] = $lg_model->orderBy('tanggal', 'DESC')->findAll();

        return view('data/laba_grosir', $data);
    }

    public function tambah_lg()
    {
        $model = new M_keuangan_grosir();

        $data = [
            'jenis' => $this->request->getPost('jenis'),
            'jumlah' => $this->request->getPost('jumlah'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'tanggal' => $this->request->getPost('tanggal'),
        ];

        $model->insert($data);
        return redirect()->back()->with('reload', true);
    }

    public function edit_lg()
    {
        $model = new M_keuangan_grosir();

        $id = $this->request->getPost('id');
        $data = [
            'jenis' => $this->request->getPost('jenis'),
            'jumlah' => $this->request->getPost('jumlah'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'tanggal' => $this->request->getPost('tanggal'),
        ];

        $model->update($id, $data);
        return redirect()->back()->with('reload', true);
    }

    public function hapus_lg($id)
    {
        $model = new M_keuangan_grosir();
        $model->delete($id);
        return redirect()->back()->with('reload', true);
    }

    public function form()
    {
        return view('form_laba');
    }

    public function cek()
    {
        $start = $this->request->getPost('start');
        $over = $this->request->getPost('over');

        $penjualanModel = new M_penjualan_grosir();
        $stokModel = new M_stok_toko_grosir();

        // Ambil data penjualan dalam rentang tanggal yang diberikan
        $penjualan = $penjualanModel->where('created_at >=', $start)
            ->where('created_at <=', $over)
            ->findAll();

        $totalLaba = 0;


        foreach ($penjualan as $item) {
            $hargaJadi = $item['harga_jadi'];

            $idProduk = $item['id_produk'];
            $banyakBarang = $item['banyak_barang'];

            // Ambil harga beli dari stok toko grosir berdasarkan id produk
            $stok = $stokModel->where('id_produk', $idProduk)
                ->where('id_toko', user()->toko);

            $hargaBeli = $stok['harga_beli'];

            // Hitung laba
            $laba = ($hargaJadi - $hargaBeli) * $banyakBarang;
            $totalLaba += $laba;
        }
        // dd($stokModel);


        // Kembalikan hasil dalam format HTML
        return "Total Laba: Rp. " . number_format($totalLaba, 2);
    }
}
