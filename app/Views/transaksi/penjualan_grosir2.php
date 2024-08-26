<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>


<?php if (session()->has('success')) : ?>
    <div class="alert alert-success">
        <?= session('success') ?>
    </div>
<?php endif ?>

<style>
    body {
        font-family: Arial, sans-serif;
    }

    .table-container,
    input {
        width: 100%;
        overflow-x: auto;
    }

    .xxx {
        width: 70px;
        overflow-x: auto;
    }

    .yyy {
        width: 130px;
        overflow-x: auto;
    }


    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 0px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    input::-webkit-inner-spin-button {
        display: block;
    }

    @media (min-width: 1200px) {
        .zzz {
            width: 190px;
            overflow-x: auto;
        }

        .yyy {
            width: 150px;
            overflow-x: auto;
        }

    }

    @media (max-width: 700px) {

        .xxx,
        .yyy,
        .www {
            width: 100%;
        }

        table,
        thead,
        tbody,
        th,
        td,
        tr {
            display: block;
        }

        thead {
            display: none;
        }

        tr {
            margin-bottom: 15px;
        }

        td {
            position: relative;
            padding-left: 50%;
            text-align: left;
        }

        th::before,
        td::before {
            content: attr(data-label);
            position: absolute;
            left: 10px;
            width: 45%;
            padding-right: 10px;
            white-space: nowrap;
            font-weight: bold;
        }
    }
</style>
<div class="card bgdt">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-cart-plus ct"> Penjualan Grosir</i>

        </h3>
        <div class="card-tools">
            <ul class="nav nav-pills ml-auto">
                <li class="nav-item mx-2 mt-1 ct">
                    <i>
                        <h6>Kasir : <?= user()->username ?></h6>
                    </i>


                </li>
                <li class="nav-item mx-2 mt-1 ct">
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
        <div class="card-body bgdt" style="padding: 3px;">

            <form id="formPembayaran" action="<?= base_url('/tambah_penjualan_grosir'); ?>" autocomplete="off" onsubmit="submitForm(event)" method="post"><?= csrf_field() ?>

                <div class="card-body" style="  min-height:300px; border-radius:5px; background-color:#f1f1f1;">
                    <table id="example5">
                        <!-- <table id="example5" class="table table-bordered table-striped" style="width: 100%;"> -->
                        <thead>
                            <tr>
                                <th>Nama Produk
                                </th>
                                <th class="yyy">ID Produk</th>
                                <th class="xxx">Harga Awal</th>
                                <th class="xxx">Harga Produk</th>
                                <th class="xxx">Banyak</th>
                                <th class="xxx">Diskon</th>
                                <th class="zzz">Harga Total</th>
                                <th style="width:30px;">Aksi</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <card style="background-color: #4e7194; height:300px;">
                            <tbody>
                                <!-- Rows will be added here by JavaScript -->
                            </tbody>
                        </card>

                    </table>
                    <i class="fas fa-plus ict" onclick="tambahBaris()" style="margin-right: 10px; cursor: pointer;"></i>
                    <i class="fas fa-minus ict" onclick="hapusBaris()" style="cursor: pointer;"></i>
                </div>

                <div class="ct" style="padding-top:5px; justify-content:flex-end; text-align:end; font-size: 30px; font-weight: bold; margin-right:30px;">
                    <p>Rp.
                        <span id="ttlall">0</span>
                    </p>
                    <input type="text" name="ttlall" id="ttl" required hidden>
                </div>

                <div class="row ctrl" style="background-color: #f1f1f1; border-radius:5px; margin:3px;">

                    <div class="col-md-2 mt-2">
                        <div class="form-group d-flex">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Tempo</span>
                                </div>
                                <input type="date" class="form-control" name="tempo" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2 mt-2">
                        <select id="jenis_pembayaran" name="jenis_pembayaran" class="form-control" required>
                            <option value="" disabled selected>Jenis Pembayaran</option>
                            <option value="nobu">Nobu</option>
                            <option value="cash">Cash</option>
                        </select>
                    </div>


                    <div class="col-md-2 mt-2">
                        <input type="text" class="form-control" name="pembeli_id" list="memberships" placeholder="Pembeli: " required>

                        <datalist id="memberships">
                            <?php foreach ($toko_mbr as $tk) {
                                if ($tk['id_toko'] != 0) { ?>
                                    <option value="<?= $tk['id_toko'] ?>"><?= $tk['nama_toko'] ?></option>
                            <?php }
                            } ?>
                            <?php foreach ($member as $mbr) {
                                if ($mbr['toko_id'] == user()->toko) { ?>
                                    <option value="<?= $mbr['id_member'] ?>"><?= $mbr['nama_member'] ?></option>
                            <?php };
                            } ?>
                        </datalist>

                    </div>
                    <div class="col-md-2 mt-2">
                        <input type="text" class="form-control" id="membayar" name="membayar" placeholder="Membayar" required>
                    </div>

                    <input type="text" value="<?= user()->id . $toko['id_toko'] . '-' . mt_rand(1000000, 9999999) ?>" name="id_penjualan" hidden>
                    <input type="text" name="kasir_id" value="<?= user()->id ?>" hidden>
                    <input type="text" name="toko_id" value="<?= $toko['id_toko'] ?>" hidden>



                    <div class="col-md-2 mt-2" style="justify-content:flex-end">
                        <button class="btn btn-warning btn-lg bt" type="submit"> <span class="fas fa-shopping-basket ct"></button>
                        <!-- <button type="button" id="okeButton" class="btn btn-warning bt" data-toggle="modal" data-target="#formModal">Oke</button> -->

                    </div>
                </div>


                <div class="modal" id="myModal">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h8 class="modal-title">Pencarian Produk<br><i>[nama] [stok]</i></h8>


                                <button type="button" class="close" data-dismiss="modal">&times;</button>

                            </div>

                            <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                                <!-- <input type="text" id="productNameInput" class="form-control" placeholder="Enter Product ID" required> -->
                                <ul id="searchResults" class="list-group mt-2"></ul>
                            </div>
                            <hr>

                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>


    <!-- member -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-start"> <!-- Menggunakan flexbox untuk menempatkan tombol ke kanan -->
                <button type="button" class="btn btn-warning mx-1 bt" data-toggle="modal" data-target="#member" title="Tambah Member">
                    <i class="fas fa-id-card mx-2 ct"></i><i class="fa fa-plus-circle ct"></i>
                </button>
            </div>
        </div>
    </div>


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

</section>
</div>

<!-- ctrl field bawah -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctrlDiv = document.querySelector('.ctrl');
        var inputs = ctrlDiv.querySelectorAll('input, select, textarea, button');

        for (var i = 0; i < inputs.length; i++) {
            inputs[i].addEventListener('keydown', function(event) {
                var index = Array.prototype.indexOf.call(inputs, this);

                if (event.keyCode === 37) { // Tombol panah kiri
                    if (this.type === 'text' && this.selectionStart > 0) {
                        return; // Biarkan perilaku default jika kursor tidak di awal
                    }
                    if (index > 0) {
                        inputs[index - 1].focus();
                    } else {
                        inputs[inputs.length - 1].focus();
                    }
                    event.preventDefault();
                }

                if (event.keyCode === 39 && this.type !== 'date') { // Tombol panah kanan, tidak berlaku untuk input date
                    if (this.type === 'text' && this.selectionEnd < this.value.length) {
                        return; // Biarkan perilaku default jika kursor tidak di akhir
                    }
                    if (index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    } else {
                        inputs[0].focus();
                    }
                    event.preventDefault();
                }
            });
        }

        // Memungkinkan navigasi di dalam input tanggal
        var dateInputs = ctrlDiv.querySelectorAll('input[type="date"]');
        for (var j = 0; j < dateInputs.length; j++) {
            dateInputs[j].addEventListener('keydown', function(event) {
                // Jika fokus di input tanggal, biarkan navigasi di dalam input tanggal hanya dengan tombol panah kiri
                if (event.keyCode === 37) { // Tombol panah kiri
                    if (this.selectionStart === 0) {
                        var index = Array.prototype.indexOf.call(inputs, this);
                        if (index > 0) {
                            inputs[index - 1].focus(); // Beralih ke input sebelumnya
                        } else {
                            inputs[inputs.length - 1].focus(); // Beralih ke input terakhir jika saat di input pertama
                        }
                        event.preventDefault();
                    }
                }
            });
        }
    });
</script>

<!-- Ambil data produk dari PHP -->
<script>
    var dataProduk = <?php echo json_encode($produk); ?>;
    // console.log(dataProduk);
    var dlr = <?php echo json_encode($dlr); ?>;


    // Mengonversi data produk dari PHP menjadi format JavaScript
    const products = dataProduk.map(item => ({
        id: item.id_produk,
        name: item.nama_produk,
        stok: item.stok_toko,
        harga_produk: item.harga_produk,
        hjp: item.harga_jual_produk,
        harwal: item.harga_jual_produk + ' ' + item.jenis_harga,
        jh: item.jenis_harga,
        kategori: item.kategori_produk
    }));
</script>

<!-- control keyboard -->
<script>
    function tambahEventListeners(row) {
        const inputs = row.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('keydown', (event) => {
                const keyCode = event.code;
                const currentInput = event.target;
                const currentCell = currentInput.parentNode;
                let targetInput = null;

                if (keyCode === 'ArrowRight' || keyCode === 'ArrowLeft') {
                    // Navigasi di dalam input field
                    if (keyCode === 'ArrowRight' && currentInput.selectionEnd === currentInput.value.length) {
                        // Tombol panah kanan dan kursor di ujung kanan
                        targetInput = currentCell.nextElementSibling.querySelector('input');
                    } else if (keyCode === 'ArrowLeft' && currentInput.selectionStart === 0) {
                        // Tombol panah kiri dan kursor di ujung kiri
                        targetInput = currentCell.previousElementSibling.querySelector('input');
                    }
                } else if (keyCode === 'ArrowUp') {
                    // Navigasi ke baris atas
                    const currentRowIndex = currentCell.parentNode.rowIndex;
                    if (currentRowIndex > 0) {
                        const targetRow = currentCell.parentNode.previousElementSibling;
                        targetInput = targetRow.cells[currentCell.cellIndex].querySelector('input');
                    }
                } else if (keyCode === 'ArrowDown') {
                    // Navigasi ke baris bawah
                    const currentRowIndex = currentCell.parentNode.rowIndex;
                    const targetRow = currentCell.parentNode.nextElementSibling;
                    if (targetRow) {
                        targetInput = targetRow.cells[currentCell.cellIndex].querySelector('input');
                    }
                }

                if (targetInput) {
                    targetInput.focus();
                    // Pindahkan kursor ke ujung kiri input field
                    targetInput.setSelectionRange(0, 0);
                }
            });
        });
    }
</script>
<!-- tambah baris -->
<script>
    // Variabel global untuk menyimpan referensi ke input field yang memicu modal
    let currentInput = null;
    let isEventListenerAdded = false;



    function tambahBaris() {
        var tabel = document.getElementById("example5").getElementsByTagName('tbody')[0];
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

        // Tambahkan atribut data-id unik
        const uniqueId = Date.now();
        // cell1.innerHTML = `<input type="text" data-id="${uniqueId}" class="iii"  name="nama_produk[]"  required > `;
        // cell1.querySelector('input').addEventListener('keydown', function(event) {
        //     // if (event.key === 'Enter') {
        //     //     currentInput = this; // Simpan referensi ke input field yang memicu modal
        //     //     var productName = this.value.trim();
        //     //     showModal(productName);
        //     // }
        //     if (event.key === 'Enter') {
        //         currentInput = this; // Simpan referensi ke input field yang memicu modal
        //         currentRow = newRow; // Simpan referensi ke row yang sedang aktif
        //         const productName = this.value.trim();
        //         showModal(productName);
        //     }

        // });
        cell1.innerHTML = `
    <div class="input-group">
        <input type="text" data-id="${uniqueId}" class="form-control iii" name="nama_produk[]" required>
        <div class="input-group-append">
            <button type="button" class="btn btn-outline-secondary trigger-modal bt"><i class="fas fa-search ct"></i></button>
        </div>
    </div>
`;

        const inputField = cell1.querySelector('input');
        const triggerButton = cell1.querySelector('.trigger-modal');

        function handleModalTrigger() {
            currentInput = inputField; // Simpan referensi ke input field yang memicu modal
            currentRow = newRow; // Simpan referensi ke row yang sedang aktif
            const productName = inputField.value.trim();
            showModal(productName);
        }

        inputField.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                handleModalTrigger();
            }
        });

        triggerButton.addEventListener('click', handleModalTrigger);

        // ---
        cell2.innerHTML = `<input type="text" class="yyy" data-id="${uniqueId}" oninput="cekid(this)"  name="id_produk[]"  required>`;
        cell3.innerHTML = '<input type="text" class="xxx" name="harwal[]"  required>';
        cell4.innerHTML = '<input type="text" class="xxx" name="harga_produk[]"  required>';
        cell5.innerHTML = '<input type="text" class="xxx" name="banyak[]" oninput="hitungHargaTotal(this)"  required>';
        cell6.innerHTML = '<input type="text" class="xxx" name="diskon[]" oninput="hitungDiskon(this)" value="0"  required>';
        cell7.innerHTML = '<input type="text" class="zzz ttl" name="hartot[]"  required>';
        cell8.innerHTML = '<button type="button" class="btn-danger bt" onclick="hapusBaris()"><i class="fas fa-times-circle ct"></i></button>';
        cell9.innerHTML = '<input type="text"  name="phg[]" hidden>';
        cell10.innerHTML = '<input type="text"  name="harga_dlr[]" hidden>';
        cell11.innerHTML = '<input type="text"  name="hcek[]" hidden>';

        cell1.setAttribute('data-label', 'Nama Produk');
        cell2.setAttribute('data-label', 'ID Produk');
        cell3.setAttribute('data-label', 'Harga Awal');
        cell4.setAttribute('data-label', 'Harga Produk');
        cell5.setAttribute('data-label', 'Banyak');
        cell6.setAttribute('data-label', 'Diskon');
        cell7.setAttribute('data-label', 'Harga Total');
        cell8.setAttribute('data-label', 'Aksi');
        cell9.setAttribute('data-label', '');
        cell10.setAttribute('data-label', '');
        cell11.setAttribute('data-label', '');


        tambahEventListeners(newRow);

        fokuskan();
        ttl();

    }

    // popup
    // document.getElementById('okeButton').addEventListener('click', function() {
    //     var form = document.getElementById('formPembayaran');
    //     var formData = new FormData(form);
    //     var dataObj = {};
    //     formData.forEach((value, key) => {
    //         if (!dataObj[key]) {
    //             dataObj[key] = [];
    //         }
    //         dataObj[key].push(value);
    //     });

    //     var un = <?php echo json_encode(user()->username); ?>;
    //     var tk = <?php echo json_encode($toko['nama_toko']); ?>;


    //     // var pre = document.getElementById("formData");
    //     // pre.textContent = JSON.stringify(dataObj, null, 2);
    //     $('#fakturNo').text(dataObj['id_penjualan'][0]);
    //     $('#kasirName').text(un);
    //     $('#pelangganName').text((dataObj['pembeli_id'][0] || 'Umum'));
    //     $('#waktuTransaksi').text(dataObj['tempo'][0]);
    //     $('#tokoName').text(tk);
    //     $('#tokoTelp').text('08123456789');
    //     $('#tokoAlamat').text('Jalan Contoh No. 123');

    //     var tbody = $("#penjualanTable tbody");
    //     tbody.empty();

    //     for (let i = 0; i < dataObj['nama_produk[]'].length; i++) {
    //         let row = $('<tr></tr>');
    //         row.append(`<td>${dataObj['nama_produk[]'][i]}</td>`);
    //         row.append(`<td>${dataObj['banyak[]'][i]}</td>`);
    //         row.append(`<td>${dataObj['harga_produk[]'][i]}</td>`);
    //         row.append(`<td>${dataObj['hartot[]'][i]}</td>`);
    //         row.append(`<td>${dataObj['diskon[]'][i]}</td>`);
    //         row.append(`<td>${dataObj['hartot[]'][i]}</td>`);
    //         tbody.append(row);
    //     }

    //     $('#grandTotal').text('Rp.' + dataObj['ttlall'][0]);
    //     $('#hutangTotal').text('Rp.' + dataObj['ttlall'][0]);
    //     $('#statusPembayaran').text('Status Pembayaran: Belum Lunas');

    // });


    function fokuskan() {
        var tabel = document.getElementById("example5").getElementsByTagName('tbody')[0];
        var lastRow = tabel.rows[tabel.rows.length - 1]; // Ambil baris terakhir yang baru ditambahkan
        var inputs = lastRow.querySelectorAll('input');
        if (inputs.length >= 2) {
            inputs[1].focus();
            // console.log('Focused on input:', inputs[1]);
        }
    }

    window.onload = function() {
        tambahBaris();
    };
</script>
<!-- harga total dan diskon -->
<script>
    function hitungHargaTotal(input) {
        // Ambil nilai banyak dan harga_produk dari input field yang memicu event
        var banyak = parseFloat(input.value);

        var dataPkt = <?php echo json_encode($paket); ?>;
        var id_produk = input.parentNode.parentNode.cells[1].querySelector('input').value;
        var harwal = input.parentNode.parentNode.cells[2].querySelector('input');

        var pkt = dataPkt.find(function(item) {
            if (id_produk == item.produk_id) {
                if (banyak < parseFloat(item.jenis_paket)) {
                    return true;
                }
            }
        });



        var lastItem = dataPkt.reverse().find(function(item) {
            if (id_produk == item.produk_id) {
                return true;
            };
        });

        // console.log(pkt);
        // console.log(lastItem);



        var hartotInput = input.parentNode.parentNode.cells[6].querySelector('input');
        var hcekInput = input.parentNode.parentNode.cells[10].querySelector('input');
        var phg = input.parentNode.parentNode.cells[8].querySelector('input');
        var disc = input.parentNode.parentNode.cells[5].querySelector('input');
        var h_dlr = input.parentNode.parentNode.cells[9].querySelector('input');
        h_dlr.value = dlr.harga_rupiah;
        var hargaProdukInput = input.parentNode.parentNode.cells[3].querySelector('input');


        if (pkt) {
            harwal.value = pkt.harga + ' ' + pkt.jenis_harga;
            phg.value = pkt.nama_paket;

            hartotInput.value = banyak * pkt.harga; //harga rupiah
            hcekInput.value = banyak * pkt.harga;
            hargaProdukInput.value = pkt.harga;

            if (pkt.jenis_harga == "USD") {
                hartotInput.value = banyak * pkt.harga * dlr.harga_rupiah; //harga dollar
                hcekInput.value = banyak * pkt.harga * dlr.harga_rupiah;
                hargaProdukInput.value = pkt.harga * dlr.harga_rupiah;
                // console.log(pkt.harga);


            }
        } else {
            harwal.value = lastItem.harga + ' ' + lastItem.jenis_harga;
            phg.value = lastItem.nama_paket;

            hartotInput.value = banyak * lastItem.harga; //harga rupiah
            hcekInput.value = banyak * lastItem.harga; //harga dollar
            hargaProdukInput.value = lastItem.harga;


            if (lastItem.jenis_harga == "USD") {
                hartotInput.value = banyak * lastItem.harga * dlr.harga_rupiah; //harga dollar
                hcekInput.value = banyak * lastItem.harga * dlr.harga_rupiah;
                hargaProdukInput.value = lastItem.harga * dlr.harga_rupiah;
                // console.log(lastItem.harga);

            }
        }
        // console.log(banyak);
        // console.log(pkt);

        hitungDiskon(disc);
        ttl();

    }

    function hitungDiskon(input) {
        // Ambil nilai diskon dari input field yang memicu event
        var diskon_persen = parseInt(input.value);

        // Ambil nilai harga total dari input field sebelumnya
        var hartotInput = input.parentNode.parentNode.cells[6].querySelector('input');
        var hcekInput = input.parentNode.parentNode.cells[10].querySelector('input');


        var hargaTotal = parseInt(hcekInput.value);


        var diskon = hargaTotal * (diskon_persen / 100);

        // Hitung harga setelah diskon
        var hargaSetelahDiskon = hargaTotal - diskon;


        hartotInput.value = hargaSetelahDiskon;
        ttl();
        // // Tampilkan hasilnya di console log
        // console.log('Harga Total sebelum Diskon:', hargaTotal);
        // console.log('Diskon:', diskon);
        // console.log('Harga Setelah Diskon:', hargaSetelahDiskon);
    }
</script>
<!-- Fungsi untuk menghapus baris -->
<script>
    function hapusBaris() {
        var selectedRow = document.querySelector('tr.selected'); // Ambil baris yang dipilih

        if (selectedRow) { // Jika ada baris yang dipilih
            selectedRow.remove(); // Hapus baris tersebut
        } else { // Jika tidak ada baris yang dipilih
            var tabel = document.getElementById("example5").getElementsByTagName('tbody')[0];
            var lastRowIndex = tabel.rows.length - 1;
            tabel.deleteRow(lastRowIndex); // Hapus baris terakhir
        }
        fokuskan();
        ttl();
    }
</script>
<!-- Tambahkan event listener untuk kombinasi tombol Enter + Enter dan Ctrl + Delete -->
<script>
    document.addEventListener('keydown', function(event) {
        if (event.ctrlKey && event.key === 'Enter') { // Ctrl + Enter
            event.preventDefault(); // Mencegah aksi default (mis. submit form)
            tambahBaris(); // Jalankan fungsi tambahBaris
        } else if (event.ctrlKey && event.key === 'Delete') { // Ctrl + Delete
            hapusBaris(); // Hapus baris yang dipilih atau terakhir
        }
    });


    // Tambahkan event listener untuk mengklik baris dan menetapkan kelas 'selected'
    document.getElementById('example5').addEventListener('click', function(event) {
        pilihBaris(event);
    });

    // Fungsi untuk menetapkan kelas 'selected' pada baris yang dipilih
    function pilihBaris(event) {
        var rows = document.querySelectorAll('#example5 tbody tr');
        rows.forEach(function(row) {
            row.classList.remove('selected');
        });

        var row = event.target.closest('tr');
        row.classList.add('selected');
    }
</script>


<!-- pencarian produk -->

<script>
    function cekid(input) {
        x = input.value;
        const idResults = products.filter(product => product.id.toLowerCase() === x.toLowerCase());

        const row = input.closest('tr');
        const all = row.querySelectorAll('td');

        const nm = all[0].querySelector('input');
        const hw = all[2].querySelector('input');
        const hp = all[3].querySelector('input');

        if (idResults.length > 0) {
            data = idResults[0];
            nm.value = data.name;
            hw.value = data.harwal;
            if (data.jh == "USD") {
                hp.value = (parseFloat(data.hjp) * parseFloat(dlr.harga_rupiah));
            } else {
                hp.value = data.hjp;
            }

        } else {
            nm.value = '';

        }
    }
</script>

<script>
    function displaySearchResults(results) {
        const searchResults = document.getElementById('searchResults');
        searchResults.innerHTML = '';

        results.forEach(result => {
            const listItem = document.createElement('li');
            listItem.className = 'list-group-item';
            listItem.innerHTML = `
            <i>[ ${result.name} ]   [ ${result.stok} ]</i>
            `;

            listItem.tabIndex = 0; // Untuk membuatnya fokusable

            listItem.addEventListener('click', () => {

                if (currentInput && currentRow) {
                    currentInput.value = result.name;

                    // Isi kolom lainnya berdasarkan produk yang dipilih
                    const product = products.find(p => p.name === result.name); //----
                    if (product) {
                        currentRow.cells[1].querySelector('input').value = product.id;
                        currentRow.cells[2].querySelector('input').value = product.harwal;

                        if (product.jh == "USD") {
                            currentRow.cells[3].querySelector('input').value = (parseFloat(product.hjp) * parseFloat(dlr.harga_rupiah));
                        } else {
                            currentRow.cells[3].querySelector('input').value = product.hjp;
                        }

                        currentRow.cells[4].querySelector('input').value = '';
                        currentRow.cells[5].querySelector('input').value = 0;
                        currentRow.cells[6].querySelector('input').value = '';
                        currentRow.cells[10].querySelector('input').value = '';


                    }

                    currentInput = null;
                    currentRow = null;
                }
                $('#myModal').modal('hide'); // Menutup modal

            });

            searchResults.appendChild(listItem);
        });

        if (results.length > 0) {
            setTimeout(() => {
                searchResults.firstChild.focus();
            }, 100); // Menunda pemfokusan selama 100 milidetik
        }

        // console.log(document.activeElement);

        if (!isEventListenerAdded) { // Tambahkan event listener hanya sekali
            document.addEventListener('keydown', (event) => {
                const focusedElement = document.activeElement;

                if (focusedElement && focusedElement.parentElement === searchResults) {
                    if (event.key === 'ArrowDown') {
                        const nextElement = focusedElement.nextElementSibling;
                        if (nextElement && nextElement.classList.contains('list-group-item')) {
                            nextElement.focus();
                            event.preventDefault(); // Mencegah scroll default
                        }
                    } else if (event.key === 'ArrowUp') {
                        const previousElement = focusedElement.previousElementSibling;
                        if (previousElement && previousElement.classList.contains('list-group-item')) {
                            previousElement.focus();
                            event.preventDefault(); // Mencegah scroll default
                        }
                    } else if (event.key === 'Enter') { // Ctrl + Space
                        if (focusedElement && focusedElement.classList.contains('list-group-item')) {
                            focusedElement.click();
                            fokuskan();

                        }
                    }
                }
            });
            isEventListenerAdded = true; // Tandai bahwa event listener telah ditambahkan
        }
    }
</script>
<!-- menampilkan modal -->
<script>
    // Fungsi untuk melakukan pencarian produk berdasarkan nama produk
    function searchProduct(query) {
        return products.filter(product => product.name.toLowerCase().includes(query.toLowerCase()));
    }


    // Fungsi untuk menampilkan modal dengan nama produk yang dipilih
    function showModal(productName) {
        // Mengambil input pencarian
        const query = productName.trim();
        const results = searchProduct(query);
        displaySearchResults(results);
        // Mengatur nilai input searchResults dengan nilai productName
        // console.log(results.length);
        if (results.length > 0) {
            document.getElementById('searchResults').value = productName;
            $('#myModal').modal('show');
        }
    }
</script>

<!-- member id -->
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
<!-- total -->
<script src="<?= base_url('') ?>rp.js"></script><!-- terbilang dan titik   -->

<script>
    function ttl() {
        var inputs = document.querySelectorAll('.zzz');
        var total = 0;
        inputs.forEach(function(input) {
            var value = parseFloat(input.value);
            if (!isNaN(value)) {
                total += value;
            }
        });
        // console.log('Total Harga Semua Produk:', total);
        document.getElementById('ttlall').innerHTML = titik(total);
        document.getElementById('ttl').value = total;
    }
</script>


<?= $this->endSection(); ?>