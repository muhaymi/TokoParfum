<?php

namespace App\Controllers;

use App\Models\M_user;
use App\Models\M_toko;
use App\Models\M_waktu_absen;
use App\Models\M_presensi;


class presensi extends BaseController
{
    public function presensi()
    {
        $userModel = new M_user();
        $presensiModel = new M_presensi();
        $wktabsen = new M_waktu_absen();
        $tokosModel = new M_toko();

        $data['tokoAll']  = $tokosModel->find(user()->toko);

        $data['wkt_absen'] = $wktabsen->find(1);
        $data['absenku'] = $presensiModel->find(user()->id);
        $data['presensi'] = $presensiModel->findAll();
        $data['user'] = $userModel->findAll();



        $data['title'] = 'Presensi';


        return view('absensi/presensiPegawai.php', $data);
    }

    public function simpanPresensi()
    {

        $presensiModel = new M_presensi();


        // $data['user'] = $presensiModel->findAll();
        // $data['presensi'] = $presensiModel->findAll();



        // Tangkap data yang dikirimkan melalui formulir
        $presensi_userid = $this->request->getPost('presensi_userid');
        $nama = $this->request->getPost('nama');
        $waktu = $this->request->getPost('waktu');
        $presensi_nama_toko = $this->request->getPost('presensi_nama_toko');
        $foto_data_url = $this->request->getPost('foto_data_url');

        // Simpan data ke dalam database menggunakan model (seperti yang telah Anda lakukan sebelumnya)




        // Simpan gambar ke dalam server
        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $foto_data_url));
        $imageName = $nama . '-' . $presensi_userid . '-' . $presensi_nama_toko  . $waktu . '.png'; // Atur nama file gambar sesuai kebutuhan Anda
        // echo $imageName;

        $imagePath = ROOTPATH . 'public\presensi\\' . $imageName; // Gunakan slash miring (/) sebagai pemisah direktori

        file_put_contents($imagePath, $imageData);


        $data = [
            'presensi_userid' => $presensi_userid,
            'nama_presensi' => $nama,
            'waktu_presensi' => $waktu,
            'presensi_nama_toko' => $presensi_nama_toko,
            'foto_presensi' => $imageName,
        ];

        // echo ($presensi_nama_toko);

        $presensiModel->insert($data);

        return redirect()->back();
    }

    public function WaktuSetPresensi()
    {
        // dd($_POST);

        $wktabsen = new M_waktu_absen();
        // $data['wkt_absen'] = $wktabsen->findAll();
        // $data['wkt_mulai'] = $wktabsen->findAll();

        $waktu = $this->request->getPost('waktu_presensi');
        $waktum = $this->request->getPost('waktu_presensi_mulai');


        $data = ['waktu_absen' => $waktu, 'waktu_mulai' => $waktum];

        $wktabsen->update(1, $data);

        return redirect()->back()->with('reload', true);
    }


    public function hapus_presensi($id, $filename)
    {
        // dd($id, $filename);
        $pm = new M_presensi();

        $imagePath = ROOTPATH . 'public/presensi/' . $filename; // Path file

        if (file_exists($imagePath)) {   //cek ada atau tidak
            if (unlink($imagePath)) {  //hpsfile

            };
        };


        $pm->delete($id); //hps data server

        $successMessage = 'Data berhasil dihapus!';
        session()->setFlashdata('success', $successMessage);

        return redirect()->back()->with('reload', true);
    }

    public function cek_presensi($idp, $filename, $user_id)
    {
        // dd($id, $filename);
        // $pm = new M_presensi();

        $imagePath = ROOTPATH . 'public/presensi/' . $filename; // Path file

        if (file_exists($imagePath)) {   //cek ada atau tidak
            if (unlink($imagePath)) {  //hpsfile

            };
        };


        // $pm->delete($id); //hps data server


        $db = \Config\Database::connect();

        $query = "SELECT * FROM users WHERE id = ? ";
        $results = $db->query($query, [$user_id])->getResult();
        // dd($results, $idp, $user_id);

        $result = $results[0];

        $absen = intval($result->presensi) + 1;
        // dd($absen);

        $db = \Config\Database::connect();

        $query1 = "UPDATE users 
        SET presensi = ?
        WHERE id = ? ";

        $db->query($query1, [$absen, $user_id]);


        $db = \Config\Database::connect();
        $ket = "masuk";

        $query3 = "UPDATE presensi 
        SET keterangan = ?
        WHERE id_presensi = ? ";

        $db->query($query3, [$ket,  $idp]);



        $successMessage = 'Absen berhasil dicatat!';
        session()->setFlashdata('success', $successMessage);

        return redirect()->back()->with('reload', true);
    }

    public function gaji()
    {
        // dd($_POST);
        $id = $this->request->getPost('id_user');
        $hari = $this->request->getPost('hari');
        $tp = $this->request->getPost('tanggal_pembayaran');
        $name = $this->request->getPost('username');


        $db = \Config\Database::connect();

        $query = "SELECT * FROM users WHERE id = ? ";
        $results = $db->query($query, [$id])->getResult();
        $result = $results[0];

        $absen = intval($result->presensi) - $hari;

        // dd($absen);
        $db = \Config\Database::connect();

        $query3 = "INSERT INTO gaji (id_user, username, tanggal_pembayaran) VALUES (?, ?, ?)";
        $db->query($query3, [$id, $name, $tp]);


        $db = \Config\Database::connect();

        $query2 = "UPDATE users 
                   SET presensi = ?
                   WHERE id = ?";
        $db->query($query2, [$absen, $id]);




        $successMessage = 'pembayaran gaji berhasil dicatat!';
        session()->setFlashdata('success', $successMessage);

        return redirect()->back()->with('reload', true);
    }
}
