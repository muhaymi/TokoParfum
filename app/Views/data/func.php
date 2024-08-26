<?php

$this->extend('layout/template');
$this->section('content');

function titik($number)
{
    return number_format($number, 0, '', '.');
}

function terbilang($number)
{
    $satuan = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];

    function toWords($num, $satuan)
    {
        if ($num < 12) {
            return $satuan[$num];
        } elseif ($num < 20) {
            return $satuan[$num - 10] . " Belas";
        } elseif ($num < 100) {
            return $satuan[floor($num / 10)] . " Puluh " . $satuan[$num % 10];
        } elseif ($num < 200) {
            return "Seratus " . toWords($num - 100, $satuan);
        } elseif ($num < 1000) {
            return $satuan[floor($num / 100)] . " Ratus " . toWords($num % 100, $satuan);
        } elseif ($num < 2000) {
            return "Seribu " . toWords($num - 1000, $satuan);
        } elseif ($num < 1000000) {
            return toWords(floor($num / 1000), $satuan) . " Ribu " . toWords($num % 1000, $satuan);
        } elseif ($num < 1000000000) {
            return toWords(floor($num / 1000000), $satuan) . " Juta " . toWords($num % 1000000, $satuan);
        } elseif ($num < 1000000000000) {
            return toWords(floor($num / 1000000000), $satuan) . " Milyar " . toWords($num % 1000000000, $satuan);
        } elseif ($num < 1000000000000000) {
            return toWords(floor($num / 1000000000000), $satuan) . " Triliun " . toWords($num % 1000000000000, $satuan);
        } else {
            return "Angka terlalu besar";
        }
    }

    return toWords($number, $satuan) . " Rupiah";
}



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

<?php
function kasir($usr, $ksr)
{
    foreach ($usr as $u) {
        if ($ksr == $u['id']) {
            return $u['username'];
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

$this->endSection(); ?>