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
function mbr($usr, $mbr)
{
    foreach ($usr as $u) {
        if ($mbr == $u['id_member']) {
            return $u['nama_member'];
        }
    }
};
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-store"></i>
            Data Penjualan Eceran
        </h3>

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
                                    <th>ID Penjualan</th>
                                    <th>Produk</th>
                                    <th>Banyak</th>
                                    <th>Diskon</th>
                                    <th>Harga Jual</th>
                                    <th>Keterangan</th>
                                    <th>Waktu</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($penjualan as $t) : ?>
                                    <tr>
                                        <td><?= $t['id_penjualan']; ?></td>
                                        <td><?= produk($produk, $t['produk_id']); ?></td>
                                        <td><?= $t['banyak']; ?></td>
                                        <td><?= $t['diskon']; ?></td>
                                        <td><?= $t['harga_jadi']; ?></td>
                                        <td><?= $t['keterangan']; ?></td>
                                        <td><?= $t['created_at']; ?></td>
                                        <td>
                                            <div class="d-flex">
                                                <button type="button" title="Detail Penjualan" class="btn btn-warning mx-2 detail-btn" data-toggle="modal" data-target="#detail" data-id_penjualan="<?= $t['id_penjualan']; ?>" data-Produk="<?= produk($produk, $t['produk_id']); ?>" data-id_penjualan="<?= $t['id_penjualan']; ?>" data-paket_id="<?= $t['paket_id']; ?>" data-banyak="<?= $t['banyak']; ?>" data-harga_produk="<?= $t['harga_produk']; ?>" data-harga_awal="<?= $t['harga_awal']; ?>" data-diskon="<?= $t['diskon']; ?>" data-harga_jadi="<?= $t['harga_jadi']; ?>" data-kasir_id="<?= kasir($userku, $t['kasir_id']); ?>" data-toko_id="<?= toko($tokoku, $t['toko_id']); ?>" data-pembeli_id="<?= mbr($member, $t['pembeli_id']); ?>" data-keterangan="<?= $t['keterangan']; ?>" data-waktu="<?= $t['created_at']; ?>">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button style="margin: 2px;" class="btn btn-primary ubah-btn" data-toggle="modal" data-target="#ubah_penjualan" data-jual="<?= $t['id_jual']; ?>" data-produk_id="<?= $t['produk_id'] ?>" data-id_penjualan="<?= $t['id_penjualan']; ?>" data-paket_id="<?= $t['paket_id']; ?>" data-banyak="<?= $t['banyak']; ?>" data-harga_produk="<?= $t['harga_produk']; ?>" data-harga_awal="<?= $t['harga_awal']; ?>" data-diskon="<?= $t['diskon']; ?>" data-harga_jadi="<?= $t['harga_jadi']; ?>" data-kasir_id="<?= kasir($userku, $t['kasir_id']); ?>" data-toko_id="<?= $t['toko_id']; ?>" data-keterangan="<?= $t['keterangan']; ?>" data-waktu="<?= $t['created_at']; ?>"><i class="	fas fa-pencil-alt"></i></button>

                                                <form action="<?= base_url('batalkan_penjualan/' . $t['id_jual'] . '/' . $t['produk_id'] . '/' . $t['banyak'] . '/' . $t['toko_id']); ?>" method="post"><?= csrf_field() ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button title="Batalkan Penjualan" class="btn btn-danger ml-2" type="submit" onclick="return confirm('Yakin ingin membatalkan Penjualan ini? , produk akan dikembalikan') "><i class="fas fa-undo-alt"></i></button>
                                                </form>
                                                <form action="<?= base_url('hapus_penjualan/' . $t['id_jual']); ?>" method="post"><?= csrf_field() ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button title="Hapus Data" class="btn btn-danger ml-2" type="submit" onclick="return confirm('Yakin ingin menghapus data ini? , produk tidak dikembalikan lagi')"><i class="fas fa-trash"></i></button>
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
        </div>
    </div>

    <div class="card mx-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-2 form-group">
                    <label for="minDate">Minimum Date:</label>
                    <input type="date" class="form-control" id="minDate">
                </div>
                <div class="col-md-2 form-group">
                    <label for="maxDate">Maximum Date:</label>
                    <input type="date" class="form-control" id="maxDate">
                </div>
                <div class="col-md-2 form-group">
                    <hr>
                    <button type="button" onclick="datecek()" class="btn btn-secondary ml-2" data-toggle="modal" data-target="#stokmin">
                        Laporan / Waktu
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
                <h6 class="modal-title" id="vvv">Detail Penjualan Eceran</h6><br>

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
                            'Produk ID' => 'produk',
                            'Paket ID' => 'paket_id',
                            'Banyak' => 'banyak',
                            'Harga Produk' => 'harga_produk',
                            'Harga Awal' => 'harga_awal',
                            'Diskon' => 'diskon',
                            'Harga Jadi' => 'harga_jadi',
                            'Kasir ID' => 'kasir_id',
                            'Toko ID' => 'toko_id',
                            'Pembeli ID' => 'pembeli_id',
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
                <form action="<?= base_url('/ubah_penjualan'); ?>" method="post"><?= csrf_field() ?>
                    <div class="row">
                        <div class="col-md-6">
                            <!-- <div class="mb-3"> -->
                            <!-- <label for="id_penjualan2" class="form-label">ID Penjualan</label> -->
                            <input type="text" class="form-control" id="id_penjualan2" name="id_penjualan" hidden>
                            <input type="text" class="form-control" id="toko_id2" name="toko_id" hidden>
                            <input type="text" class="form-control" id="produk_awal2" name="produk_id_awal" hidden>
                            <input type="text" class="form-control" id="banyak_awal2" name="banyak_produk_awal" hidden>
                            <input type="text" class="form-control" id="jual2" name="jual" hidden>
                            <!-- </div> -->
                            <div class="mb-3">
                                <label for="produk2" class="form-label">Produk ID</label>
                                <select class="form-select" id="produk2" name="produk" required>
                                    <?php foreach ($produk as $p) : ?>
                                        <option value="<?= $p->produk_id ?>"><?= $p->nama_produk ?></option>
                                    <?php endforeach; ?>
                                </select>

                            </div>
                            <div class="mb-3">
                                <label for="paket_id2" class="form-label">Paket ID</label>
                                <select required class="form-select" id="paket_id2" name="paket">
                                    <option value="0">bukan paket</option>
                                    <?php foreach ($paket as $pkt) : ?>
                                        <option value="<?= $pkt['id_paket'] ?>"><?= $pkt['nama_paket'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="banyak2" class="form-label">Banyak</label>
                                <input type="text" class="form-control" id="banyak2" name="banyak" required>
                            </div>
                            <div class="mb-3">
                                <label for="diskon2" class="form-label">Diskon</label>
                                <input type="text" class="form-control" id="diskon2" name="diskon" required>
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
                            </div>
                            <div class="mb-3">
                                <label for="harga_jadi2" class="form-label">Harga Jadi</label>
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


<div class="modal fade" id="stokmin" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div id="ctksm">
                <div class="modal-header">
                    <br><br>
                    <h6 class="modal-title" id="editModalLabel">Detail Penjualan Eceran ( <b id="namtok"></b> )</h6>
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
                                    <th>Paket ID</th>
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
                        <p> Point Kasir :<br> <b id='point'></b>
                    </div>
                    <p> Point Pembeli :<br> <b id='point2'></b>
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


        });

    });
</script>

<script>
    $(document).ready(function() {
        $(document).on('touchstart click', '.ubah-btn', function() {
            var Jual = $(this).data('jual');
            var idPenjualan = $(this).data('id_penjualan');
            var produkID = $(this).data('produk_id');
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

            $('#jual2').val(Jual);
            $('#id_penjualan2').val(idPenjualan);
            $('#produk_awal2').val(produkID);
            $('#produk2').val(produkID);
            $('#paket_id2').val(paketId);
            $('#banyak2').val(banyak);
            $('#banyak_awal2').val(banyak);
            $('#harga_produk2').val(hargaProduk);
            $('#harga_awal2').val(hargaAwal);
            $('#diskon2').val(diskon);
            $('#harga_jadi2').val(hargaJadi);
            $('#kasir_id2').val(kasirId);
            $('#toko_id2').val(tokoId);
            $('#keterangan2').val(keterangan);
            $('#waktu2').val(waktu);



        });
    });

    $("#produk2").change(function() {
        $('#banyak2').val('');
        $('#diskon2').val('');
        $('#paket_id2').val('');

    });

    $("#paket_id2").change(function() {
        var selectedValue = $(this).val();
        // console.log(selectedValue);

        var dataPkt = <?php echo json_encode($paket); ?>;

        pkt = dataPkt.find(function(item) {
            if (item.id_paket == selectedValue) {
                $('#keterangan2').val(item.tipe_paket + ' ( ' + item.jenis_paket + ' )');
                $('#banyak2').val(item.banyak_ml);
                $('#harga_awal2').val(item.harga_paket);
                $('#harga_produk2').val(item.harga_paket);
                $('#diskon2').val('');


            } else if (selectedValue == 0) {
                $('#banyak2').val('');
                $('#diskon2').val('');
            }
        });
    });

    $("#banyak2").keyup(function() {
        var dataPrd = <?php echo json_encode($produk); ?>;
        pkt = dataPrd.find(function(item) {
            if (item.id_produk == $('#produk2').val()) {
                // console.log(item.harga_jual_produk);
                $('#harga_produk2').val(item.harga_jual_produk);
                var hrg = parseFloat($('#harga_produk2').val()) * parseFloat($('#banyak2').val());
                // console.log(hrg);
                $('#harga_awal2').val(hrg);
                $('#keterangan2').val('Bukan Paket');
                $('#diskon2').val('');
            }
        });
    });

    $("#diskon2").keyup(function() {
        // Diskon = Total Harga * (Persentase Diskon / 100)
        var hrgj = parseFloat($('#harga_awal2').val()) / 100 * parseFloat($('#diskon2').val());
        var hrgd = parseFloat($('#harga_awal2').val()) - hrgj;
        // console.log(hrgd);
        $('#harga_jadi2').val(hrgd);

    });
</script>



<script>
    var penjualan = <?php echo json_encode($penjualan); ?>;
    var paket = <?php echo json_encode($paket); ?>;
    var produkData = <?php echo json_encode($produk); ?>;
    var userData = <?php echo json_encode($userku); ?>;
    var tokoData = <?php echo json_encode($tokoku); ?>;
    var memberData = <?php echo json_encode($member); ?>;

    function getKasirName(id) {
        for (var i = 0; i < userData.length; i++) {
            if (id == userData[i]['id']) {
                return userData[i]['username'];
            }
        }
        return '';
    }

    function getProdukName(id) {
        for (var i = 0; i < produkData.length; i++) {
            if (id == produkData[i]['id_produk']) {
                return produkData[i]['nama_produk'];
            }
        }
        return '';
    }

    function getTokoName(id) {
        for (var i = 0; i < tokoData.length; i++) {
            if (id == tokoData[i]['id_toko']) {
                return tokoData[i]['nama_toko'];
            }
        }
        return '';
    }

    function getMemberName(id) {
        for (var i = 0; i < memberData.length; i++) {
            if (id == memberData[i]['id_member']) {
                return memberData[i]['nama_member'];
            }
        }
        return '';
    }

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

        // cek pkt
        pkthrg = paket.filter(function(item) {
            return item.tipe_paket == "Premium";
        });

        // cek pkt
        pkthrg2 = paket.filter(function(item) {
            return item.tipe_paket == "Premium" || item.tipe_paket == "Deluxe";
        });

        var tabel = document.getElementById("ctksm").getElementsByTagName('tbody')[0];
        tabel.innerHTML = '';


        var totalBanyak = 0;
        var totalHarga = 0;
        var ksr_pkt = {};
        var mbr_pkt = {};


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
            cell3.innerHTML = '<td>' + item.paket_id + '</td>';
            cell4.innerHTML = '<td>' + item.banyak + '</td>';
            cell5.innerHTML = '<td>' + item.harga_jadi + '</td>';
            cell6.innerHTML = '<td>' + getKasirName(item.kasir_id) + '</td>';
            cell7.innerHTML = '<td>' + getMemberName(item.pembeli_id) + '</td>';
            cell8.innerHTML = '<td>' + item.keterangan + '</td>';
            cell9.innerHTML = '<td>' + item.created_at + '</td></tr>';


            var namaKasir = getKasirName(item.kasir_id);
            var namaPembeli = getMemberName(item.pembeli_id);


            pkthrg.forEach(function(x) {
                // console.log("item.paket_id);
                // console.log(" x.id_paket);
                if (item.paket_id == x.id_paket) {
                    // console.log( x.id_paket);
                    // ksr_pkt.push(x.jenis_paket);
                    var tampung = getKasirName(item.kasir_id);

                    if (ksr_pkt.hasOwnProperty(tampung)) {
                        ksr_pkt[tampung.toString()].push(x.jenis_paket);
                    } else {
                        ksr_pkt[tampung.toString()] = [x.jenis_paket];
                    }

                }
            });

            // pembeli
            pkthrg2.forEach(function(x2) {
                if (item.paket_id == x2.id_paket) {
                    var tampung2 = getMemberName(item.pembeli_id) + ' ' + x2.tipe_paket;

                    if (mbr_pkt.hasOwnProperty(tampung2)) {
                        mbr_pkt[tampung2.toString()].push(x2.jenis_paket);
                    } else {
                        mbr_pkt[tampung2.toString()] = [x2.jenis_paket];
                    }
                }
            });

            totalHarga += parseInt(item.harga_jadi);
            ntk = getTokoName(item.toko_id);

        });





        var jsonString = '';
        for (var key in mbr_pkt) {
            if ((key !== ' Premium') && (key !== ' Deluxe')) {
                jsonString += '"' + key + '":' + JSON.stringify(mbr_pkt[key]) + ',';
            }
        }

        jsonString = '{' + jsonString.slice(0, -1) + '}';

        // console.log("Total Banyak:", );
        document.getElementById('namtok').textContent = ntk;
        document.getElementById('dttl').textContent = 'Rp. ' + totalHarga;
        document.getElementById('point').innerHTML = JSON.stringify(ksr_pkt).replace(/["{}]/g, "").replace(/]/g, "]<br>");


        // console.log(jsonString);

        document.getElementById('point2').innerHTML = jsonString.replace(/["{}]/g, "").replace(/]/g, "]<br>");
        // document.getElementById('point').innerHTML = JSON.stringify(ksr_pkt).replace(/["{}]/g, "").replace(/]/g, "]<br>");

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