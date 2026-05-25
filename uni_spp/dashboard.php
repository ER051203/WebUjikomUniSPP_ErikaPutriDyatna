<?php /** @var mysqli $koneksi */ ?>
<h3 class="text-primary-custom mb-4 fw-bold">Dashboard Overview</h3>
<div class="row">
    <div class="col-md-4">
        <div class="card bg-primary-custom text-white mb-3 shadow-sm border-0 rounded-3">
            <div class="card-body py-4">
                <h5 class="card-title"><i class="fa-solid fa-users me-2"></i> Total Siswa</h5>
                <?php $siswa = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(nisn) as total FROM tb_siswa")); ?>
                <h2 class="mb-0 fw-bold"><?= $siswa['total'] ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-white border-0 shadow-sm mb-3 rounded-3" style="border-left: 5px solid #E94560;">
            <div class="card-body py-4">
                <h5 class="card-title text-primary-custom"><i class="fa-solid fa-file-invoice-dollar me-2"></i> Total Transaksi</h5>
                <?php $transaksi = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(id_pembayaran) as total FROM tb_pembayaran")); ?>
                <h2 class="mb-0 fw-bold"><?= $transaksi['total'] ?></h2>
            </div>
        </div>
    </div>
</div>
<div class="card border-0 shadow-sm mt-3">
    <div class="card-body">
        <h5 class="text-primary-custom">Selamat Datang, <?= $_SESSION['nama_petugas']; ?>!</h5>
        <p class="text-muted mb-0">Anda saat ini login menggunakan hak akses <b><?= strtoupper($_SESSION['level']); ?></b>.</p>
    </div>
</div>