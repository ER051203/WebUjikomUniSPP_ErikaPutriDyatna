<div id="sidebar-wrapper" class="shadow">
    <div class="sidebar-heading text-center text-white">
        <i class="fa-solid fa-building-columns mb-2 fs-1"></i><br>UNI SPP
    </div>
    <div class="list-group list-group-flush mt-3">
        <a href="?page=dashboard" class="list-group-item list-group-item-action <?= (!isset($_GET['page']) || $_GET['page'] == 'dashboard') ? 'active' : '' ?>">
            <i class="fa-solid fa-gauge me-2"></i> Dashboard
        </a>
        
        <?php if($_SESSION['level'] == 'admin'): ?>
        <a href="?page=petugas" class="list-group-item list-group-item-action <?= (isset($_GET['page']) && $_GET['page'] == 'petugas') ? 'active' : '' ?>">
            <i class="fa-solid fa-user-tie me-2"></i> Data Petugas
        </a>
        <a href="?page=kelas" class="list-group-item list-group-item-action <?= (isset($_GET['page']) && $_GET['page'] == 'kelas') ? 'active' : '' ?>">
            <i class="fa-solid fa-door-open me-2"></i> Data Kelas
        </a>
        <a href="?page=spp" class="list-group-item list-group-item-action <?= (isset($_GET['page']) && $_GET['page'] == 'spp') ? 'active' : '' ?>">
            <i class="fa-solid fa-money-bill-wave me-2"></i> Data SPP
        </a>
        <?php endif; ?>

        <a href="?page=siswa" class="list-group-item list-group-item-action <?= (isset($_GET['page']) && $_GET['page'] == 'siswa') ? 'active' : '' ?>">
            <i class="fa-solid fa-user-graduate me-2"></i> Data Siswa
        </a>
        <a href="?page=pembayaran" class="list-group-item list-group-item-action <?= (isset($_GET['page']) && $_GET['page'] == 'pembayaran') ? 'active' : '' ?>">
            <i class="fa-solid fa-file-invoice-dollar me-2"></i> Transaksi
        </a>
        <a href="?page=cek_pembayaran" class="list-group-item list-group-item-action <?= (isset($_GET['page']) && $_GET['page'] == 'cek_pembayaran') ? 'active' : '' ?>">
            <i class="fa-solid fa-clipboard-check me-2"></i> Cek Pembayaran
        </a>
    </div>
</div>