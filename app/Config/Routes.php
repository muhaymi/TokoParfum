<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//  produk eceran
$routes->get('/produk', 'Produk::produk');
$routes->post('/simpan_produk', 'Produk::simpan_produk', ['filter' => 'role:Admin,Bos']);
$routes->post('/ubah_produk', 'Produk::ubah_produk');
$routes->delete('/hapus_produk/(:segment)', 'Produk::hapus_produk/$1', ['filter' => 'role:Admin,Bos']);

$routes->get('/penjualan', 'Penjualan::penjualan');
$routes->get('/data_penjualan', 'Penjualan::data_penjualan', ['filter' => 'role:Admin,Bos']);
$routes->post('/tambah_penjualan', 'Penjualan::tambah_penjualan', ['filter' => 'role:Admin,Bos']);
$routes->delete('/batalkan_penjualan/(:num)/(:segment)/(:segment)/(:num)', 'Penjualan::batalkan_penjualan/$1/$2/$3/$4', ['filter' => 'role:Admin,Bos']);
$routes->delete('/hapus_penjualan/(:num)', 'Penjualan::hapus_penjualan/$1', ['filter' => 'role:Admin,Bos']);

$routes->get('/data_pembayaran', 'Penjualan::data_pembayaran', ['filter' => 'role:Admin,Bos']);



//  produk grosir
$routes->get('/produk_grosir', 'ProdukGrosir::produk_grosir');
$routes->post('/simpan_produk_grosir', 'ProdukGrosir::simpan_produk_grosir', ['filter' => 'role:Admin,Bos']);
$routes->post('/ubah_produk_grosir', 'ProdukGrosir::ubah_produk_grosir');
$routes->delete('/hapus_produk_grosir/(:segment)', 'ProdukGrosir::hapus_produk_grosir/$1', ['filter' => 'role:Admin,Bos']);

$routes->post('/ubah_dolar', 'PenjualanGrosir::ubah_dolar', ['filter' => 'role:Admin,Bos']);

$routes->get('/penjualan_grosir', 'PenjualanGrosir::penjualan_grosir');
$routes->get('/data_penjualan_grosir', 'PenjualanGrosir::data_penjualan_grosir');
$routes->post('/tambah_penjualan_grosir', 'PenjualanGrosir::tambah_penjualan_grosir', ['filter' => 'role:Admin,Bos']);
$routes->post('/ubah_penjualan_grosir', 'PenjualanGrosir::ubah_penjualan_grosir', ['filter' => 'role:Admin,Bos']);
$routes->delete('/batalkan_penjualan_grosir/(:segment)', 'PenjualanGrosir::batalkan_penjualan_grosir/$1', ['filter' => 'role:Admin,Bos']);
// $routes->delete('/batalkan_penjualan_grosir/(:num)/(:segment)/(:segment)/(:num)/(:segment)/(:segment)', 'PenjualanGrosir::batalkan_penjualan_grosir/$1/$2/$3/$4/$5/$6', ['filter' => 'role:Admin,Bos']);
$routes->delete('/hapus_penjualan_grosir/(:num)', 'PenjualanGrosir::hapus_penjualan_grosir/$1', ['filter' => 'role:Admin,Bos']);


$routes->get('/data_pembayaran_grosir', 'PenjualanGrosir::data_pembayaran_grosir', ['filter' => 'role:Admin,Bos']);
$routes->post('/bayar_hutang_grosir', 'PenjualanGrosir::bayar_hutang_grosir', ['filter' => 'role:Admin,Bos']);


// member
$routes->get('/member_grosir', 'Set::member_grosir');
$routes->post('/tambah_member', 'Set::tambah_member');
$routes->post('/edit_member', 'Set::edit_member');

$routes->delete('/hapus_member/(:num)', 'Set::hapus_member/$1', ['filter' => 'role:Admin,Bos']);




$routes->get('/pw/(:num)', 'Pengguna::editPassword/$1');
$routes->get('/penggunaa', 'Pengguna::pengguna');
$routes->post('/simpan_pengguna', 'Pengguna::simpan_pengguna');
$routes->post('/ubah_PW', 'Pengguna::ubah_PW');
$routes->delete('/hapus_pengguna/(:num)', 'Pengguna::hapus_pengguna/$1', ['filter' => 'role:Admin,Bos']);
$routes->post('/ubah_data_pengguna', 'Pengguna::ubah_data_pengguna');
$routes->post('/ubah_data_ku', 'Pengguna::ubah_data_ku');


$routes->post('admin/users/update-password', 'Pengguna::updatePassword');

// paket eceran 
$routes->get('/paket_harga', 'Set::paket_harga');
$routes->post('/tambah_paket', 'Set::tambah_paket');
$routes->post('/edit_paket', 'Set::edit_paket');
$routes->delete('/hapus_paket/(:num)', 'Set::hapus_paket/$1', ['filter' => 'role:Admin,Bos']);

// paket grosir 
$routes->get('/paket_harga_grosir', 'Set::paket_harga_grosir');
$routes->post('/tambah_paket_grosir', 'Set::tambah_paket_grosir');
$routes->post('/edit_paket_grosir', 'Set::edit_paket_grosir');
$routes->delete('/hapus_paket_grosir/(:num)', 'Set::hapus_paket_grosir/$1', ['filter' => 'role:Admin,Bos']);



// $routes->get('/', 'Home::index');
$routes->put('/profile/(:num)', 'Home::profile/$1');
$routes->post('/profile/update/(:num)', 'Home::profileUpdate/$1');

$routes->get('/', 'Home::index');
$routes->get('/index', 'Home::index', ['filter' => 'role:admin,user,bos']);


// admin
$routes->get('/toko', 'Toko::toko', ['filter' => 'role:Admin,Bos']);
$routes->post('/toko_baru', 'Toko::toko_baru', ['filter' => 'role:Admin,Bos']);
$routes->post('/ubah_toko', 'Toko::ubah_toko', ['filter' => 'role:Admin,Bos']);
$routes->delete('/hapus_toko/(:num)', 'Toko::hapus_toko/$1', ['filter' => 'role:Admin,Bos']);

// laba
$routes->get('/data_laba_grosir', 'PenjualanGrosir::data_laba_grosir', ['filter' => 'role:Admin,Bos']);
$routes->post('/tambah_lg', 'PenjualanGrosir::tambah_lg');
$routes->post('/edit_lg', 'PenjualanGrosir::edit_lg');
$routes->post('/hapus_lg/(:num)', 'PenjualanGrosir::hapus_lg/$1');


$routes->get('laba/form', 'PenjualanGrosir::form');
$routes->post('laba/cek', 'PenjualanGrosir::cek');


// ----------

// $routes->get('/stokBarang', 'Admin::stokBarang', ['filter' => 'role:Admin,Bos']);
// $routes->get('/role', 'RoleC::role', ['filter' => 'role:Admin,Bos']);
// // -----------$routes->get('/role', 'RoleC::role');

// $routes->post('/barangBaru', 'Admin::barang_baru', ['filter' => 'role:Admin,Bos']);
// $routes->post('/barang_ubah', 'Admin::barang_ubah', ['filter' => 'role:Admin,Bos']);
// $routes->delete('/hapus_barang/(:num)', 'Admin::hapus_barang/$1', ['filter' => 'role:Admin,Bos']);
// $routes->get('/stokBarangRefresh', 'Admin::stokBarangRefresh', ['filter' => 'role:Admin,Bos']);


// $routes->post('/dollar', 'Admin::dollar', ['filter' => 'role:Admin,Bos']);
// // $routes->get('/supplier', 'Admin::supplier', ['filter' => 'role:Admin,Bos']);
// $routes->get('/suplier', 'Admin::supplier', ['filter' => 'role:Admin,Bos']);
// $routes->post('/supplier_baru', 'Admin::supplier_baru', ['filter' => 'role:Admin,Bos']);
// $routes->post('/supplier_ubah', 'Admin::supplier_ubah', ['filter' => 'role:Admin,Bos']);
// $routes->delete('/hapus_supplier/(:num)', 'Admin::hapus_supplier/$1', ['filter' => 'role:Admin,Bos']);



// $routes->get('/data_supplier', 'Admin::data_supplier', ['filter' => 'role:Admin,Bos']);
// $routes->get('/pembelian', 'Admin::pembelian', ['filter' => 'role:Admin,Bos']);




// $routes->get('/data_supplier_detail/(:segment)/(:segment)/(:num)', 'Admin::data_supplier_detail/$1/$2/$3', ['filter' => 'role:Admin,Bos']);
// $routes->post('/ubah_data_supplier', 'Admin::ubah_data_supplier', ['filter' => 'role:Admin,Bos']);
// $routes->post('/bayar_data_supplier', 'Admin::bayar_data_supplier', ['filter' => 'role:Admin,Bos']);



// $routes->post('/supplier_bayars', 'Admin::supplier_bayar', ['filter' => 'role:Admin,Bos']);
// // $routes->post('/supplier_bayar', 'Admin::supplier_bayar', ['filter' => 'role:Admin,Bos']);
// $routes->get('/detail_bayar/(:segment)/(:num)', 'Admin::detail_bayar/$1/$2', ['filter' => 'role:Admin,Bos']);

// $routes->post('/detail_bayar_ubah_hutang', 'Admin::detail_bayar_ubah_hutang', ['filter' => 'role:Admin,Bos']);
// $routes->post('/perbaiki/(:num)', 'Admin::perbaiki/$1', ['filter' => 'role:Admin,Bos']);
// $routes->delete('/hapus_bayar_supplier/(:num)', 'Admin::hapus_bayar_supplier/$1', ['filter' => 'role:Admin,Bos']);

// $routes->post('/detail_bayar_ubah_piutang', 'Admin::detail_bayar_ubah_piutang', ['filter' => 'role:Admin,Bos']);

// // -----------------------
// $routes->post('/supplier_produk', 'Admin::supplier_produk', ['filter' => 'role:Admin,Bos']);
// $routes->post('/supplier_produk_ubah', 'Admin::supplier_produk_ubah', ['filter' => 'role:Admin,Bos']);
// $routes->delete('/hapus_produk_supplier/(:num)', 'Admin::hapus_produk_supplier/$1', ['filter' => 'role:Admin,Bos']);
// $routes->post('/kirim', 'Admin::kirim', ['filter' => 'role:Admin,Bos']);


// $routes->get('/detail_produks/(:segment)/(:num)', 'Admin::detail_produks/$1/$2', ['filter' => 'role:Admin,Bos']);

// ---------------$routes->get('/labaG', 'Admin::labaG', ['filter' => 'role:Admin,Bos']);
// ---------------------------
// $routes->get('/grosir', 'Admin::grosir', ['filter' => 'role:Admin,Bos']);
// $routes->post('/jual_PG', 'Admin::jual_PG', ['filter' => 'role:Admin,Bos']);
// // --------
// $routes->get('/dp_grosir', 'Admin::dp_grosir', ['filter' => 'role:Admin,Bos']);
// $routes->get('/detail_dp_grosir/(:segment)/(:segment)/(:num)', 'Admin::detail_dp_grosir/$1/$2/$3', ['filter' => 'role:Admin,Bos']);
// $routes->post('/ubah_jual_PG', 'Admin::ubah_jual_PG', ['filter' => 'role:Admin,Bos']);

// $routes->post('/bayar_jual_PG', 'Admin::bayar_jual_PG', ['filter' => 'role:Admin,Bos']);
// $routes->post('/UpdateStok', 'Admin::UpdateStok', ['filter' => 'role:Admin,Bos']);


// -----------




$routes->get('/setPaketGrosir', 'Admin::setPaketGrosir', ['filter' => 'role:Admin,Bos']);
$routes->post('/setPaketGrosirBaru', 'Admin::setPaketGrosirBaru', ['filter' => 'role:Admin,Bos']);
$routes->post('/setPaketGrosirUbah', 'Admin::setPaketGrosirUbah', ['filter' => 'role:Admin,Bos']);
$routes->delete('/hapus_setPaketGrosir/(:num)', 'Admin::hapus_setPaketGrosir/$1', ['filter' => 'role:Admin,Bos']);







$routes->get('/pengguna', 'Admin::pengguna', ['filter' => 'role:Admin,Bos']);
$routes->put('/detPegawai/(:num)', 'Admin::detPegawai/$1', ['filter' => 'role:Admin,Bos']);
$routes->get('/detPegawai/(:num)', 'Admin::detPegawai/$1', ['filter' => 'role:Admin,Bos']);
$routes->post('/detPegawai/update/(:num)', 'Admin::detPegawaiUpdate/$1', ['filter' => 'role:admin,pegawai,bos']);




$routes->get('/absen', 'presensi::presensi',  ['filter' => 'role:Admin,Bos']);
$routes->post('/simpanPresensi', 'presensi::simpanPresensi');
$routes->post('/waktuSetPresensi', 'presensi::waktuSetPresensi',  ['filter' => 'role:Admin,Bos']);
$routes->delete('/hapus_presensi/(:num)/(:segment)', 'presensi::hapus_presensi/$1/$2', ['filter' => 'role:Admin,Bos']);
$routes->delete('/cek_presensi/(:num)/(:segment)/(:num)', 'presensi::cek_presensi/$1/$2/$3', ['filter' => 'role:Admin,Bos']);
$routes->post('/gaji', 'presensi::gaji');
