<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<?php if (session()->has('success')) : ?>
    <div class="alert alert-success">
        <?= session('success') ?>
    </div>
<?php endif ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-shopping-basket"></i>
            Penjualan Eceran
        </h3>
        <div class="card-tools">
            <ul class="nav nav-pills ml-auto">
                <li class="nav-item mx-2 mt-1">
                    <i>
                        <h6>Kasir : <?= user()->username ?></h6>
                    </i>


                </li>
                <li class="nav-item mx-2 mt-1">
                    <i>
                        <h6>Toko : <?= $toko['nama_toko'] ?></h6>
                    </i>

                </li>
            </ul>
        </div>
    </div>
</div>

<section class="content">

    <div class="card card-solid">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <form id="myForm">
                        <div class="form-group">
                            <label for="produk">Cari Produk (ID / Nama):</label>
                            <div class="input-group input-group-md">
                                <input type="text" list="namprod" class="form-control" id="cid_produk" placeholder="Masukkan ID atau Nama Produk" oninput="cekProduk(this)">
                                <datalist id="namprod">
                                    <?php foreach ($produk as $pr) :
                                        if ($pr->id_toko == user()->toko) { ?>
                                            <option value="<?= $pr->nama_produk ?>">
                                        <?php    };
                                    endforeach; ?>
                                </datalist>
                                <span class="input-group-append">
                                    <button type="reset" class="btn btn-primary" title="reset"><i class="fas fa-backspace"></i></button>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="nama">Nama Produk:</label>
                            <input type="text" class="form-control" id="nama" readonly>
                        </div>
                        <div class="form-group">
                            <label for="harga">Banyak Produk:</label>
                            <input type="text" class="form-control" id="banyak_stok" readonly>
                        </div>
                    </form>

                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-bordered table-sm text-center">
                                    <tr>
                                        <td class="small">Premium</td>
                                        <td class="small">Deluxe</td>
                                        <!-- <td class="small">Grosir</td> -->
                                        <td class="small">Bukan Paket</td>
                                    </tr>
                                    <tr>
                                        <td class="small">
                                            <?php foreach ($paket as $pkt) { ?>
                                                <?php if ($pkt['tipe_paket'] == 'Premium') { ?>
                                                    <button type="button" class="btn btn-success btn-sm m-1 p-0" onclick="paket('<?= $pkt['jenis_paket'] ?>','<?= $pkt['tipe_paket'] ?>')" style="width: 60px;">
                                                        <?= $pkt['jenis_paket'] ?>
                                                    </button>
                                                <?php } ?>
                                            <?php } ?>
                                        </td>
                                        <td class="small">
                                            <?php foreach ($paket as $pkt) { ?>
                                                <?php if ($pkt['tipe_paket'] == 'Deluxe') { ?>
                                                    <button type="button" class="btn btn-warning btn-sm m-1 p-0" onclick="paket('<?= $pkt['jenis_paket'] ?>','<?= $pkt['tipe_paket'] ?>')" style="width: 60px;">
                                                        <?= $pkt['jenis_paket'] ?>
                                                    </button>
                                                <?php } ?>
                                            <?php } ?>
                                        </td>
                                        <!-- <td class="small">
                                            <?php foreach ($paket as $pkt) { ?>
                                                <?php if ($pkt['tipe_paket'] == 'Grosir') { ?>
                                                    <button type="button" class="btn btn-info btn-sm m-1 p-0" onclick="paket('<?= $pkt['jenis_paket'] ?>')" style="width: 60px;">
                                                        <?= $pkt['jenis_paket'] ?>
                                                    </button>
                                                <?php } ?>
                                            <?php } ?>
                                        </td> -->
                                        <td class="small">
                                            <button type="button" class="btn btn-secondary btn-sm m-1 p-0" onclick="paket('Bukan Paket')" style="width: 60px;">Bukan Paket</button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <form action="<?= base_url('/tambah_penjualan'); ?>" method="post"><?= csrf_field() ?>
                        <div class="container mt-3" style="overflow-x: auto; white-space: nowrap;">
                            <table id="example1" class="table table-bordered table-striped" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-sm-center">ID Produk</th>
                                        <th scope="col" class="text-sm-center">Nama Produk</th>
                                        <th scope="col" class="text-sm-center">Jenis Paket</th>
                                        <th scope="col" class="text-sm-center">Harga</th>
                                        <th scope="col" class="text-sm-center">Banyak (Ml) </th>
                                        <th scope="col" class="text-sm-center">Diskon %</th>
                                        <th scope="col" class="text-sm-center">Harga Total</th>
                                        <th scope="col" class="text-sm-center">Aksi</th>


                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>


                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <td><input type="text" class="form-control" value="<?= user()->id . $toko['id_toko'] . '-' . mt_rand(1000000, 9999999) ?>" name="id_penjualan" hidden></td><br>
                        <td><input type="text" class="form-control" id="h_t" name="harga_total" hidden></td><br>
                        <td><input type="text" class="form-control" name="kasir_id" value="<?= user()->id ?>" hidden></td><br>
                        <td><input type="text" class="form-control" name="toko_id" value="<?= $toko['id_toko'] ?>" hidden></td><br>
                        <hr>
                        <div class="d-flex">

                            <div class="col-md-6">
                                <select name="jenis_pembayaran" class="form-control" required>
                                    <option value="" disabled selected>Pilih Jenis Pembayaran</option>
                                    <option value="nobu">Nobu</option>
                                    <option value="cash">Cash</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <select class="form-control" name="pembeli_id">
                                    <option value="0">Bukan Member</option>
                                    <?php foreach ($member as $mbr) {
                                        if ($mbr['toko_id'] == user()->toko) { ?>
                                            <option value="<?= $mbr['id_member'] ?>"><?= $mbr['nama_member'] ?></option>
                                    <?php };
                                    } ?>
                                </select>
                            </div>
                        </div>

                        <div class="card bg-primary mt-4 pr-3">
                            <button type="submit" class="btn btn-primary" id="submitButton" disabled>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="text-left mb-0">
                                        <i class="fas fa-shopping-basket"></i>
                                    </h4>
                                    <h4 class="text-right mb-0">
                                        Rp. <span id="totalHarga">0</span>
                                    </h4>
                                </div>
                            </button>
                        </div>

                    </form>


                </div>
            </div>
        </div>


    </div>

    <!-- member -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-start"> <!-- Menggunakan flexbox untuk menempatkan tombol ke kanan -->
                <button type="button" class="btn btn-primary mx-1" data-toggle="modal" data-target="#member" title="Tambah Member">
                    <i class="fas fa-id-card mx-2"></i><i class="fa fa-plus-circle"></i>
                </button>
            </div>
        </div>
    </div>


    <div class="modal fade" id="member" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <form action="<?= base_url('/tambah_member'); ?>" method="post"><?= csrf_field() ?>
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Tambah Member</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="form-group">
                                    <label for="id_member" class="form-label">ID Member</label>
                                    <a href="#" style='font-size:20px' class='far' onclick="ubahNilai(); return false;" title="Generate ID">&#xf359;</a>
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
                                    <label>Hp Toko</label>
                                    <input class="form-control" name="no_hp" value="+62">
                                </div>
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

</section>





<script>
    var dataProduk = <?php echo json_encode($produk); ?>;
    var dataPkt = <?php echo json_encode($paket); ?>;
    var produk;

    function cekProduk(input) {
        // Ambil nilai ID atau nama produk dari input
        var id_or_nama_produk = input.value;

        // Mencari produk berdasarkan ID atau nama yang dimasukkan
        produk = dataProduk.find(function(item) {
            return item.id_produk === id_or_nama_produk || item.nama_produk === id_or_nama_produk;
        });

        // Jika produk ditemukan, set nilai nama dan harga produk
        if (produk) {
            document.getElementById("nama").value = produk.nama_produk;
            document.getElementById("banyak_stok").value = produk.stok_toko + ' ' + produk.satuan_produk;
        } else { // Jika produk tidak ditemukan, kosongkan nilai nama dan banyak_stok produk
            document.getElementById("nama").value = "";
            document.getElementById("banyak_stok").value = "";
        }
    }

    function paket(p, q) {
        var dataPkt = <?php echo json_encode($paket); ?>;
        var strp = p.toString();
        // console.log(strp, s);

        pkt = dataPkt.find(function(item) {
            return item.jenis_paket === strp && item.tipe_paket === q;
        });


        if (produk) {

            // input data
            var tabel = document.getElementById("example1").getElementsByTagName('tbody')[0];
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
            var cell10 = newRow.insertCell(9);
            var cell11 = newRow.insertCell(10);

            cell1.innerHTML = '<input type="text" class="form-control" name="id_produk[]" value="' + produk.id_produk + '" placeholder="Masukkan ID Produk" required>';
            cell2.innerHTML = '<input type="text" class="form-control" name="nama_produk[]" value="' + produk.nama_produk + '" placeholder="Masukkan Nama Produk" required>';
            if (pkt) {
                cell3.innerHTML = '<input type="text" class="form-control" name="nama_paket[]" value="' + pkt.tipe_paket + ' ( ' + pkt.jenis_paket + ' )' + '" required>';
                cell4.innerHTML = '<input type="text" class="form-control" name="harga_produk[]" value="' + pkt.harga_paket + '" placeholder="Masukkan Harga Produk" required>';
                cell5.innerHTML = '<input type="text"  class="form-control" value="-" oninput="hitungHargaTotal(this)" required>';
                cell6.innerHTML = '<input type="number" class="form-control" value="0" oninput="hitungDiskon(this)" name="diskon[]" required>';
                cell7.innerHTML = '<input type="text" class="form-control" value="' + pkt.harga_paket + '" name="hartot[]" required>';

                cell9.innerHTML = '<input type="text" class="form-control" name="id_paket[]" value="' + pkt.id_paket + '" hidden required>';
                cell10.innerHTML = '<input type="text" class="form-control" name="banyak[]" value="' + pkt.banyak_ml + '" hidden required>';
                cell11.innerHTML = '<input type="text" class="form-control" value="' + pkt.harga_paket + '" name="hcek[]" required hidden> ';


                hitungTotalHarga();

            } else {
                cell3.innerHTML = '<input type="text" class="form-control" name="nama_paket[]" value="' + strp + '" required>';
                cell4.innerHTML = '<input type="text" class="form-control" name="harga_produk[]" value="' + produk.harga_jual_produk + '" required>';
                cell5.innerHTML = '<input type="text"  class="form-control" name="banyak[]" oninput="hitungHargaTotal(this)" required>';
                cell6.innerHTML = '<input type="number" class="form-control" oninput="hitungDiskon(this)" value="0" name="diskon[]" required>';
                cell7.innerHTML = '<input type="text" class="form-control" value="0" name="hartot[]" required>';

                cell9.innerHTML = '<input type="number" class="form-control" name="id_paket[]" value="0" hidden required>';
                cell10.innerHTML = '<input type="text"  hidden >';
                cell11.innerHTML = '<input type="text" class="form-control" name="hcek[]" required hidden>';


            }

            cell8.innerHTML = '<button type="button" class="btn btn-danger" onclick="hapusBaris(this)"><i class="fas fa-times-circle"></i></button>';




        } else {
            alert("Data Produk tidak ditemukan, atau belum input id atau nama produk");
        }


    }

    // Fungsi untuk menghitung harga total
    function hitungHargaTotal(input) {
        var nilaiInput = input.value;

        // console.log("Nilai input:", nilaiInput);


        var hargaTotal = input.value;
        if (hargaTotal === "-") {

            var nextRow = input.closest('td').nextElementSibling.nextElementSibling;
            var beforeRow = input.closest('td').previousElementSibling;
            var hargaInput = beforeRow.querySelector('input[name="harga_produk[]"]');
            var nextHargaInput = nextRow.querySelector('input[name="hartot[]"]');

            var nextRow6 = input.closest('td').nextElementSibling.nextElementSibling.nextElementSibling
                .nextElementSibling.nextElementSibling.nextElementSibling;
            var nextHargaInput6 = nextRow6.querySelector('input[name="hcek[]"]');

            nextHargaInput6.value = hargaInput.value * nilaiInput;

            nextHargaInput.value = hargaInput.value;

            hitungTotalHarga()
        } else {
            var beforeRow = input.closest('td').previousElementSibling;
            var hargaInput = beforeRow.querySelector('input[name="harga_produk[]"]');
            var nextRow = input.closest('td').nextElementSibling.nextElementSibling;
            var nextHargaInput = nextRow.querySelector('input[name="hartot[]"]');

            var nextRow6 = input.closest('td').nextElementSibling.nextElementSibling.nextElementSibling
                .nextElementSibling.nextElementSibling.nextElementSibling;
            var nextHargaInput6 = nextRow6.querySelector('input[name="hcek[]"]');

            // console.log(nextRow6);

            nextHargaInput.value = hargaInput.value * nilaiInput;
            nextHargaInput6.value = hargaInput.value * nilaiInput;
            // console.log(nextHargaInput6.value);
            var nr = input.closest('td').nextElementSibling;
            var ndisc = nr.querySelector('input[name="diskon[]"]');
            ndisc.value = 0;

            hitungTotalHarga()


        }

    }

    function hitungDiskon(x) {
        var ipt = x.value;
        // console.log(ipt);
        var beforeRow1 = x.closest('td').nextElementSibling;
        var hsl = beforeRow1.querySelector('input[name="hartot[]"]');


        var nextRow5 = x.closest('td').nextElementSibling.nextElementSibling.nextElementSibling
            .nextElementSibling.nextElementSibling;
        var hasl5 = nextRow5.querySelector('input[name="hcek[]"]');

        // console.log(nextHargaInput5.value);

        var hrg_asli = parseFloat(hasl5.value);
        var hrg_ad = parseFloat(hrg_asli * parseFloat(ipt) / 100);
        var hrg_dis = hrg_asli - hrg_ad;

        hsl.value = hrg_dis;

        hitungTotalHarga()

    }
</script>

<script>
    function hitungTotalHarga() {
        var semuaInputHarga = document.querySelectorAll('input[name="hartot[]"]');
        var inputHargaTotal = document.getElementById("h_t");

        var hargaTotal = 0;

        semuaInputHarga.forEach(function(input) {
            var harga = parseFloat(input.value);
            if (!isNaN(harga)) {
                hargaTotal += harga;
            }
        });

        // Mengambil elemen dengan ID 'totalHarga' dan mengatur teksnya ke hargaTotal
        document.getElementById("totalHarga").innerText = hargaTotal; // Menyimpan nilai harga total dengan dua angka desimal
        inputHargaTotal.value = hargaTotal;

        var submitButton = document.getElementById('submitButton');
        if (inputHargaTotal != 0) {
            submitButton.disabled = false;
        }
        if (inputHargaTotal == 0) {
            submitButton.disabled = true;
        }
    }

    // Fungsi untuk menghapus baris pada tabel pembelian
    function hapusBaris(button) {
        var row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
        hitungTotalHarga()

    }
</script>

<!-- member -->
<script>
    function ubahNilai() {

        function generateRandomNumber(length) {
            return Math.floor(Math.random() * Math.pow(10, length));
        }

        function calculateCheckDigit(angka12Digit) {
            var total = 0;
            for (var i = 0; i < angka12Digit.length; i++) {
                var digit = parseInt(angka12Digit[i]);
                total += (i % 2 === 0) ? digit : digit * 3;
            }
            var checkDigit = (10 - (total % 10)) % 10;
            return checkDigit.toString();
        }

        function generateEAN13ID() {
            var angka12Digit = generateRandomNumber(12).toString();
            var digitKontrol = calculateCheckDigit(angka12Digit);
            return angka12Digit + digitKontrol;
        }

        var nilai = generateEAN13ID();

        document.getElementById("id_member").value = nilai;
    }
</script>




<?= $this->endSection(); ?>