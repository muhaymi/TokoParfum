<?php

use App\Models\M_toko;
use App\Models\M_dollar;

$model = new M_dollar();
$dollarku = $model->find(1);


$toko = new M_toko();
$tk = $toko->find(user()->toko);
$tokoku = '';

if ($tk['nama_toko'] == 'belum ada') {
    $tokoku = 'Uwaw Parfum';
} else {
    $tokoku = $tk['nama_toko'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $tokoku ?></title>
    <base href="<?= base_url('/') ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">

    <link rel="stylesheet" href="dist/css/adminlte.min.css?v=3.2.0">

    <!-- tabel -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <!-- modal -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .bgct {
            background-color: whitesmoke;
        }

        .ipf {
            background-color: whitesmoke;
        }

        .ct,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            color: #914F1E;
        }

        .nav-pills .nav-link.active {
            background-color: #DEAC80;
            color: white;
        }


        .ict {
            color: chocolate;
        }

        .table {
            background-color: wheat;
        }


        .bt,
        .btn-secondary,
        .btn-primary,
        .btn-danger,
        .btn-warning,
        .nav-pills .nav-link {
            background-color: #DEAC80;
            /* background-color: chocolate !important; */
            border-radius: 10px;
            color: #914F1E;

        }



        /* .btn-secondary {
            background-color: red;

        } */


        .bgdt,
        .card-header,
        .modal-header {
            background-color: #B5C18E;
            /* background-color: #E3B04B; */
        }
    </style>



</head>

<body class="hold-transition sidebar-mini layout-fixed ">

    <div class="wrapper">

        <nav class="main-header navbar navbar-expand navbar-white navbar-light bgdt">


            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" role="button"><i class="fas fa-bars ct"></i></a>
                </li>

            </ul>
            <button class="btn btn-warning btn-sm bt" data-toggle="modal" data-target="#ubahHargaModal">
                <i class='fas fa-search-dollar ct' style='font-size:24px'></i><i class="ct"><?= $dollarku['harga_rupiah'] ?></i>
            </button>

            <ul class="navbar-nav ml-auto bt">

                <li class="nav-item">

                    <a class="nav-link " data-widget="fullscreen" role="button">
                        <i id="clock" class="fas fa-expand-arrows-alt ct"></i>
                        <i class="fas fa-expand-arrows-alt ct"></i>
                    </a>
                </li>

            </ul>
        </nav>


        <aside class="main-sidebar sidebar-dark-primary elevation-4 bgdt">

            <p class="brand-link">
                <img src="<?= base_url('logo/') ?><?= $tk['logo_toko'] ?>" style="width: 35px; height: 35px; margin-left:15px; border-radius: 50%; object-fit: cover; opacity: 0.8;">
                <span class="brand-text font-weight-light ct"><?= $tokoku ?></span>
            </p>

            <div class="sidebar">

                <?= view('layoutSides/navTop') ?>
                <?= view('layoutSides/navBar') ?>

            </div>

        </aside>

        <div class="content-wrapper bgct">

            <section class="content-header">
                <div class="container-fluid">

                </div>
            </section>

            <section class="content ">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">

                            <?= $this->renderSection('content') ?>


                        </div>
                    </div>
                </div>
            </section>

        </div>


        <?= view('layoutSides/footer') ?>

        <aside class="control-sidebar control-sidebar-dark">
        </aside>

    </div>



    <!-- Modal -->
    <div class="modal fade" id="ubahHargaModal" tabindex="-1" role="dialog" aria-labelledby="ubahHargaModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ubahHargaModalLabel">Ubah Harga Dolar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form untuk mengubah harga dolar -->
                    <form action="<?= base_url('/ubah_dolar') ?>" method="post">
                        <div class="form-group">
                            <input type="text" class="form-control" name="harga_rupiah" placeholder="Harga Dolar (Rp)" value="<?= $dollarku['harga_rupiah'] ?>">
                        </div>
                        <!-- Tombol untuk menyimpan perubahan -->
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>





    <!-- jam -->
    <script>
        function updateClock() {
            var options = {
                timeZone: 'Asia/Jakarta',
                hour12: false
            };
            var now = new Date().toLocaleString('id-ID', options);
            document.getElementById('clock').textContent = now;
        }

        // Memanggil fungsi updateClock setiap detik
        setInterval(updateClock, 1000);

        // Memanggil fungsi updateClock untuk menampilkan waktu saat ini pada saat halaman pertama kali dimuat
        updateClock();
    </script>
    <!-- /jam -->

    <script src="plugins/jquery/jquery.min.js"></script>

    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

    <script src="dist/js/adminlte.min.js?v=3.2.0"></script>

    <!-- <script src="dist/js/demo.js"></script> -->

    <!-- tabel -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="plugins/jszip/jszip.min.js"></script>
    <script src="plugins/pdfmake/pdfmake.min.js"></script>
    <script src="plugins/pdfmake/vfs_fonts.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script src="plugins/datatables-select/js/dataTables.select.min.js"></script>
    <script src="plugins/datatables-searchpanes/js/dataTables.searchPanes.min.js"></script>



    <script>
        $(function() {
            var table = $("#example1").DataTable({
                "responsive": true,
                "lengthChange": true,
                "lengthMenu": [5, 25, 50, 100, 1000],
                "autoWidth": false,

                "buttons": [
                    //    {     extend: 'copy',
                    //         exportOptions: {
                    //             columns: ':visible'
                    //         }
                    //     },
                    //     {
                    //         extend: 'csv',
                    //         exportOptions: {
                    //             columns: ':visible'
                    //         }
                    //     },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'colvis'
                    }
                ]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');


            var table = $("#example2").DataTable({
                "responsive": true,
                "lengthChange": true,
                "lengthMenu": [5, 25, 50, 100, 1000],
                "autoWidth": false,

                "buttons": [{
                        extend: 'excel',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'colvis'
                    }
                ]
            }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');

            var table = $("#example3").DataTable({
                "responsive": true,
                "lengthChange": true,
                "lengthMenu": [5, 25, 50, 100, 1000],
                "autoWidth": false,

                "buttons": [{
                        extend: 'excel',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'colvis'
                    }
                ]
            }).buttons().container().appendTo('#example3_wrapper .col-md-6:eq(0)');


            var table = $("#example4").DataTable({
                "responsive": false,
                "lengthChange": false,
                "autoWidth": false,
                "searching": false,
                "paging": false,
                "info": false,
                "ordering": false


            });


            // var table = $("#example5").DataTable({
            //     "responsive": false,
            //     "lengthChange": false,
            //     "autoWidth": false,
            //     "searching": false,
            //     "paging": false,
            //     "info": false,
            //     "ordering": false,
            //     "language": {
            //         "emptyTable": " "
            //     }


            // });



        });
    </script>

</body>

</html>