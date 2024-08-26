<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<!-- Begin Page Content -->
<?php
$tz = 'Asia/Jakarta';
$dt = new DateTime("now", new DateTimeZone($tz));
$a = $dt->format('Y-m-d-G-i-s');
$wkt_now = $dt->format('Y-m-d');
$sudah_absen = false;

$jam = strtotime($dt->format('Y-m-d H:i:s'));
$telat = strtotime($wkt_absen['waktu_absen']);
$mulai = strtotime($wkt_absen['waktu_mulai']);

foreach ($presensi as $pr) :
    if ($pr['presensi_userid'] == user()->id) {
        if ($wkt_now == date('Y-m-d', strtotime($pr['created_at']))) {
            $sudah_absen = true;
        }
    }
endforeach;
// if ($sudah_absen) {
//     echo 'a';
// } else {
//     echo 'ab';
// }

// if ($jam > $telat) {
//     echo "Sudah Telat";
// } else {
//     echo "Belum Telat";
// }
?>
<?php if (session()->has('success')) : ?>
    <div class="alert alert-success">
        <?= session('success') ?>
    </div>
<?php endif; ?>



<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-chart-pie mr-1 ct">
                Presensi (<?= $wkt_absen['waktu_mulai'] ?>) - (<?= $wkt_absen['waktu_absen'] ?>)</i>
        </h3>

        <div class="card-tools">
            <ul class="nav nav-pills bt ct ml-auto">
                <li class="nav-item ">
                    <a class="nav-link active" href=" #revenue-chart" data-toggle="tab">Data Absen</a>
                </li>

                <?php if (($jam < $telat) && ($jam >= $mulai) && ($sudah_absen == false)) { ?>
                    <li class="nav-item">
                        <a class="nav-link " href="#sales-chart" data-toggle="tab">Absen</a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab">DI TUTUP</a>
                    </li>

                <?php } ?>


                <?php if (in_groups('Admin') || in_groups('Bos')) {
                ?> <li class="nav-item">
                        <a class="nav-link" href="#All" data-toggle="tab">All Absen</a>
                    </li>
                <?php } ?>
                <?php if (in_groups('Admin') || in_groups('Bos')) {
                ?>
                    <li class="nav-item">
                        <a class="nav-link " href=" #waktu" data-toggle="tab">waktu Absen</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <div class="card-body">
        <div class="tab-content p-0">
            <!-- absenku -->
            <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: auto;">
                <div class="card">
                    <div class="card-body">


                        <table id="example1" class="table table-bordered table-striped" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>no</th>
                                    <th>Nama Pegawai</th>
                                    <th>Nama Toko</th>
                                    <th>Waktu Presensi</th>
                                    <th>Foto Presensi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>


                                <?php $i = 1; ?>
                                <?php foreach ($presensi as $pr) : ?>
                                    <?php if ($pr['presensi_userid'] == user()->id) {
                                    ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $pr['nama_presensi']; ?></td>
                                            <td><?= $pr['presensi_nama_toko']; ?></td>
                                            <td><?= $pr['created_at']; ?></td>

                                            <?php if ($pr['keterangan'] != 'masuk') {
                                            ?>

                                                <td><a data-toggle="modal" data-target="#editModal<?= $i ?>">
                                                        <img src="<?= base_url('presensi/' . $pr['foto_presensi']) ?>" alt="Foto absen" width="40" height="40">
                                                    </a>
                                                </td>

                                                <div class="modal fade" id="editModal<?= $i ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <img src="<?= base_url('presensi/' . $pr['foto_presensi']) ?>" alt="Foto absen" width="100%" height="100%">
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } else { ?>
                                                <td> <i class='fas fa-check-circle' style="color: green;"></i></td>
                                            <?php } ?>


                                            <td>
                                                <div class="d-flex">
                                                    <form action="<?= base_url('hapus_presensi/' . $pr['id_presensi'] . '/' . $pr['foto_presensi']); ?>" method="post">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button class="btn btn-danger ml-2" type="submit" onclick="return confirm('Yakin ingin menghapus data Absen: <?= $pr['nama_presensi'] . '( ' . $pr['waktu_presensi'] ?> ' )" title="hapus data absensi"><i class="fas fa-trash"></i></button>
                                                    </form>
                                                </div>

                                            </td>

                                        </tr>
                                    <?php } ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- absen -->
            <?php if (($jam < $telat) && ($jam >= $mulai) && ($sudah_absen == false)) { ?>
                <div class="chart tab-pane " id="sales-chart" style="position: relative; height: auto;">
                    <div class="card">
                        <div class="card-body">
                            <form action="<?= base_url('/simpanPresensi') ?>" method="post" enctype="multipart/form-data">
                                <input type="text" name="presensi_userid" value="<?= user()->id ?>" hidden>
                                <input type="text" name="nama" value="<?= user()->username ?>" hidden>
                                <input type=" text" name="waktu" value="<?= $a ?>" hidden>
                                <input type="text" name="presensi_nama_toko" value="<?= $tokoAll['nama_toko'] ?>" hidden>
                                <div>
                                    <video id="video" width="80%" height="auto" autoplay></video><br>
                                    <button style="margin: 10px;" class="btn btn-primary" id="ambil-foto">Ambil Foto</button>
                                    <canvas id="canvas" width="80%" height="auto" style="display:none;"></canvas>
                                    <img id="hasil-foto" width="80%" height="auto" src="" alt="Hasil Foto" style="display:none;">
                                    <input type="hidden" id="foto_data_url" name="foto_data_url">
                                </div>
                                <button type="submit" class="btn btn-primary" style="margin: 10px;">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php }; ?>

            <!-- All Absen -->
            <div class="chart tab-pane " id="All" style="position: relative; height: auto;">
                <div class="card">

                    <!-- /.card-header -->
                    <div class="card-body">

                        <table id="example2" class="table table-bordered table-striped" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>no</th>
                                    <th>Nama </th>
                                    <th>Nama Toko</th>
                                    <th>Waktu Presensi</th>
                                    <th>keterangan</th>
                                    <th>Foto Presensi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>


                                <?php $i = 1; ?>
                                <?php foreach ($presensi as $pr) : ?>

                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $pr['nama_presensi']; ?></td>
                                        <td><?= $pr['presensi_nama_toko']; ?></td>
                                        <td><?= $pr['created_at']; ?></td>
                                        <td><?= $pr['keterangan']; ?></td>
                                        <?php if ($pr['keterangan'] != 'masuk') {
                                        ?>
                                            <td>
                                                <a data-toggle="modal" data-target="#mdl<?= $i ?>">
                                                    <img src="<?= base_url('presensi/' . $pr['foto_presensi']) ?>" alt="Foto absen" width="40" height="40">
                                                </a>
                                            </td>
                                            <div class="modal fade" id="mdl<?= $i ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <img src="<?= base_url('presensi/' . $pr['foto_presensi']) ?>" alt="Foto absen" width="100%" height="100%">
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <td><i class='fas fa-check-circle' style="color: green;"></i></td>
                                        <?php } ?>

                                        <td>
                                            <div class="d-flex">
                                                <form action="<?= base_url('hapus_presensi/' . $pr['id_presensi'] . '/' . $pr['foto_presensi']); ?>" method="post">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button class="btn btn-danger ml-2" type="submit" onclick="return confirm('Yakin ingin menghapus data Absen: <?= $pr['nama_presensi'] . '( ' . $pr['waktu_presensi'] ?> ' )" title="hapus data absensi"><i class="fas fa-trash"></i></button>
                                                </form>
                                                <?php if ($pr['keterangan'] != 'masuk') {
                                                ?>
                                                    <form action="<?= base_url('cek_presensi/' . $pr['id_presensi'] . '/' . $pr['foto_presensi'] . '/' . $pr['presensi_userid']); ?>" method="post">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button class="btn btn-success ml-2" type="submit" onclick="return confirm('Yakin ingin menyimpan data Absen: <?= $pr['nama_presensi'] . '( ' . $pr['waktu_presensi'] ?> ' )" title="validasi absensi"><i class="fas fa-check-square"></i></button>
                                                    </form>

                                                <?php } ?>
                                            </div>
                                        </td>






                                    </tr>
                                <?php endforeach; ?>


                            </tbody>

                        </table>

                    </div>
                    <!-- /.card-body -->
                </div>
                <hr>
                <!-- point -->
                <div class="card">

                    <!-- /.card-header -->
                    <div class="card-body">

                        <table id="example3" class="table table-bordered table-striped" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>no</th>
                                    <th>Nama </th>
                                    <th>Total Presensi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php $i = 1; ?>
                                <?php foreach ($user as $usr) : ?>

                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $usr['username']; ?></td>
                                        <td><?= $usr['presensi']; ?> Hari</td>


                                        <td>
                                            <div class="d-flex">
                                                <!-- Button gaji modal -->
                                                <button type="button" class="btn btn-success" title="Pembayaran Gaji" data-toggle="modal" data-target="#pg<?= $usr['id']; ?>">
                                                    <i class="fas fa-money-bill-alt"></i>
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="pg<?= $usr['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Pembayaran Gaji</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="<?= base_url('/gaji') ?>" method="post">

                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label for="gaji">Absen akan dikurang (Hari):</label>
                                                                        <input type="number" class="form-control" name="hari" value="30">
                                                                        <input type="number" class="form-control" hidden name="id_user" value="<?= $usr['id']; ?>">
                                                                        <input type="text" class="form-control" hidden name="username" value="<?= $usr['username']; ?>">
                                                                        <input type="date" class="form-control" hidden name="tanggal_pembayaran" value="<?= date('Y-m-d'); ?>">

                                                                    </div>

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary">Konfirmasi</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>



                                    </tr>
                                <?php endforeach; ?>


                            </tbody>

                        </table>

                    </div>
                    <!-- /.card-body -->
                </div>


            </div>

            <!-- set Absen -->
            <div class="chart tab-pane " id="waktu" style="position: relative; height: auto;">
                <div class="card">
                    <div class="card-body">
                        <form action="<?= base_url('/waktuSetPresensi') ?>" method="post">
                            <label>mulai : </label>
                            <input type="time" name="waktu_presensi_mulai" value="<?= $wkt_absen['waktu_mulai'] ?>" required>
                            <label>selesai : </label>

                            <input type="time" name="waktu_presensi" value="<?= $wkt_absen['waktu_absen'] ?>" required>

                            <button class="btn btn-primary" style="margin: 10px;" type="submit">Submit</button>

                        </form>



                    </div>
                </div>

            </div>
        </div>
    </div><!-- /.card-body -->

</div>


<?php if (($jam < $telat) && ($jam >= $mulai) && ($sudah_absen == false)) { ?>

    <script>
        const videoElement = document.getElementById('video');
        const ambilFotoButton = document.getElementById('ambil-foto');
        const canvasElement = document.getElementById('canvas');
        const hasilFotoElement = document.getElementById('hasil-foto');
        const fotoDataURLInput = document.getElementById('foto_data_url');

        navigator.mediaDevices
            .getUserMedia({
                video: true
            })
            .then(function(stream) {
                videoElement.srcObject = stream;
            })
            .catch(function(error) {
                console.error('Gagal mengakses kamera:', error);
            });

        ambilFotoButton.addEventListener('click', function() {
            canvasElement.width = videoElement.videoWidth;
            canvasElement.height = videoElement.videoHeight;
            canvasElement.getContext('2d').drawImage(videoElement, 0, 0, canvasElement.width, canvasElement.height);

            const hasilFotoDataURL = canvasElement.toDataURL('image/png'); // atau 'image/png' untuk PNG

            hasilFotoElement.src = hasilFotoDataURL;
            fotoDataURLInput.value = hasilFotoDataURL;

            hasilFotoElement.style.display = 'block';
            event.preventDefault(); // Menghentikan tindakan default tombol "Ambil Foto"

        });
    </script>


    <script>
        // Dapatkan elemen-elemen yang diperlukan
        var gambarLink = document.getElementById('gambarLink');
        var modal = document.getElementById('mdl');
        var tutup = document.getElementsByClassName('close')[0];

        // Tangani klik pada gambar kecil
        gambarLink.onclick = function() {
            modal.style.display = 'block';
        }

        // Tangani klik pada tombol Tutup (close)
        tutup.onclick = function() {
            modal.style.display = 'none';
        }
    </script>


<?php }; ?>




<?= $this->endSection(); ?>