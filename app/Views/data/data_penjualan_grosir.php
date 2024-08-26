<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<!-- Begin Page Content -->
<?php if (session()->has('success')) : ?>
    <div class="alert alert-success">
        <?= session('success') ?>
    </div>
<?php endif; ?>

<?php
function kasir($usr, $ksr)
{
    foreach ($usr as $u) {
        if ($ksr == $u['id']) {
            return $u['username'];
        }
    }
};
function produk($usr, $pdk)
{
    // dd($usr);
    foreach ($usr as $u) {
        if ($pdk == $u->id_produk) {
            return $u->nama_produk;
        }
    }
};
function toko($usr, $tk)
{
    foreach ($usr as $u) {
        if ($tk == $u['id_toko']) {
            return $u['nama_toko'];
        }
    }
};


?>



<div class="card">
    <div class="card-header bgdt">
        <h3 class="card-title">
            <i class="fas fa-store ct"> Data Penjualan Grosir</i>

        </h3>

    </div><!-- /.card-header -->
    <div class="card-body ">
        <div class="tab-content p-0">
            <!-- Morris chart - Sales -->
            <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: auto;">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">

                        <table id="example1" class="table table-bordered table-striped" style="width: 100%; ">
                            <thead>
                                <tr>
                                    <th>no</th>
                                    <th>Waktu</th>
                                    <th>ID Penjualan</th>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Banyak</th>
                                    <th>Paket</th>
                                    <th>Diskon</th>
                                    <th>Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0;
                                foreach ($penjualan as $t) : $i++; ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><?= $t['created_at']; ?></td>
                                        <td><?= $t['id_penjualan']; ?></td>
                                        <td><?= produk($produk, $t['produk_id']); ?></td>
                                        <td><?= $t['harga_awal']; ?></td>
                                        <td><?= $t['banyak']; ?></td>
                                        <td><?= $t['keterangan']; ?></td>
                                        <td><?= $t['diskon']; ?></td>
                                        <td><?= $t['harga_jadi']; ?></td>
                                        <td>
                                            <div class="d-flex">
                                                <button type="button" title="Detail Penjualan" class="btn btn-warning mx-2 detail-btn bt" data-toggle="modal" data-target="#detail" data-id_penjualan="<?= $t['id_penjualan']; ?>" data-dlr="<?= $t['harga_dlr'] ?>" data-Produk="<?= produk($produk, $t['produk_id']); ?>" data-id_penjualan="<?= $t['id_penjualan']; ?>" data-banyak="<?= $t['banyak']; ?>" data-harga_produk="<?= $t['harga_produk']; ?>" data-harga_awal="<?= $t['harga_awal']; ?>" data-diskon="<?= $t['diskon']; ?>" data-harga_jadi="<?= $t['harga_jadi']; ?>" data-kasir_id="<?= kasir($userku, $t['kasir_id']); ?>" data-toko_id="<?= toko($tokoku, $t['toko_id']); ?>" data-pembeli_id="<?= $t['nama_pembeli']; ?>" data-keterangan="<?= $t['keterangan']; ?>" data-waktu="<?= $t['created_at']; ?>">
                                                    <i class="fas fa-eye ct"></i>
                                                </button>
                                                <button style="margin: 2px;" class="btn btn-primary ubah-btn bt" data-toggle="modal" data-target="#ubah_penjualan" data-jual="<?= $t['id_jual']; ?>" data-produk_id="<?= $t['produk_id'] ?>" data-banyak="<?= $t['banyak']; ?>" data-harga_produk="<?= $t['harga_produk']; ?>" data-harga_awal="<?= $t['harga_awal']; ?>" data-diskon="<?= $t['diskon']; ?>" data-harga_jadi="<?= $t['harga_jadi']; ?>" data-keterangan="<?= $t['keterangan']; ?>" data-dlr="<?= $t['harga_dlr'] ?>" data-toko="<?= $t['toko_id'] ?>" data-id_penjualan="<?= $t['id_penjualan'] ?>">
                                                    <i class="	fas fa-pencil-alt ct"></i></button>
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
        </div>
    </div>

    <div class="card mx-4 bgdt">
        <div class="card-body">
            <div class="row">
                <div class="col-md-2 form-group">
                    <label for="minDate" class="ct">Minimum Date:</label>
                    <input type="date" class="form-control" id="minDate">
                </div>
                <div class="col-md-2 form-group">
                    <label for="maxDate" class="ct">Maximum Date:</label>
                    <input type="date" class="form-control" id="maxDate">
                </div>
                <div class="col-md-2 ">
                    <label class="ct">Laporan / Waktu:</label>

                    <button type="button" onclick="datecek()" class="btn btn-secondary bt" data-toggle="modal" data-target="#s_data" title="Laporan / Waktu">
                        <i class="fas fa-search ct"> </i>
                    </button>
                </div>
            </div>
        </div>
    </div>


</div>


<!-- Modal untuk Detail Penjualan -->
<div class="modal fade" id="detail" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="vvv">Detail Penjualan Grosir</h6><br>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="container">
                    <table>
                        <?php
                        $columns = [
                            'ID Penjualan' => 'id_penjualan',
                            'dollar saat pembelian' => 'dlr',

                            'Produk ' => 'produk',
                            'Harga Awal' => 'harga_awal',
                            'Harga Produk' => 'harga_produk',
                            'Banyak' => 'banyak',
                            'Diskon' => 'diskon',
                            'Harga Jadi' => 'harga_jadi',


                            'Kasir ' => 'kasir_id',
                            'Toko' => 'toko_id',
                            'Pembeli' => 'pembeli_id',
                            'Keterangan' => 'keterangan',
                            'Waktu' => 'waktu'
                        ];
                        foreach ($columns as $label => $id) {
                            echo '<tr>';
                            echo '<td><b>' . $label . '</b></td>';
                            echo '<td>:  </td>';
                            echo '<td id="' . $id . '"></td>';
                            echo '</tr>';
                        }
                        ?>
                    </table>


                </div>


            </div>
        </div>
    </div>
</div>

<!-- Modal Ubah Data Penjualan-->
<div class="modal fade" id="ubah_penjualan" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="d">Ubah Data Penjualan </h6><br>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('/ubah_penjualan_grosir'); ?>" autocomplete="off" method="post"><?= csrf_field() ?>
                    <div class="row">
                        <div class="col-md-6">
                            <!-- <div class="mb-3"> -->

                            <!-- </div> -->
                            <div class="mb-3">
                                <label for="produk2" class="form-label">Produk ID</label>
                                <input list="produk2" class="form-control" name="id_produk" id="produkInput" oninput="pid_ubah()" required>
                                <datalist id="produk2">
                                    <?php foreach ($produk as $p) : ?>
                                        <option value="<?= $p->produk_id ?>" data-id="<?= $p->produk_id ?>"><?= $p->nama_produk ?> ( <?= $p->stok_toko ?> ) </option>
                                    <?php endforeach; ?>
                                </datalist>
                            </div>
                            <input type="text" class="form-control" id="jual2" name="jual" hidden required>
                            <input type="text" class="form-control" id="pid_awal2" name="produk_id_awal" hidden required>
                            <input type="text" class="form-control" id="byk_awal2" name="banyak_awal" hidden required>
                            <input type="text" class="form-control" id="toko_id2" name="toko_id" hidden required>
                            <input type="text" class="form-control" id="penjualan_id2" name="id_penjualan" hidden required>

                            <div class="mb-3">
                                <label for="dlr" class="form-label">dolar saat pembelian</label>
                                <input type="text" class="form-control" oninput="dolar_ubah()" id="dlr2" name="dlr" required>
                            </div>
                            <div class="mb-3">
                                <label for="banyak2" class="form-label">Banyak</label>
                                <input type="text" oninput="banyak_cek(this)" class="form-control" id="banyak2" name="banyak" required>
                            </div>
                            <div class="mb-3">
                                <label for="diskon2" class="form-label">Diskon</label>
                                <input type="text" class="form-control" oninput="diskon_produk(this)" id="diskon2" name="diskon" value="0" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="harga_awal2" class="form-label">Harga Awal</label>
                                <input type="text" class="form-control" id="harga_awal2" name="harga_awal" required>
                            </div>
                            <div class="mb-3">
                                <label for="harga_produk2" class="form-label">Harga Produk</label>
                                <input type="text" class="form-control" id="harga_produk2" name="harga_produk" required>
                                <input type="text" class="form-control" id="hcek" name="h_cek" hidden required>
                            </div>
                            <div class="mb-3">
                                <label for="harga_jadi2" class="form-label">Harga Total</label>
                                <input type="text" class="form-control" id="harga_jadi2" name="harga_jadi" required>
                            </div>

                            <div class="mb-3">
                                <label for="keterangan2" class="form-label">Keterangan</label>
                                <input type="text" class="form-control" id="keterangan2" name="keterangan" required>
                            </div>

                        </div>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>

            </div>
        </div>
    </div>


</div>


<div class="modal fade" id="s_data" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div id="ctksm">
                <div class="modal-header">
                    <br><br>
                    <h6 class="modal-title" id="editModalLabel">Detail Penjualan Grosir ( <b id="namtok"></b> )</h6>
                    <div class="d-flex mx-5">
                        <h6 class="modal-title" id="label_range1"></h6><br>
                        <h6 class="modal-title" id="label_range2"></h6>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>

                <div class="modal-body">

                    <div class="table-responsive-sm" style="font-size: small;">
                        <table class="table table-striped" style="max-height: 400px; overflow-y: auto;">
                            <thead>
                                <tr>
                                    <th>ID Penjualan</th>
                                    <th>Nama Produk</th>
                                    <th>Harga Produk</th>
                                    <th>Banyak</th>
                                    <th>Harga</th>
                                    <th>Kasir</th>
                                    <th>Pembeli</th>
                                    <th>Keterangan</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <div style="float: right;">
                        <p>total pendapatan : <b id="dttl"></b></p>
                    </div>
                    <p> Total Penjualan : <b id='totpen'></b>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="printsm()">Print</button>
            </div>
        </div>
    </div>
</div>



<script src="<?= base_url('') ?>rp.js"></script><!-- terbilang dan titik   -->

<script src="<?= base_url('') ?>jq.js"></script>
<script>
    $(document).ready(function() {
        $(document).on('touchstart click', '.ubah-btn', function() {
            var idJual = $(this).data('jual');
            var produk_id = $(this).data('produk_id');
            var banyak = $(this).data('banyak');
            var dollar = $(this).data('dlr');
            var diskon = $(this).data('diskon');
            var hargaAwal = $(this).data('harga_awal');
            var hargaProduk = $(this).data('harga_produk');
            var hargaJadi = $(this).data('harga_jadi');
            var keterangan = $(this).data('keterangan');
            var id_penjualan = $(this).data('id_penjualan');
            var toko_id = $(this).data('toko');
            // console.log(toko_id, id_penjualan);

            $('#jual2').val(idJual);
            $('#produkInput').attr('placeholder', produk_id);
            $('#pid_awal2').val(produk_id);
            $('#banyak2').attr('placeholder', banyak);
            $('#byk_awal2').val(banyak);
            $('#dlr2').val(dollar);
            $('#diskon2').attr('placeholder', diskon);
            $('#harga_awal2').attr('placeholder', hargaAwal);
            $('#harga_produk2').attr('placeholder', hargaProduk);
            $('#harga_jadi2').attr('placeholder', hargaJadi);
            $('#keterangan2').attr('placeholder', keterangan);
            $('#penjualan_id2').val(id_penjualan);
            $('#toko_id2').val(toko_id);


        });

    });

    function dolar_ubah() {
        var byk = document.getElementById('banyak2').value = '';
    }

    function pid_ubah() {
        var byk = document.getElementById('banyak2').value = '';
    }
</script>
<script>
    // console.log(dataPkt);

    function banyak_cek(input) {

        var dataPkt = <?php echo json_encode($paket); ?>;
        var dlr = document.getElementById('dlr2').value;


        banyak_produk = parseFloat(input.value);
        produkInput = document.getElementById('produkInput').value;
        harwal = document.getElementById('harga_awal2');
        harjad = document.getElementById('harga_jadi2');
        harprod = document.getElementById('harga_produk2');
        keterangan = document.getElementById('keterangan2');
        paket = document.getElementById('paket_id2');
        disc = document.getElementById('diskon2');
        hcek = document.getElementById('hcek');

        var pkt = dataPkt.find(function(item) {
            if (produkInput == item.produk_id) {
                if (banyak_produk < parseFloat(item.jenis_paket)) {
                    return true;
                }
            }
        });



        var lastItem = dataPkt.reverse().find(function(item) {
            if (produkInput == item.produk_id) {
                return true;
            };
        });


        if (pkt) {
            harwal.value = pkt.harga + ' ' + pkt.jenis_harga;
            keterangan.value = pkt.nama_paket;
            harprod.value = pkt.harga;
            // console.log(1);

            if (pkt.jenis_harga == "USD") {
                harwal.value = pkt.harga + ' ' + pkt.jenis_harga;
                keterangan.value = pkt.nama_paket;
                harprod.value = pkt.harga * dlr;
                // console.log(2);
            }

        } else {
            harwal.value = lastItem.harga + ' ' + lastItem.jenis_harga;
            keterangan.value = lastItem.nama_paket;
            harprod.value = lastItem.harga;
            // console.log(3);


            if (lastItem.jenis_harga == "USD") {
                harwal.value = lastItem.harga + ' ' + lastItem.jenis_harga;
                keterangan.value = lastItem.nama_paket;
                harprod.value = lastItem.harga * dlr;
                // console.log(4);

            }

        }
        harjad.value = banyak_produk * harprod.value;
        hcek.value = banyak_produk * harprod.value;

        diskon_produk(disc);



    }

    function diskon_produk(diskon_persen) {
        var d = parseFloat(diskon_persen.value);
        harprod = document.getElementById('harga_produk2').value;
        harjad = document.getElementById('harga_jadi2');
        hcek = document.getElementById('hcek').value;
        h = parseFloat(hcek);

        var diskon = h * (d / 100);

        // Hitung harga setelah diskon
        var hargaSetelahDiskon = h - diskon;
        // console.log(d, harprod, hcek);

        harjad.value = hargaSetelahDiskon;

    }
</script>

<script>
    $(document).ready(function() {
        $(document).on('touchstart click', '.detail-btn', function() {
            var idPenjualan = $(this).data('id_penjualan');
            var produk = $(this).data('produk');
            var paketId = $(this).data('paket_id');
            var banyak = $(this).data('banyak');
            var hargaProduk = $(this).data('harga_produk');
            var hargaAwal = $(this).data('harga_awal');
            var diskon = $(this).data('diskon');
            var hargaJadi = $(this).data('harga_jadi');
            var kasirId = $(this).data('kasir_id');
            var tokoId = $(this).data('toko_id');
            var keterangan = $(this).data('keterangan');
            var waktu = $(this).data('waktu');
            var pembeliId = $(this).data('pembeli_id');
            var dollar = $(this).data('dlr');

            $('#id_penjualan').text(idPenjualan);
            $('#produk').text(produk);
            $('#paket_id').text(paketId);
            $('#banyak').text(banyak);
            $('#harga_produk').text(hargaProduk);
            $('#harga_awal').text(hargaAwal);
            $('#diskon').text(diskon);
            $('#harga_jadi').text(hargaJadi);
            $('#kasir_id').text(kasirId);
            $('#toko_id').text(tokoId);
            $('#pembeli_id').text(pembeliId);
            $('#keterangan').text(keterangan);
            $('#waktu').text(waktu);
            $('#dlr').text(dollar);


        });

    });
</script>



<script>
    var penjualan = <?php echo json_encode($penjualan); ?>;
    var paket = <?php echo json_encode($paket); ?>;
    var produkData = <?php echo json_encode($produk); ?>;
    var userData = <?php echo json_encode($userku); ?>;
    var tokoData = <?php echo json_encode($tokoku); ?>;
    var memberData = <?php echo json_encode($member); ?>;




    function datecek() {
        var minDate = new Date(document.getElementById("minDate").value);
        var maxDate = new Date(document.getElementById("maxDate").value);


        var minDay = minDate.getDate();
        var minMonth = minDate.getMonth() + 1;
        var minYear = minDate.getFullYear();

        var maxDay = maxDate.getDate();
        var maxMonth = maxDate.getMonth() + 1;
        var maxYear = maxDate.getFullYear();

        // console.log();
        // console.log();

        document.getElementById("label_range1").textContent = '[ ' + minDay + ' - ' + minMonth + ' - ' + minYear + ' ].' + ' S/D ' + '.';
        document.getElementById("label_range2").textContent = '[ ' + maxDay + ' - ' + maxMonth + ' - ' + maxYear + ' ]';



        // Atur jam, menit, dan detik menjadi 0 untuk memastikan kita hanya membandingkan tanggal
        minDate.setHours(0, 0, 0, 0);
        maxDate.setHours(0, 0, 0, 0);


        byr = penjualan.filter(function(item) {
            var pembayaranDate = new Date(item.created_at);
            pembayaranDate.setHours(0, 0, 0, 0); // Atur jam, menit, dan detik menjadi 0
            return pembayaranDate >= minDate && pembayaranDate <= maxDate;
        });

        var tabel = document.getElementById("ctksm").getElementsByTagName('tbody')[0];
        tabel.innerHTML = '';


        var totalBanyak = 0;
        var totalHarga = 0;
        var ksr_pkt = {};
        var mbr_pkt = {};
        var tp = 0;


        byr.forEach(function(item) {
            var newRow = tabel.insertRow();
            var cell1 = newRow.insertCell(0);
            var cell2 = newRow.insertCell(1);
            var cell3 = newRow.insertCell(2);
            var cell4 = newRow.insertCell(3);
            var cell5 = newRow.insertCell(4);
            var cell6 = newRow.insertCell(5);
            var cell7 = newRow.insertCell(6);
            var cell8 = newRow.insertCell(7);
            var cell9 = newRow.insertCell(8);

            cell1.innerHTML = '<tr><td>' + item.id_penjualan + '</td>';
            cell2.innerHTML = '<td>' + getProdukName(item.produk_id) + '</td>';
            cell3.innerHTML = '<td>' + item.harga_awal + '</td>';
            cell4.innerHTML = '<td>' + item.banyak + '</td>';
            cell5.innerHTML = '<td>' + titik(item.harga_jadi) + '</td>';
            cell6.innerHTML = '<td>' + getKasirName(item.kasir_id) + '</td>';
            cell7.innerHTML = '<td>' + item.nama_pembeli + '</td>';
            cell8.innerHTML = '<td>' + item.keterangan + '</td>';
            cell9.innerHTML = '<td>' + item.created_at + '</td></tr>';


            var namaKasir = getKasirName(item.kasir_id);
            var namaPembeli = item.nama_pembeli;



            totalHarga += parseInt(item.harga_jadi);
            ntk = getTokoName(item.toko_id);
            tp++;
        });



        // console.log("Total Banyak:", );
        document.getElementById('namtok').textContent = ntk;
        document.getElementById('dttl').textContent = 'Rp. ' + titik(totalHarga);
        document.getElementById('totpen').textContent = tp;

    };
</script>



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