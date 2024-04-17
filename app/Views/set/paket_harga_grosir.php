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
            Paket
        </h3>
        <div class="card-tools">
            <ul class="nav nav-pills ml-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="#revenue-chart" data-toggle="modal" data-target="#tambahPaketModal">Tambah Paket Harga</a>
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
                                    <th>Nama Paket</th>
                                    <th>Tipe Paket</th>
                                    <th>Jenis Paket</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($paket as $t) : ?>
                                    <tr>
                                        <td><?= $t['nama_paket']; ?></td>
                                        <td><?= $t['tipe_paket']; ?></td>
                                        <td><?= $t['jenis_paket']; ?></td>

                                        <td>
                                            <div class="d-flex">
                                                <button class="btn btn-primary edit-btn" data-toggle="modal" data-target="#editPaketModal" data-id="<?= $t['id_paket']; ?>" data-namket="<?= $t['nama_paket']; ?>" data-jeket="<?= $t['jenis_paket']; ?>" data-tiket="<?= $t['tipe_paket']; ?>">
                                                    UBAH</button>
                                                <form action="<?= base_url('hapus_paket_grosir/' . $t['id_paket']); ?>" method="post"><?= csrf_field() ?>
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

            <!-- Modal untuk Tambah Paket -->
            <div class="modal fade" id="tambahPaketModal" tabindex="-1" role="dialog" aria-labelledby="tambahPaketModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahPaketModalLabel">Tambah Data Paket</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Form untuk menambah data paket -->
                            <form action="<?= base_url('/tambah_paket_grosir'); ?>" method="post" enctype="multipart/form-data"><?= csrf_field() ?>

                                <div class="form-group">
                                    <label>Nama Paket</label>
                                    <input type="text" class="form-control" id="namaPaket" name="nama_paket" required>
                                </div>
                                <div class="form-group">
                                    <label for="tipe_paket">Tipe Paket:</label>
                                    <select class="form-control" id="tipe_paket" name="tipe_paket">
                                        <option value="Grosir">Grosir</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Jenis Paket</label>
                                    <input type="text" class="form-control" id="jenisPaket" name="jenis_paket" required>
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- end -->

            <!-- Modal untuk Ubah Paket -->
            <div class="modal fade" id="editPaketModal" tabindex="-1" role="dialog" aria-labelledby="editPaketModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editPaketModalLabel">Edit Data Paket</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Form untuk mengedit data paket -->
                            <form action="<?= base_url('/edit_paket_grosir'); ?>" method="post" enctype="multipart/form-data"><?= csrf_field() ?>

                                <div class="form-group">
                                    <label>Nama Paket</label>
                                    <input type="text" class="form-control" id="editNamaPaket" name="nama_paket" required>
                                    <input type="text" class="form-control" id="editId" name="id_paket" required hidden>
                                </div>
                                <div class="form-group">
                                    <label for="tipe_paket">Tipe Paket:</label>
                                    <select class="form-control" id="editTipesPaket" name="tipe_paket">
                                        <option value="Grosir">Grosir</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Jenis Paket</label>
                                    <input type="text" class="form-control" id="editJenisPaket" name="jenis_paket" required>
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- end -->

            <!-- modal logo -->
            <div class="modal fade" id="logoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <!-- Bagian modal logo -->
            </div>
            <!-- end -->
        </div><!-- /.card-body -->
    </div>
</div>

<script src="<?= base_url('') ?>jq.js"></script>
<script>
    $(document).ready(function() {
        $(document).on('touchstart click', '.edit-btn', function() {
            var id = $(this).data('id');
            var namket = $(this).data('namket');
            var jeket = $(this).data('jeket');
            var tiket = $(this).data('tiket');
         

            // Mengisi input 
            $('#editId').val(id);
            $('#editNamaPaket').val(namket);
            $('#editJenisPaket').val(jeket);
            $('#editTipesPaket').val(tiket);
           
    

        });
    });
</script>



<?= $this->endSection(); ?>