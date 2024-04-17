<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<!-- Begin Page Content -->
<?php if (session()->has('success')) : ?>
    <div class="alert alert-success">
        <?= session('success') ?>
    </div>
<?php endif; ?>


<?php
function total($data, $cek)
{
    $hj = 0;
    foreach ($data as $u) {
        if ($cek == $u['id_penjualan']) {
            $hj += $u['harga_jadi'];
        }
    }
    return $hj;
};
?>


<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-store"></i>
            Data Pembayaran
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
                                    <th>ID Pembayaran</th>
                                    <th>Penjualan ID</th>
                                    <th>Jenis Pembayaran</th>
                                    <th>Total Pembayaran</th>
                                    <th>Waktu Pembayaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $previous_id_penjualan = null;
                                foreach ($pembayaran as $t) :
                                    if ($t->id_penjualan != $previous_id_penjualan) :
                                ?>
                                        <tr>
                                            <td><?= $t->id_pembayaran; ?></td>
                                            <td><?= $t->id_penjualan; ?></td>
                                            <td><?= $t->jenis_pembayaran; ?></td>
                                            <td><?= total($penjualan, $t->id_penjualan); ?></td>

                                            <td><?= $t->created_at ?></td>
                                            <td>
                                                <div class="d-flex">
                                                    <button type="button" class="btn btn-primary mx-1 strukku" data-toggle="modal" data-target="#stokmin" title="Struk Penjualan" data-idj="<?= $t->id_penjualan ?>" data-ca="<?= $t->created_at ?>">
                                                        <i class="fas fa-receipt"></i>
                                                    </button>
                                                    <button class="btn btn-primary edit-btn" data-toggle="modal" data-target="#editPaketModal" data-id="<?= $t->id_penjualan ?>">
                                                        UBAH</button>

                                                    <form action="<?= base_url('hapus_paket/' . $t->id_penjualan) ?>" method="post"><?= csrf_field() ?>
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button class="btn btn-danger ml-2" type="submit" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                <?php
                                        $previous_id_penjualan = $t->id_penjualan;
                                    endif;
                                endforeach; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="stokmin" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Struk Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="ctksm" style="max-width: 400px; ">
                <div>
                    <h3>Struk Pembelian</h3>
                    <sup id="ca"></sup>
                    <sup id="idj"></sup>

                </div>

                <table width="300px" style="justify-content: space-between; font-family: Arial, sans-serif;">
                    <thead>
                        <tr>
                            <th style="padding-right:20px;">Produk</th>
                            <!-- <th>Jenis</th> -->
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody id="penjualanContainer">
                    </tbody>
                </table>
                <hr width="250px;">
                <div class="d-flex"> <b>Total : </b>
                    <p> Rp. </p>
                    <p id="totalContainer"></p>
                </div>



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="printsm()">Print</button>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('') ?>jq.js"></script>
<script>
    $(document).ready(function() {
        $(document).on('touchstart click', '.strukku', function() {
            var id_jual = $(this).data('idj');
            $('#idj').text('( ' + id_jual + ' )');

            var wkt = $(this).data('ca');
            $('#ca').text('( ' + wkt + ' )');


            // Data penjualan dari PHP
            var dataPenjualan = <?php echo json_encode($penjualan); ?>;
            var filteredData = dataPenjualan.filter(function(item) {
                return item.id_penjualan === id_jual;
            });

            // Container untuk menampilkan data penjualan
            var container = document.getElementById("penjualanContainer");
            container.innerHTML = "";
            var total = 0;

            filteredData.forEach(function(item) {
                var tableRow = document.createElement("tr");

                var productTypeCell = document.createElement("td");
                productTypeCell.style.paddingRight = "20px";

                if (item.keterangan == "Bukan Paket") {
                    productTypeCell.textContent = namprod(item.produk_id) + '.' + item.banyak + ' Ml';
                    productTypeCell.innerHTML = productTypeCell.textContent.replace(/\./g, "<br>");
                } else {
                    productTypeCell.textContent = namprod(item.produk_id) + '.' + item.keterangan;
                    productTypeCell.innerHTML = productTypeCell.textContent.replace(/\./g, "<br>");

                }

                var productPriceCell = document.createElement("td");
                productPriceCell.textContent = "Rp. " + item.harga_jadi;

                tableRow.appendChild(productTypeCell);
                // tableRow.appendChild(productTypeCell);
                tableRow.appendChild(productPriceCell);

                var penjualanContainer = document.getElementById("penjualanContainer");
                penjualanContainer.appendChild(tableRow);

                if (!isNaN(parseFloat(item.harga_jadi))) {
                    total += parseFloat(item.harga_jadi);
                }


            });


            var container2 = document.getElementById("totalContainer");
            container2.innerHTML = total;






        });

    });
</script>



<script>
    function namprod(x) {
        var dataProd = <?php echo json_encode($produk); ?>;
        var dp = dataProd.find(function(item) {
            return item.id_produk === x;
        });

        if (dp) {
            return (dp.nama_produk);
        } else {
            return ("Produk dengan ID " + x + " tidak ditemukan.");
        }
    }
</script>




<!--print struk  -->
<script>
    function printsm() {
        var originalContents = document.body.innerHTML;
        var printContents = document.getElementById('ctksm').innerHTML;
        document.body.innerHTML = printContents;
        window.onafterprint = function() {
            window.location.reload();
        };
        window.print();
    }
</script>

<?= $this->endSection(); ?>