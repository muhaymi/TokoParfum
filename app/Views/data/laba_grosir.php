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
            <i class="	fas fa-chart-line ct"> Laba</i>
        </h3>

    </div>
    <div class="card-body">

        <div class="container">
            <form id="labaForm">
                <div class="form-row align-items-center">
                    <div class="col-auto">
                        <label for="start" class="col-form-label">Tanggal Mulai:</label>
                    </div>
                    <div class="col-auto">
                        <input type="date" class="form-control mb-2" id="start" name="start" required>
                    </div>
                    <div class="col-auto">
                        <label for="over" class="col-form-label">Tanggal Akhir:</label>
                    </div>
                    <div class="col-auto">
                        <input type="date" class="form-control mb-2" id="over" name="over" required>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary mb-2">Cek Laba</button>
                    </div>
                </div>
            </form>
            <!-- Modal -->
            <div class="modal fade" id="labaModal" tabindex="-1" role="dialog" aria-labelledby="labaModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="labaModalLabel">Hasil Laba</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="modalBody">
                            <!-- Hasil laba akan ditampilkan di sini -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('#labaForm').on('submit', function(event) {
                    event.preventDefault();
                    $.ajax({
                        url: "<?= base_url('laba/cek') ?>",
                        method: "POST",
                        data: $(this).serialize(),
                        success: function(data) {
                            $('#modalBody').html(data);
                            $('#labaModal').modal('show');
                        }
                    });
                });
            });
        </script>


    </div>
</div>

<div class="card">

    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-sort ct"> Pendapatan Dan Pengeluaran</i>
        </h3>
        <div class="card-tools">
            <ul class="nav nav-pills ml-auto">
                <li class="nav-item">
                    <button class="btn btn-primary bt" data-toggle="modal" data-target="#modalTambah">Tambah Transaksi</button>
                </li>
            </ul>
        </div>
    </div><!-- /.card-header -->


    <div class="card-body">

        <div class="container">
            <table id="example1" class="table table-bordered table-striped" style="width: 100%; ">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Deskripsi</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($keuangan_grosir as $row) : ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['jenis'] ?></td>
                            <td><?= $row['jumlah'] ?></td>
                            <td><?= $row['deskripsi'] ?></td>
                            <td><?= $row['tanggal'] ?></td>
                            <td>
                                <button class="btn btn-warning" data-toggle="modal" data-target="#modalEdit<?= $row['id'] ?>">Edit</button>
                                <button class="btn btn-danger" data-toggle="modal" data-target="#modalHapus<?= $row['id'] ?>">Hapus</button>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="modalEdit<?= $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="/edit_lg" method="post">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalEditLabel">Edit Transaksi</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                            <div class="form-group">
                                                <label for="jenis">Jenis</label>
                                                <select class="form-control" name="jenis">
                                                    <option value="pendapatan" <?= $row['jenis'] == 'pendapatan' ? 'selected' : '' ?>>Pendapatan</option>
                                                    <option value="pengeluaran" <?= $row['jenis'] == 'pengeluaran' ? 'selected' : '' ?>>Pengeluaran</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="jumlah">Jumlah</label>
                                                <input type="number" class="form-control" name="jumlah" value="<?= $row['jumlah'] ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="deskripsi">Deskripsi</label>
                                                <input type="text" class="form-control" name="deskripsi" value="<?= $row['deskripsi'] ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="tanggal">Tanggal</label>
                                                <input type="date" class="form-control" name="tanggal" value="<?= $row['tanggal'] ?>" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Hapus -->
                        <div class="modal fade" id="modalHapus<?= $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="modalHapusLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="/hapus_lg/<?= $row['id'] ?>" method="post">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalHapusLabel">Hapus Transaksi</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Apakah Anda yakin ingin menghapus transaksi ini?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Modal Tambah -->
        <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="/tambah_lg" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTambahLabel">Tambah Transaksi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="jenis">Jenis</label>
                                <select class="form-control" name="jenis">
                                    <option value="pendapatan">Pendapatan</option>
                                    <option value="pengeluaran">Pengeluaran</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="jumlah">Jumlah</label>
                                <input type="number" class="form-control" name="jumlah" required>
                            </div>
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <input type="text" class="form-control" name="deskripsi" required>
                            </div>
                            <div class="form-group">
                                <label for="tanggal">Tanggal</label>
                                <input type="date" class="form-control" name="tanggal" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

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