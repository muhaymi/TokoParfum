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
            <i class="fas fa-people-arrows ct"> Member</i>
        </h3>
        <div class="card-tools">
            <ul class="nav nav-pills ml-auto">
                <li class="nav-item">
                    <button type="button" class="btn btn-warning mx-1 bt" data-toggle="modal" data-target="#member" title="Tambah Member">
                        <i class="fas fa-id-card mx-2 ct"></i><i class="fa fa-plus-circle ct"> Tambah Member</i>
                    </button>
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
                                    <th>Id member </th>
                                    <th>Nama </th>
                                    <th>Alamat</th>
                                    <th>HP</th>
                                    <th>Point</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($mbr as $t) : ?>
                                    <tr>
                                        <td><?= $t['id_member']; ?></td>
                                        <td><?= $t['nama_member']; ?></td>
                                        <td><?= $t['alamat_member']; ?></td>
                                        <td><?= $t['no_hp']; ?></td>
                                        <td><?= $t['poin_member']; ?></td>

                                        <td>
                                            <div class="d-flex">
                                                <button style="margin: 2px;" class="btn btn-primary edit-btn bt" data-toggle="modal" data-target="#edit_mbr" data-id="<?= $t['id_member']; ?>" data-nama="<?= $t['nama_member']; ?>" data-alamat="<?= $t['alamat_member']; ?>" data-hp="<?= $t['no_hp']; ?>" data-poin="<?= $t['poin_member']; ?>" title="edit data member">
                                                    <i class="fas fa-pencil-alt ct"></i></button>
                                                <form action="<?= base_url('hapus_member/' . $t['id_member']); ?>" method="post"><?= csrf_field() ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button class="btn btn-danger ml-2" title="hapus data member" type="submit" onclick="return confirm('Yakin ingin menghapus data ini?')"> <i class="fas fa-trash ct"></i></button>
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


            <!-- end -->

            <div class="modal fade" id="member" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <form action="<?= base_url('/tambah_member'); ?>" method="post" autocomplete="off"><?= csrf_field() ?>
                            <div class="modal-header">
                                <h5 class="modal-title ct" id="editModalLabel">Tambah Member</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="id_member" class="form-label">ID Member</label>
                                            <a href="#" style='font-size:20px' class='far bt' onclick="ubahNilai(); return false;" title="Generate ID">&#xf359;</a>
                                            <input type="text" list="namprod" class="form-control" id="id_member" name="id_member" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_member">Nama Member</label>
                                            <input type="text" class="form-control" name="nama_member" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="alamat_member">Alamat Member</label>
                                            <textarea class="form-control" name="alamat_member" rows="3"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Hp Member</label>
                                            <input class="form-control" name="no_hp" value="+62">
                                        </div>
                                        <input class="form-control" name="tipe_member" value="grosir" hidden>

                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

            <!-- Modal untuk Ubah Paket -->
            <div class="modal fade" id="edit_mbr" tabindex="-1" role="dialog" aria-labelledby="mbrLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="mbrLabel">Edit Data Member</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Form untuk mengedit data member -->
                            <form action="<?= base_url('/edit_member'); ?>" method="post" autocomplete="off"><?= csrf_field() ?>

                                <div class="form-group">
                                    <label for="nama_member">Nama Member</label>
                                    <input type="text" class="form-control" name="nama_member" id="nm" required>
                                </div>
                                <div class="form-group">
                                    <label for="alamat_member">Alamat Member</label>
                                    <textarea class="form-control" name="alamat_member" rows="3" id="am"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Hp Member</label>
                                    <input class="form-control" name="no_hp" value="+62" id="hp">
                                </div>
                                <div class="form-group">
                                    <label>Point Member</label>
                                    <input class="form-control" name="poin" id="pm" required>
                                </div>
                                <input class="form-control" name="id_member" id="idm" hidden>


                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- end -->



        </div><!-- /.card-body -->
    </div>
</div>

<script src="<?= base_url('') ?>jq.js"></script>
<script src="<?= base_url('') ?>rp.js"></script><!-- member   -->

<script>
    $(document).ready(function() {
        $(document).on('touchstart click', '.edit-btn', function() {
            var id = $(this).data('id');
            var nama = $(this).data('nama');
            var alamat = $(this).data('alamat');
            var no_hp = $(this).data('hp');
            var poin = $(this).data('poin');

            $('#idm').val(id);
            $('#nm').val(nama);
            $('#am').val(alamat);
            $('#hp').val(no_hp);
            $('#pm').val(poin);

        });
    });
</script>



<?= $this->endSection(); ?>