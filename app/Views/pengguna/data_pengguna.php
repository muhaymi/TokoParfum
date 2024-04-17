<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<?php if (session()->has('success')) : ?>
    <div class="alert alert-success">
        <?= session('success') ?>
    </div>
<?php endif; ?>
<?php if (session()->has('unsuccess')) : ?>
    <div class="alert alert-danger">
        <?= session('unsuccess') ?>
    </div>
<?php endif; ?>



<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-address-card"></i>
            Data Pengguna
        </h3>
        <div class="card-tools">
            <ul class="nav nav-pills ml-auto">

                <li class="nav-item">
                    <a class="nav-link active" href="#revenue-chart" data-toggle="modal" data-target="#tambahPenggunaModal" title="Tambah Pengguna"><i class="fa fa-user-plus"></i></a>
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
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>

                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>No HP</th>
                                    <th>Role</th>
                                    <th>Toko</th>
                                    <th>Foto</th>
                                    <!-- <th>gambar Produk</th> -->
                                    <th>Opsi</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0;
                                foreach ($user as $dus) : $i++; ?>

                                    <tr>
                                        <td><?= $dus['username']; ?></td>
                                        <td><?= $dus['email']; ?></td>
                                        <td><?= $dus['no_hp']; ?></td>
                                        <td> </td>
                                        <td> </td>
                                        <td> </td>

                                        <!-- <td>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#gambarProduk<?= $i ?>">
                                <img src="<?= base_url('username/') . $dus['username'] ?>" style="width: 30px; height: 30px; object-fit: fill; background-color:white;" alt="Gambar Produk">
                            </button>
                        </td> -->
                                        <!-- modal Gambar -->
                                        <!-- <div class="modal fade" id="gambarProduk<?= $i ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Gambar Produk</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="container">
                                            <img src="<?= base_url('username/') . $dus['username'] ?>" style="width: 100%; height: 100%; object-fit: fill; background-color:white;" alt="Gambar Produk">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                                        <td>
                                            <div class="d-flex">
                                                <button style="margin: 2px;" class="btn btn-primary edit-btn" title="ubah password" data-toggle="modal" data-target="#ubahPWModal" data-id="<?= $dus['id'] ?>" data-nama="<?= $dus['username'] ?>"><i class="fas fa-key"></i></button>
                                                <button style="margin: 2px;" class="btn btn-primary edit-btn" title="Ubah Data Pengguna" data-toggle="modal" data-target="#ubahdataModal" data-id="<?= $dus['id'] ?>" data-nama="<?= $dus['username'] ?>"><i class="fas fa-pencil-alt"></i></button>

                                                <form action="<?= base_url('hapus_pengguna/' . $dus['id']); ?>" method="post"><?= csrf_field() ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button title="Hapus" class="btn btn-danger ml-2" type="submit" onclick="return confirm('Yakin ingin menghapus data : <?= $dus['username'] ?> ')"><i class="fas fa-trash"></i></button>
                                                </form>
                                            </div>
                                        </td>

                                    </tr>

                                <?php endforeach; ?>



                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk menambah Pengguna -->
    <div class="modal fade" id="tambahPenggunaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Pengguna</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form untuk menambah toko akan ditempatkan di sini -->
                    <form action="<?= base_url('/simpan_pengguna'); ?>" class="user" method="post">
                        <?= csrf_field() ?>

                        <div class="form-group row">
                            <div class="col-sm-12">
                                <input type="email" class="form-control form-control-user <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" name="email" aria-describedby="emailHelp" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12">
                                <input type="text" class="form-control form-control-user <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>" name="username" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="password" name="password" class="form-control form-control-user <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.password') ?>" autocomplete="off">
                            </div>

                            <div class="col-sm-6">
                                <input type="password" name="pass_confirm" class="form-control form-control-user <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.repeatPassword') ?>" autocomplete="off">
                            </div>
                        </div>

                        <br>

                        <button type="submit" class="btn btn-primary btn-user btn-block">Simpan</button>

                    </form>


                </div>
            </div>
        </div>
    </div>
    <!-- end -->



    <!-- Modal untuk ubah data -->
    <div class="modal fade" id="ubahdataModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Password <p id="namadata"></p>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form untuk menambah toko akan ditempatkan di sini -->
                    <form action="<?= base_url('/ubah_data'); ?>" class="user" method="post">
                        <?= csrf_field() ?>

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" placeholder="Masukkan Username">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Masukkan Email">
                        </div>
                        <div class="form-group">
                            <label for="no_hp">No HP</label>
                            <input type="text" class="form-control" id="no_hp" placeholder="Masukkan Nomor HP">
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select class="form-control" id="role">
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="toko">Toko</label>
                            <input type="text" class="form-control" id="toko" placeholder="Masukkan Nama Toko">
                        </div>
                        <div class="form-group">
                            <label for="foto">Foto</label>
                            <input type="file" class="form-control-file" id="foto">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>




                </div>
            </div>
        </div>
    </div>
    <!-- end -->


    <!-- Modal untuk ubah pw -->
    <div class="modal fade" id="ubahPWModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Password <p id="namapw"></p>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form untuk menambah toko akan ditempatkan di sini -->
                    <form action="<?= base_url('/ubah_PW'); ?>" class="user" method="post">
                        <?= csrf_field() ?>

                        <input type="hidden" name="user_id" id="idpw">
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <input type="password" name="password" class="form-control form-control-user <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.password') ?>" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <input type="password" name="pass_confirm" class="form-control form-control-user <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.repeatPassword') ?>" autocomplete="off" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>

                    </form>


                </div>
            </div>
        </div>
    </div>
    <!-- end -->





</div>

<script src="<?= base_url('') ?>jq.js"></script>


<script>
    $(document).ready(function() {
        $(document).on('touchstart click', '.edit-btn', function() {
            var id = $(this).data('id');
            var nama = $(this).data('nama');
            // Mengisi input 
            $('#idpw').val(id);
            $('#namapw').text(nama);
        });
    });
</script>


<?= $this->endSection() ?>