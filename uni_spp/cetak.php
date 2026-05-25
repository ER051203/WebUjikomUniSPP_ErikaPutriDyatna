<?php
session_start();
include 'config/koneksi.php';

if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) { exit; }

$id = $_GET['id'];
$q = mysqli_query($koneksi, "SELECT p.*, s.nama, k.nama_kelas FROM tb_pembayaran p JOIN tb_siswa s ON p.nisn=s.nisn JOIN tb_kelas k ON s.id_kelas=k.id_kelas WHERE p.id_pembayaran='$id'");
$data = mysqli_fetch_assoc($q);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Pembayaran <?= $data['id_pembayaran'] ?></title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; color: #333; background: #fff; margin:0; padding: 20px;}
        .struk { max-width: 400px; margin: 0 auto; border: 1px dashed #000; padding: 20px; }
        .text-center { text-align: center; }
        .fw-bold { font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        td { padding: 4px 0; font-size: 14px;}
        hr { border-top: 1px dashed #000; margin: 15px 0; }
        @media print { .struk { border: none; width: 100%; max-width: 100%; padding:0;} }
    </style>
</head>
<body onload="window.print()">
    <div class="struk">
        <div class="text-center">
            <h3 class="fw-bold" style="margin:0;">UNI SPP</h3>
            <p style="margin:5px 0;">Bukti Pembayaran SPP</p>
        </div>
        <hr>
        <table>
            <tr><td width="40%">ID Transaksi</td><td>: <?= $data['id_pembayaran'] ?></td></tr>
            <tr><td>Tgl Bayar</td><td>: <?= date('d-m-Y', strtotime($data['tgl_bayar'])) ?></td></tr>
            <tr><td>NISN / Nama</td><td>: <?= $data['nisn'] ?> / <?= $data['nama'] ?></td></tr>
            <tr><td>Kelas</td><td>: <?= $data['nama_kelas'] ?></td></tr>
            <tr><td>Status</td><td>: <?= strtoupper($data['status']) ?></td></tr>
        </table>
        <hr>
        <table>
            <tr><td>Nominal Tagihan</td><td style="text-align: right;">Rp <?= number_format($data['nominal_bayar'],0,',','.') ?></td></tr>
            <tr><td>Jumlah Dibayar</td><td style="text-align: right;">Rp <?= number_format($data['jumlah_bayar'],0,',','.') ?></td></tr>
            <tr><td class="fw-bold">Kembalian</td><td class="fw-bold" style="text-align: right;">Rp <?= number_format($data['kembalian'],0,',','.') ?></td></tr>
        </table>
        <hr>
        <div class="text-center" style="margin-top: 30px;">
            <p>Admin / Petugas</p>
            <br><br>
            <p class="fw-bold">( <?= $_SESSION['nama_petugas'] ?> )</p>
        </div>
    </div>
</body>
</html>