<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>


<?php if (session()->has('success')) : ?>
    <div class="alert alert-success">
        <?= session('success') ?>
    </div>
<?php endif ?>


<div class="card ">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-shopping-basket"></i>
            Penjualan Grosir
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
                                <button type="button" class="btn btn-primary" onclick="paket('bukan paket')">Beli</button>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="col-md-9">
                    <form action="<?= base_url('/tambah_penjualan_grosir'); ?>" method="post"><?= csrf_field() ?>
                        <div class="container mt-3" style="overflow-x: auto; white-space: nowrap;">
                            <table id="example1" class="table table-bordered table-striped" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-sm-center">ID Produk</th>
                                        <th scope="col" class="text-sm-center">Nama Produk</th>
                                        <th scope="col" class="text-sm-center">Harga Awal</th>
                                        <th scope="col" class="text-sm-center">Harga</th>
                                        <th scope="col" class="text-sm-center">Banyak (Ml) </th>
                                        <th scope="col" class="text-sm-center">Diskon %</th>
                                        <th scope="col" class="text-sm-center">Harga Total</th>
                                        <th scope="col" class="text-sm-center">Aksi</th>


                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <!-- <td><input type="text" class="form-control" name="id_produk[]" placeholder="Masukkan ID Produk"></td>
                                    <td><input type="text" class="form-control" name="nama_produk[]" placeholder="Masukkan Nama Produk"></td>
                                    <td><input type="text" class="form-control" name="harga_produk[]" placeholder="Masukkan Harga Produk"></td>
                                    <td>
                                        <select class="form-control" onchange="hitungHargaTotal(this)">
                                            <option value="5">5 ML</option>
                                            <option value="10">10 ML</option>
                                            <option value="20">20 ML</option>
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" value="0" readonly></td>
                                    <td><button type="button" class="btn btn-danger" onclick="hapusBaris(this)">Hapus</button></td> -->
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <td><input type="text" class="form-control" value="<?= user()->id . $toko['id_toko'] . '-' . mt_rand(1000000, 9999999) ?>" name="id_penjualan" hidden></td><br>
                        <td><input type="text" class="form-control" id="h_t" name="harga_total" hidden></td><br>
                        <td><input type="text" class="form-control" name="kasir_id" value="<?= user()->id ?>" hidden></td><br>
                        <td><input type="text" class="form-control" name="toko_id" value="<?= $toko['id_toko'] ?>" hidden></td><br>
                        <hr>

                        <div class="row">
                            <div class="col-md-3 mb-2">
                                <select name="jenis_pembayaran" class="form-control" required>
                                    <option value="" disabled selected>Pilih Jenis Pembayaran</option>
                                    <option value="nobu">Nobu</option>
                                    <option value="cash">Cash</option>
                                </select>
                            </div>

                            <div class="col-md-3 d-flex">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Tempo</span>
                                        </div>
                                        <input type="date" class="form-control" name="tempo" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 mb-2">
                                <select class="form-control" name="pembeli_id">
                                    <option value="0">Bukan Member</option>
                                    <?php foreach ($toko_mbr as $tk) { ?>
                                        <option value="<?= $tk['id_toko'] ?>"><?= $tk['nama_toko'] ?></option>
                                    <?php } ?>
                                    <?php foreach ($member as $mbr) {
                                        if ($mbr['toko_id'] == user()->toko) { ?>
                                            <option value="<?= $mbr['id_member'] ?>"><?= $mbr['nama_member'] ?></option>
                                    <?php };
                                    } ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" id="membayar" name="membayar" oninput="cekht(this)" placeholder="Membayar" required>
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
</div>



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

    function paket(p) {

        if (produk) {

            var conlar = produk.harga_jual_produk;
            if (produk.jenis_harga == "USD") {
                conlar = produk.harga_jual_produk * 15000; //ganti dolar ntar
            }

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
            cell3.innerHTML = '<input type="text" class="form-control" name="harwal[]" value="' + produk.harga_jual_produk + ' ' + produk.jenis_harga + '" required>';
            cell4.innerHTML = '<input type="text" class="form-control" name="harga_produk[]" value="' + conlar + '" placeholder="Masukkan Harga Produk" required>';
            cell5.innerHTML = '<input type="text"  class="form-control" value="" name="banyak[]" oninput="hitungHargaTotal(this)" required>';
            cell6.innerHTML = '<input type="number" class="form-control" value="0" oninput="hitungDiskon(this)" name="diskon[]" required>';
            cell7.innerHTML = '<input type="text" class="form-control" value=""' + produk.harga_paket + '" name="hartot[]" required>';
            // hitungTotalHarga();

            cell9.innerHTML = '<input type="text" class="form-control" name="phg[]" required>';
            cell10.innerHTML = '<input type="text" class="form-control"  value="' + produk.banyak_ml + '" required hidden>';
            cell11.innerHTML = '<input type="text" class="form-control" value="' + produk.harga_paket + '" name="hcek[]" required hidden> ';


            cell8.innerHTML = '<button type="button" class="btn btn-danger" onclick="hapusBaris(this)"><i class="fas fa-times-circle"></i></button>';




        } else {
            alert("Data Produk tidak ditemukan, atau belum input id atau nama produk");
        }


    }

    // Fungsi untuk menghitung harga total
    function hitungHargaTotal(input) {
        var nilaiInput = input.value;

        // console.log("Nilai input:", nilaiInput);

        var br = input.closest('td').previousElementSibling.previousElementSibling.previousElementSibling.previousElementSibling;
        var idpInput = br.querySelector('input[name="id_produk[]"]').value;



        var dataPkt = <?php echo json_encode($paket); ?>;

        var pkt = dataPkt.find(function(item) {
            if (idpInput == item.produk_id) {
                if (nilaiInput < parseFloat(item.jenis_paket)) {
                    return true;
                }
            }
        });

        var jh = 0;
        var lh = 0;
        var nampak = 0;

        var lastItem = dataPkt.reverse().find(function(item) {
            if (idpInput == item.produk_id) {
                return true;
            };
        });

        if ((jh == 0) || (lh == 0) || (nampak == 0)) {
            lh = lastItem.harga;
            jh = lastItem.jenis_harga;
            nampak = lastItem.nama_paket;
        }
        // console.log(lh + jh);


        var br1 = input.closest('td').previousElementSibling.previousElementSibling;
        var hInput = br1.querySelector('input[name="harwal[]"]');

        var br2 = input.closest('td').previousElementSibling;
        var hpInput = br2.querySelector('input[name="harga_produk[]"]');

        var br3 = input.closest('td').nextElementSibling.nextElementSibling.nextElementSibling.nextElementSibling;
        console.log(br3);
        // console.log(pkt);
        var phgInput = br3.querySelector('input[name="phg[]"]');


        if (pkt) {
            hInput.value = pkt.harga + ' ' + jh;
            hpInput.value = pkt.harga;
            phgInput.value = pkt.nama_paket;
            if (jh == "USD") {
                hpInput.value = parseFloat(pkt.harga) * 15000;
            }
        } else {
            hInput.value = lh + ' ' + jh;
            hpInput.value = lh;
            phgInput.value = nampak;

            if (jh == "USD") {
                hpInput.value = parseFloat(lh) * 15000;
            }
        }


        var nr = input.closest('td').nextElementSibling;
        var ndisc = nr.querySelector('input[name="diskon[]"]');
        ndisc.value = 0;




        var hargaTotal = input.value;

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

        hitungTotalHarga()




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

<script>
    function cekht(input) {
        var ht = document.getElementById("totalHarga").innerHTML;
        var byr = input.value;
        // alert(ht + byr);

        if (parseFloat(ht) - parseFloat(byr) < 0) {
            ibyr = '';
            document.getElementById("membayar").value = ibyr;
            alert("tidak boleh membayar lebih dari yang harus dibayarkan");
        }
    };
</script>



<?= $this->endSection(); ?>