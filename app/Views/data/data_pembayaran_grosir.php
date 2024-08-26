<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<!-- Begin Page Content -->
<?php if (session()->has('success')) : ?>
    <div class="alert alert-success">
        <?= session('success') ?>
    </div>
<?php endif; ?>
<?php
date_default_timezone_set('Asia/Jakarta'); // Pastikan Anda menggunakan zona waktu yang benar

function tempo($givenDateStr)
{
    // Tanggal yang diberikan
    $givenDate = new DateTime($givenDateStr);

    // Tanggal saat ini
    $currentDate = new DateTime();

    // Hitung selisih waktu
    $interval = $currentDate->diff($givenDate);

    // Format hasil selisih waktu dalam hari
    $days = $interval->days;

    return $days . ' hari';
}

function htg($htg, $id_p)
{
    foreach ($htg as $ht) {
        if ($ht['id_penjualan'] == $id_p) {
            $h = $ht['hutang_sekarang'];
        }
    }
    return $h;
}

function status($stts)
{
    if ($stts > 0) {
        $sts = "Belum Lunas";
    } elseif ($stts == 0) {
        $sts = "Lunas";
    } elseif ($stts < 0) {
        $sts = "Belum Tuntas";
    }

    return $sts;
}
?>


<?= view('data/func') ?>



<div class="card">
    <div class="card-header bgdt">
        <h3 class="card-title">
            <i class="fas fa-store ct"> Data Pembayaran</i>

        </h3>

    </div><!-- /.card-header -->
    <div class="card-body ">
        <div class="tab-content p-0">
            <!-- Morris chart - Sales -->
            <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: auto;">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped " style="width: 100%; ">
                            <thead>
                                <tr>
                                    <th>no</th>
                                    <th>Penjualan ID</th>
                                    <th>Pembeli</th>
                                    <th>Kasir</th>
                                    <th>Toko</th>
                                    <th>Jenis</th>
                                    <th>Total</th>
                                    <th>Tempo</th>
                                    <th>Hutang/Kembalian</th>
                                    <th>status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                foreach ($pembayaran as $t) :
                                    $i++;
                                ?>
                                    <tr>
                                        <td><?= $i; ?></td>
                                        <td><?= $t['id_penjualan']; ?></td>
                                        <td><?= $t['nama_pembeli']; ?></td>
                                        <td><?= kasir($userku, $t['kasir_id']); ?></td>
                                        <td><?= toko($tokoku, $t['toko_id']); ?></td>
                                        <td><?= $t['jenis_pembayaran']; ?></td>
                                        <td><?= titik(total($penjualan, $t['id_penjualan'])); ?></td>

                                        <td><?= tempo($t['created_at']) ?></td>
                                        <td><?= htg($hutang, $t['id_penjualan']); ?></td>
                                        <td><?= status(htg($hutang, $t['id_penjualan'])); ?></td>
                                        <td>
                                            <div class="d-flex">
                                                <button type="button" id="button-<?= $t['id_penjualan'] ?>" class="btn btn-primary mx-1 strukku bt" data-toggle="modal" data-target="#stokmin" title="Struk Penjualan" data-idj="<?= $t['id_penjualan'] ?>" data-toko="<?= toko($tokoku, $t['toko_id']); ?>" data-kasir="<?= kasir($userku, $t['kasir_id']); ?>" data-pembeli="<?= $t['nama_pembeli']; ?>" data-pid="<?= $t['pembeli_id']; ?>" data-sp="<?= $t['status_pembayaran']; ?>" data-tp="<?= $t['tempo']; ?>">
                                                    <i class="fas fa-receipt ct"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                <?php
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
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Struk Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="ctksm">
                <div style="margin: 15px;">
                    <div style="width: 100%; overflow-x: auto;">
                        <table style="width: 100%; border: none;">
                            <tr>
                                <th>
                                    <strong>Faktur : </strong><span id="no_faktur"></span><br>
                                    <strong>Pelanggan : </strong><span id="pmbl"></span><br>
                                </th>
                                <th>
                                    <strong>Toko : </strong><span id="nama_toko1"></span><br>
                                    <strong>Telp : </strong><span id="hp_toko"></span><br>

                                </th>
                                <th style="text-align: right;">
                                    <strong>Faktur Penjualan</strong><br>
                                    <i id="wkt"></i><br>
                                    <strong>Kasir : </strong><span id="ksr"></span><br>

                                </th>

                            </tr>

                        </table>
                    </div><br>

                    <style>
                        table,
                        td {
                            border: 1px solid black;
                        }

                        span {
                            font-weight: normal;
                        }
                    </style>

                    <div style="width: 100%; overflow-x: auto;">
                        <table id="pjl_table" width="100%">
                            <thead>
                                <tr style="border: 1px solid black;">
                                    <th style="border: 1px solid black;">Nama Barang</th>
                                    <th style="border: 1px solid black;">Banyak</th>
                                    <th style="border: 1px solid black;">Harga</th>
                                    <th style="border: 1px solid black;">Jumlah</th>
                                    <th style="border: 1px solid black;">Diskon</th>
                                    <th style="border: 1px solid black;">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data akan dimasukkan di sini oleh JavaScript -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5">Total</th>
                                    <th id="grand-total">Rp.0</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <p id="total_terbilang" style="text-align: right; font-weight:bold;"></p>
                    <b><span id="shtg" style="font-weight: bold;"></span></b>



                    <p id="status_pembayaran" style="text-align: left; font-weight:bold;"></p>
                    <br>

                    <table style="width: 100%;border: none; ">
                        <tr>
                            <th><i><u>Diketahui oleh</u></i></th>

                            <th><i><u>Diterima oleh</u></i></th>

                            <th><i><u>Packing</u></i></th>

                            <th style="text-align: right;"><i><u>Dibuat oleh</u></i></th>

                        </tr>
                    </table><br><br><br><br>



                    <i style="margin:auto;"><span id="nama_toko2"></span>,
                        <span id="alamat"></span></i><br>


                </div>

            </div>
            <div class="modal-footer">
                <form id="deleteForm" action="#" method="post"><?= csrf_field() ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button title="Batalkan Penjualan" class="btn btn-danger ml-2 bt delete-btn" type="submit" data-id="your-id">
                        <i class="fas fa-undo-alt ct"> Batalkan Pembelian</i>
                    </button>
                </form>
                <a href="#" id="ubahLink" class="btn btn-primary" style="margin-right: 10%;" title="ubah data pembelian">
                    <i class="fas fa-pencil-alt">ubah</i>
                </a>
                <button class="btn btn-primary mx-1 hhtg-btn bt" data-toggle="modal" title="pembayaran" data-target="#hhtgModal" id="hhtg_id" data-id="0">
                    <i class="fa fa-history ct"> History Pembayaran
                    </i>
                </button>
                <button class="btn btn-primary mx-1 byr-btn bt" data-toggle="modal" title="pembayaran" data-target="#byrModal" id="btn_byr" data-id="0">
                    <i class="fas fa-money-bill-wave ct"> bayar</i>
                </button>
                <button type="button" class="btn btn-primary" onclick="printsm()" id="print_struk"><i class="fas fa-print"> Print</i></button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="byrModal" tabindex="-1" role="dialog" aria-labelledby="byrModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="byrModalLabel">pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('bayar_hutang_grosir'); ?>" method="post"><?= csrf_field() ?>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="penjualan-id" class="col-form-label">ID Penjualan : <i id="id21"></i></label>
                        <input type="text" name="id_jual" class="form-control" id="id2" hidden>
                        <input type="text" name="id_member" class="form-control" id="idm2" hidden>

                    </div>
                    <div class="form-group">
                        <label class="col-form-label">
                            <p id="hk1">Hutang :
                            <p> <i id="hsi21"></i>
                        </label>
                        <input type="text" name="hs" class="form-control" id="hsi2" hidden>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">membayar:</label>
                        <input type="text" name="membayar" pattern="[^.]*" placeholder="* sertakan - jika merupakan kembalian" class="form-control" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">membayar</button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="hhtgModal" tabindex="-1" role="dialog" aria-labelledby="hhtgModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hhtgModalLabel">Histori Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <table id="hhtg_table" width="100%">
                    <thead>
                        <tr style="border: 1px solid black;">
                            <th style="border: 1px solid black;">Tanggal</th>
                            <th style="border: 1px solid black;">Hutang</th>
                            <th style="border: 1px solid black;">Membayar</th>
                            <th style="border: 1px solid black;">Sisa Hutang</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data akan dimasukkan di sini oleh JavaScript -->
                    </tbody>

                </table>


            </div>
            <div class="modal-footer">
            </div>

        </div>
    </div>
</div>


<script src="<?= base_url('') ?>jq.js"></script>
<script src="<?= base_url('') ?>rp.js"></script><!-- terbilang dan titik   -->



<script>
    var produkData = <?php echo json_encode($produk); ?>;
</script>

<script>
    $(document).ready(function() {

        $(document).on('click', '.strukku', function() {
            var id_jual = $(this).data('idj');
            var toko = $(this).data('toko');
            var kasir = $(this).data('kasir');
            var pembeli = $(this).data('pembeli');
            var status = $(this).data('sp');
            var tempo = $(this).data('tp');
            var pid = $(this).data('pid');

            $('#idj').text(' ');
            $('#nama_toko').text(' ');
            $('#ksr').text(' ');
            $('#pmbl').text(' ');
            $('#no_faktur').text(' ');
            $('#hp_toko').text(' ');
            $('#alamat').text(' ');
            $('#wkt').text(' ');
            $('#grand-total').text(' ');
            $('#total_terbilang').text(' ');
            document.getElementById('status_pembayaran').textContent = "Tempo : ( " + tempo + " ) " + status;

            var baseUrl = '<?= base_url('/data_penjualan_grosir?id_penjualan=') ?>';
            var newHref = baseUrl + id_jual;
            $('#ubahLink').attr('href', newHref);

            var newIdPenjualan = id_jual; // Ganti dengan ID penjualan baru
            // console.log(newIdPenjualan);

            // mengubah tombol
            $('#btn_byr').attr('data-id', newIdPenjualan);
            $('#btn_byr').attr('data-pid', pid);
            $('#print_struk').attr('onclick', `printsm('${pembeli}', '${id_jual}')`);


            var pjl = <?php echo json_encode($penjualan); ?>;
            pjln = pjl.filter(function(item) {
                return item.id_penjualan === id_jual;
            });
            // console.log(pjln);


            var tbody = document.querySelector('#pjl_table tbody');
            tbody.innerHTML = '';

            if (pjln.length != 0) {


                var d_toko = <?php echo json_encode($tokoku); ?>;
                toks = d_toko.find(function(item) {
                    return item.id_toko === pjln[0].toko_id;
                });
                // console.log(pjln[0].created_at);


                $('#idj').text('( ' + id_jual + ' )');
                $('#nama_toko1').text(toko);
                $('#nama_toko2').text(toko);
                $('#ksr').text(kasir);
                $('#pmbl').text(pembeli);
                $('#no_faktur').text(id_jual);
                $('#hp_toko').text(toks.hp_toko);
                $('#alamat').text(toks.alamat_toko);
                $('#wkt').text(pjln[0].created_at);


                var grandTotal = 0;
                pjln.forEach(function(item) {
                    var row = document.createElement('tr');

                    // Menambahkan sel untuk setiap kolom
                    var namaBarangCell = document.createElement('td');
                    namaBarangCell.textContent = getProdukName(item.produk_id);
                    row.appendChild(namaBarangCell);

                    var banyakCell = document.createElement('td');
                    banyakCell.textContent = item.banyak;
                    row.appendChild(banyakCell);

                    var hargaCell = document.createElement('td');
                    hargaCell.textContent = titik(item.harga_awal);
                    row.appendChild(hargaCell);

                    var jumlahCell = document.createElement('td');
                    jumlahCell.textContent = titik(item.h_cek);
                    row.appendChild(jumlahCell);

                    var diskonCell = document.createElement('td');
                    diskonCell.textContent = item.diskon;
                    row.appendChild(diskonCell);

                    var totalCell = document.createElement('td');
                    totalCell.textContent = item.harga_jadi;
                    row.appendChild(totalCell);

                    // Menghitung total keseluruhan
                    grandTotal += parseInt(item.harga_jadi.replace(/[^0-9]/g, ''));

                    // Menambahkan baris ke tbody
                    tbody.appendChild(row);
                });

                // Memperbarui total keseluruhan di footer
                document.getElementById('grand-total').textContent = 'Rp.' + titik(grandTotal);
                document.getElementById('total_terbilang').textContent = terbilang(grandTotal);

                // console.log(data_pjln);



            }


            var htg = <?php echo json_encode($hutang); ?>;
            htgn = htg.filter(function(item) {
                return item.id_penjualan === id_jual;
            });
            var htgl = 0;


            htgn.forEach(function(item) {
                htgl = titik(item.hutang_sekarang)

                if (parseFloat(htgl) < 0) {
                    htglm = titik(item.hutang_sekarang * -1)
                } else {
                    htglp = titik(item.hutang_sekarang)
                }

            });

            // tbody.innerHTML = htgl;
            document.getElementById('shtg').textContent = '';

            if (parseFloat(htgl) < 0) {
                document.getElementById('shtg').textContent = 'Kembalian : Rp.' + htglm;
            } else {
                document.getElementById('shtg').textContent = 'Hutang : Rp.' + htglp;

            }

            // hhtg
            $(document).on('click', '.hhtg-btn', function(event) {
                // console.log(htg);

                var tbody = document.querySelector('#hhtg_table tbody');
                tbody.innerHTML = '';
                htgn.forEach(function(item) {
                    var row = document.createElement('tr');

                    // Menambahkan sel untuk setiap kolom

                    var waktuCell = document.createElement('td');
                    waktuCell.textContent = item.created_at;
                    row.appendChild(waktuCell);


                    var htg_sebelumnyaCell = document.createElement('td');
                    htg_sebelumnyaCell.textContent = titik(item.hutang_sebelumnya);
                    row.appendChild(htg_sebelumnyaCell);

                    var membayarCell = document.createElement('td');
                    membayarCell.textContent = titik(item.membayar);
                    row.appendChild(membayarCell);

                    var htg_sekarangCell = document.createElement('td');
                    htg_sekarangCell.textContent = titik(item.hutang_sekarang);
                    row.appendChild(htg_sekarangCell);


                    // Menambahkan baris ke tbody
                    tbody.appendChild(row);
                });

            });


            // deleteForm
            $(document).on('click', '.delete-btn', function(event) {
                event.preventDefault(); // Mencegah form dari submit default

                // Menampilkan alert konfirmasi sebelum mengirimkan form
                var confirmation = confirm('Yakin ingin membatalkan Penjualan ini? Produk akan dikembalikan.*Data Akan di hapus!!!');

                if (confirmation) {
                    // Ubah action form di sini
                    $('#deleteForm').attr('action', '<?= base_url('batalkan_penjualan_grosir'); ?>/' + id_jual);

                    // Kirimkan form
                    $('#deleteForm').submit();
                }
            });

        });

        $(document).on('click', '.byr-btn', function() {

            var id_jual = $(this).attr('data-id');
            var p_id = $(this).attr('data-pid');
            // console.log('ID dari byr-btn:',id_jual);

            $('#idm2').val(p_id);
            $('#id2').val(id_jual);
            document.getElementById('id21').textContent = id_jual;


            var htg = <?php echo json_encode($hutang); ?>;

            htgn = htg.filter(function(item) {
                return item.id_penjualan === id_jual;
            });

            htgn.forEach(function(item) {
                $('#hsi2').val(item.hutang_sekarang);
                document.getElementById('hsi21').textContent = titik(item.hutang_sekarang);

                if (parseFloat(item.hutang_sekarang) < 0) {
                    document.getElementById('hk1').innerHTML = " Kembalian : ";
                    document.getElementById('hsi21').textContent = titik(item.hutang_sekarang * -1);

                }

            });



        });


        <?php if (true) : ?>
            var savedId = '<?= $idpp['id_penjualan'] ?>';
            $('#button-' + savedId).click();
            // console.log('<?= $idpp['id_penjualan'] ?>');
        <?php endif; ?>


    });
</script>

<!-- <script>
    $(document).ready(function() {
        $(document).on('click', '.byr-btn', function() {

            console.log($(this).data('id'));
            var id_jual = $(this).data('id');

            $('#id2').val(id_jual);
            document.getElementById('id21').textContent = id_jual;


            var htg = <?php echo json_encode($hutang); ?>;

            htgn = htg.filter(function(item) {
                return item.id_penjualan === id_jual;
            });

            htgn.forEach(function(item) {
                $('#hsi2').val(item.hutang_sekarang);
                document.getElementById('hsi21').textContent = titik(item.hutang_sekarang);

            });

        });
    });
</script> -->



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




<script>
    function printsm(pembeli, id_jual) {
        var originalContents = document.body.innerHTML;
        var printContents = document.getElementById('ctksm').innerHTML;
        document.body.innerHTML = printContents;
        var dt = document.title;
        document.title = "Struk_" + pembeli + "_" + id_jual;
        window.onafterprint = function() {
            // document.title = dt;
            window.location.reload();
        };
        window.print();
    }
</script>

<?= $this->endSection(); ?>