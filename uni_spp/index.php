<?php
session_start();
include 'config/koneksi.php';

if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
    header("Location: auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<?php include 'layout/header.php'; ?>
<body>
    <div class="d-flex" id="wrapper">
        <?php include 'layout/sidebar.php'; ?>
        
        <div id="page-content-wrapper" class="w-100">
            <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm px-4 py-3">
                <h4 class="mb-0 text-primary-custom fw-bold">Sistem Informasi UNI SPP</h4>
                <div class="ms-auto d-flex align-items-center">
                    <span class="me-3 text-muted">Halo, <b><?= $_SESSION['nama_petugas']; ?></b></span>
                    <a href="auth/logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
                </div>
            </nav>

            <div class="container-fluid p-4">
                <?php 
                $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
                $file_path = ($page == 'dashboard') ? 'dashboard.php' : "modul/$page.php";

                if (file_exists($file_path)) {
                    include $file_path;
                } else {
                    echo "<div class='alert alert-warning border-0 shadow-sm'>Halaman <b>$page</b> belum dibuat.</div>";
                }
                ?>
            </div>
        </div>
    </div>
    <?php include 'layout/footer.php'; ?>
</body>
</html>