<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<!-- Begin Page Content -->
<?php if (session()->has('success')) : ?>
    <div class="alert alert-success">
        <?= session('success') ?>
    </div>
<?php endif; ?>


<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-store"></i>
            TOKO
        </h3>
        <div class="card-tools">
            <ul class="nav nav-pills ml-auto">

                <li class="nav-item">
                    <a class="nav-link active" href="#revenue-chart" data-toggle="modal" data-target="#tambahTokoModal">Tambah Toko</a>
                </li>


            </ul>
        </div>
    </div><!-- /.card-header -->
    <div class="card-body">
        <div class="tab-content p-0">
            <!-- Morris chart - Sales -->
            <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: auto;">

                <div class="card">

                    <!-- /.card-header -->
                    <div class="card-body">

                        <table id="example1" class="table table-bordered table-striped" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Nama Toko</th>
                                    <th>Email Toko</th>
                                    <th>Hp Toko</th>
                                    <th>Logo </th>
                                    <th>Alamat</th>
                                    <th>ACC SUP</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($tokoAll as $t) :
                                    $i++; ?>

                                    <tr>
                                        <td><?= $t['nama_toko']; ?></td>
                                        <td><?= $t['email_toko']; ?></td>
                                        <td><?= $t['hp_toko']; ?></td>
                                        <td>
                                            <a class="slogo" data-toggle="modal" data-target="#logo" data-logo="<?= $t['logo_toko']; ?>">
                                                <img src="<?= base_url('logo/') ?><?= $t['logo_toko'] ?>" style="width: 30px; height: 30px; object-fit: fill; background-color:white;">
                                            </a>

                                        </td>
                                        <td><?= $t['alamat_toko']; ?></td>
                                        <td><?= $t['sup_acc']; ?></td>
                                        <td>

                                            <div class="d-flex">
                                                <button class="btn btn-primary edit-btn" data-toggle="modal" data-target="#editModal" data-id="<?= $t['id_toko']; ?>" data-nama="<?= $t['nama_toko']; ?>" data-alamat="<?= $t['alamat_toko']; ?>" data-hp="<?= $t['hp_toko']; ?>" data-logo="<?= $t['logo_toko']; ?>" data-email="<?= $t['email_toko']; ?>">
                                                    UBAH</button>

                                                <form action="<?= base_url('hapus_toko/' . $t['id_toko']); ?>" method="post"><?= csrf_field() ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button class="btn btn-danger ml-2" type="submit" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                                                </form>

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


            <!-- Modal untuk menambah toko -->
            <div class="modal fade" id="tambahTokoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Toko</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Form untuk menambah toko akan ditempatkan di sini -->
                            <form action="<?= base_url('/toko_baru') ?>" method="post" enctype="multipart/form-data"><?= csrf_field() ?>
                                <div class="form-group">
                                    <label for="nama_toko">Nama Toko</label>
                                    <input type="text" class="form-control" id="nama_toko" name="nama_toko" required>
                                </div>
                                <div class="form-group">
                                    <label for="email_toko">Email Toko:</label>
                                    <input type="email" class="form-control" name="email_toko">
                                </div>
                                <div class="form-group">
                                    <label for="hp_toko">Hp Toko</label>
                                    <input class="form-control" id="hp_toko" name="hp_toko" value="+62">
                                </div>
                                <div class="form-group">
                                    <label for="logo_toko">Logo Toko</label>
                                    <input type="file" class="form-control" id="logo_toko" name="logo_toko">
                                </div>
                                <div class="form-group">
                                    <label for="alamat_toko">Alamat Toko</label>
                                    <textarea class="form-control" id="alamat_toko" name="alamat_toko" required rows="3"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
            <!-- end -->


            <!-- Modal untuk Ubah toko -->
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Data Toko</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Form untuk mengedit data -->
                            <form action="<?= base_url('/ubah_toko'); ?>" method="post" enctype="multipart/form-data"><?= csrf_field() ?>

                                <div class="form-group">
                                    <label>Nama Toko</label>
                                    <input type="text" class="form-control" id="namaToko" name="nama_toko" required>
                                </div>
                                <div class="form-group">
                                    <label for="email_toko">Email Toko:</label>
                                    <input type="email" class="form-control" id="emailToko" name="email_toko">
                                </div>
                                <div class="form-group">
                                    <label>Hp Toko</label>
                                    <input class="form-control" id="hpToko" name="hp_toko" value="+62">
                                </div>
                                <div class="form-group">
                                    <label>Logo Toko Sebelumnya</label>
                                    <input type="text" class="form-control" id="logoToko" name="logo_toko_s">
                                </div>
                                <div class="form-group">
                                    <label>Logo Toko</label>
                                    <input type="file" class="form-control" name="logo_toko">
                                </div>
                                <div class="form-group">
                                    <label>Alamat Toko</label>
                                    <textarea class="form-control" id="alamatToko" name="alamat_toko" rows="3" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label>SUP ACC:</label>
                                    <select class="form-control" name="sup_acc">
                                        <option value="no">No</option>
                                        <option value="yes">Yes</option>
                                    </select>
                                </div>

                                <input type="text" class="form-control" id="editId" name="id_toko" hidden>

                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- modal logo -->
            <div class="modal fade" id="logoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Gambar Toko</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Isi modal dengan gambar -->
                            <img id="modalImage" src="" style="width: 100%;" alt="Logo Toko">
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.card-body -->

    </div>


    <script src="<?= base_url('') ?>jq.js"></script>


    <!-- ubah -->
    <script>
        $(document).ready(function() {
            $(document).on('touchstart click', '.edit-btn', function() {
                var id = $(this).data('id');
                var namaToko = $(this).data('nama');
                var alamatToko = $(this).data('alamat');
                var hpToko = $(this).data('hp');
                var logoToko = $(this).data('logo');
                var emailToko = $(this).data('email');

                // Mengisi input 
                $('#editId').val(id);
                $('#namaToko').val(namaToko);
                $('#alamatToko').val(alamatToko);
                $('#hpToko').val(hpToko);
                $('#logoToko').val(logoToko);
                $('#emailToko').val(emailToko);

                // Tampilkan modal
                $('#editModal').modal('show');
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            // Menangani klik pada elemen dengan data-toggle dan data-target
            $(document).on('touchstart click', '.slogo', function() {
                // Mengambil nilai dari atribut data-logo
                var logoSrc = $(this).data('logo');

                // Menetapkan nilai src pada elemen gambar modal
                $('#modalImage').attr('src', '<?= base_url('logo/') ?>' + logoSrc);

                // Menampilkan modal
                $('#logoModal').modal('show');
            });
        });
    </script>



    <!-- /.container-fluid -->
    <?= $this->endSection(); ?>