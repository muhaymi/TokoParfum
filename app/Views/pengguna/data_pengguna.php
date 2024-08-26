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
    <div class="card-body">
        <div class="container">
            <ul class="nav nav-tabs" id="myTabs" role="tablist">
                <li class="nav-item">
                    <a class="tablink nav-link active" onclick="openTab(event, 'tab1')">
                        <h3 class="card-title">
                            <i class="fas fa-address-card"></i>
                            Data Pengguna
                        </h3>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="tablink nav-link" onclick="openTab(event, 'tab2')">
                        <h3 class="card-title">
                            <i class="fas fa-user-plus"></i>
                            Tambah Pengguna
                        </h3>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="tablink nav-link" onclick="openTab(event, 'tab3')">
                        <h3 class="card-title">
                            <i class="fas fa-user-edit"></i>
                            Profile
                        </h3>
                    </a>
                </li>
            </ul>

            <hr>
            <?= view('Myth\Auth\Views\_message_block') ?>

            <div id="tab1" class="tabcontent" style="display: block;">
                <!-- Tabel Data Pengguna -->
                <div class="card">
                    <div class="card-body">

                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>No HP</th>
                                    <th>Role</th>
                                    <th>Toko</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($user as $index => $dus) : ?>
                                    <tr>
                                        <td><?= $dus['username']; ?></td>
                                        <td><?= $dus['email']; ?></td>
                                        <td><?= $dus['no_hp']; ?></td>
                                        <td><?= $dus['name']; ?></td>
                                        <td><?= $dus['nama_toko']; ?></td>
                                        <td>
                                            <div class="d-flex">
                                                <button style="margin: 2px;" class="btn btn-primary edit-pw" title="ubah password" data-toggle="modal" data-target="#ubahPWModal" data-id="<?= $dus['user_id'] ?>" data-nama="<?= $dus['username'] ?>"><i class="fas fa-key"></i></button>
                                                <button style="margin: 2px;" class="btn btn-primary edit-btn" title="Ubah Data Pengguna" data-toggle="modal" data-target="#ubahdataModal" data-id="<?= $dus['user_id'] ?>" data-nama="<?= $dus['username'] ?>" data-email="<?= $dus['email'] ?>" data-toko="<?= $dus['nama_toko'] ?>" data-ag="<?= $dus['name'] ?>" data-nope="<?= $dus['no_hp'] ?>" data-agu="<?= $dus['id_AGU']; ?>"><i class="fas fa-pencil-alt"></i></button>
                                                <form action="<?= base_url('hapus_pengguna/' . $dus['user_id']); ?>" method="post"><?= csrf_field() ?>
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
            <!-- End Tab 1 -->

            <div id="tab2" class="tabcontent" style="display: none;">
                <!-- Form Tambah Pengguna -->
                <div class="card">
                    <div class="card-body">

                        <form action="<?= url_to('register') ?>" method="post">
                            <?= csrf_field() ?>

                            <div class="form-group">
                                <label for="email"><?= lang('Auth.email') ?></label>
                                <input type="email" class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" name="email" aria-describedby="emailHelp" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>">
                                <small id="emailHelp" class="form-text text-muted"><?= lang('Auth.weNeverShare') ?></small>
                            </div>

                            <div class="form-group">
                                <label for="username"><?= lang('Auth.username') ?></label>
                                <input type="text" class="form-control <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>" name="username" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>">
                            </div>

                            <div class="form-group">
                                <label for="password"><?= lang('Auth.password') ?></label>
                                <input type="password" name="password" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.password') ?>" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label for="pass_confirm"><?= lang('Auth.repeatPassword') ?></label>
                                <input type="password" name="pass_confirm" class="form-control <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.repeatPassword') ?>" autocomplete="off">
                            </div>

                            <button type="submit" class="btn btn-primary btn-block"><?= lang('Auth.register') ?></button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- End Tab 2 -->

            <div id="tab3" class="tabcontent" style="display: none;">
                <!-- Form Data Saya -->
                <div class="card">
                    <div class="card-body">
                        <div style="margin-bottom: 20px;">
                            <img src="<?= base_url('pengguna/' . user()->foto_profile) ?>" id="preview" alt="Profile Picture" style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover;">
                        </div>
                        <button style="margin: 2px;" class="btn btn-primary " title="ubah password" data-toggle="modal" data-target="#ubahPWkuModal"><i class="fas fa-key"> Ubah Password</i></button>

                        <form action="<?= base_url('/ubah_data_ku') ?>" method="post" enctype="multipart/form-data"><?= csrf_field() ?>
                            <div style="margin-bottom: 15px;">
                                <label for="username" style="font-weight: bold;">Username:</label><br>
                                <input type="text" name="username" value="<?= user()->username ?>" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
                            </div>
                            <div style="margin-bottom: 15px;">
                                <label for="email" style="font-weight: bold;">Email:</label><br>
                                <input type="email" name="email" value="<?= user()->email ?>" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
                            </div>
                            <div style="margin-bottom: 15px;">
                                <label for="phone" style="font-weight: bold;">Phone Number:</label><br>
                                <input type="tel" name="phone" value="<?= user()->no_hp ?>" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
                            </div>
                            <div style="margin-bottom: 15px;">
                                <label for="profilePicture" style="font-weight: bold;">Profile Picture:</label><br>
                                <input type="file" name="foto_baru" onchange="previewImage(event)" class="form-control">
                            </div>
                            <input type="text" hidden name="foto_lama" value="<?= user()->foto_profile ?>" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
                            <input type="text" hidden name="id" value="<?= user()->id ?>" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">

                            <button type="submit" style="background-color: #007bff; border: none; color: white; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; border-radius: 5px; cursor: pointer;">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Tab 3 -->

        </div>
    </div>
</div>



<script>
    function openTab(evt, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.querySelectorAll(".tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.querySelectorAll(".tablink");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].classList.remove("active");
        }
        evt.currentTarget.classList.add("active");

        document.getElementById(tabName).style.display = "block";
    }
</script>



<script>
    function previewImage(event) {
        const preview = document.getElementById('preview');
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onloadend = function() {
            preview.src = reader.result;
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
        }
    }
</script>







<!-- Modal untuk ubah data -->
<div class="modal fade" id="ubahdataModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Data <p id="namadata"></p>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form untuk menambah toko akan ditempatkan di sini -->
                <form action="<?= base_url('/ubah_data_pengguna'); ?>" class="user" method="post">
                    <?= csrf_field() ?>
                    <input type="text" class="form-control" id="id_agu" name="id_agu" hidden>
                    <input type="text" class="form-control" id="idku" name="id_user" hidden>

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="namaku" name="username" placeholder="Masukkan Username">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="emailku" name="email" placeholder="Masukkan Email">
                    </div>
                    <div class="form-group">
                        <label for="no_hp">No HP</label>
                        <input type="text" class="form-control" id="nopeku" name="nope" placeholder="Masukkan Nomor HP">
                    </div>
                    <div class="form-group">
                        <label for="role">role ( <i id="ag"></i> ) </label>
                        <select class="form-control" name="role" required>
                            <option value='' disabled selected>Pilih Role</option>
                            <?php foreach ($ag as $ag) :  ?>
                                <option value="<?= $ag['id'] ?>"><?= $ag['name'] ?></option>
                            <?php endforeach ?>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="toko">Toko ( <i id="tokoku"></i> ) </label>
                        <select class="form-control" name="toko" required>
                            <option value='' disabled selected>Pilih Toko</option>
                            <?php foreach ($toko as $tk) :  ?>
                                <option value="<?= $tk['id_toko'] ?>"><?= $tk['nama_toko'] ?></option>
                            <?php endforeach ?>

                        </select>
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
                <h5 class="modal-title">Ubah Password <p id="nama1"></p>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form untuk menambah toko akan ditempatkan di sini -->
                <form action="<?= base_url('/ubah_PW'); ?>" class="user" method="post">
                    <?= csrf_field() ?>

                    <input type="hidden" name="user_id" id="id1">
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

<!-- Modal untuk ubah pwku -->
<div class="modal fade" id="ubahPWkuModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Password <p><?= user()->username ?></p>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form untuk menambah toko akan ditempatkan di sini -->
                <form action="<?= base_url('/ubah_PW'); ?>" class="user" method="post">
                    <?= csrf_field() ?>

                    <input type="hidden" name="user_id" value="<?= user()->id ?>">
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
</div>




<script src="<?= base_url('') ?>jq.js"></script>


<script>
    $(document).ready(function() {
        $(document).on('touchstart click', '.edit-btn', function() {
            var id = $(this).data('id');
            var nama = $(this).data('nama');
            var email = $(this).data('email');
            var toko = $(this).data('toko');
            var nope = $(this).data('nope');
            var ag = $(this).data('ag');
            var agu = $(this).data('agu');
            // Mengisi input 
            $('#idku').val(id);
            $('#namaku').val(nama);
            $('#emailku').val(email);
            $('#tokoku').text(toko);
            $('#nopeku').val(nope);
            $('#ag').text(ag);
            $('#id_agu').val(agu);
        });
    });
</script>

<script>
    $(document).ready(function() {
        $(document).on('touchstart click', '.edit-pw', function() {
            var id = $(this).data('id');
            var nama = $(this).data('nama');

            // Mengisi input 
            $('#id1').val(id);
            $('#nama1').text(nama);
            $('#id2').val(id);
            $('#nama2').text(nama);

        });
    });
</script>


<?= $this->endSection() ?>