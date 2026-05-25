<?php
/** @var mysqli $koneksi */
session_start();
include '../config/koneksi.php';

if (isset($_SESSION['status_login']) && $_SESSION['status_login'] == true) {
    header("Location: ../index.php");
    exit;
}

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = ($_POST['password']); 

    $query = mysqli_query($koneksi, "SELECT * FROM tb_petugas WHERE username='$username' AND password='$password'");
    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);
        $_SESSION['status_login'] = true;
        $_SESSION['id_petugas'] = $data['id_petugas'];
        $_SESSION['nama_petugas'] = $data['nama_petugas'];
        $_SESSION['level'] = $data['level'];
        header("Location: ../index.php");
    } else {
        $error = "Username atau Password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - UNI SPP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #F1F3F6; display: flex; align-items: center; justify-content: center; height: 100vh; }
        .card-login { border: none; border-radius: 10px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); overflow: hidden; }
        .bg-primary-custom { background-color: #0F3460; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card card-login">
                    <div class="card-header text-center bg-primary-custom text-white py-4">
                        <h3 class="mb-0 fw-bold">UNI SPP</h3>
                        <small>Silakan Login</small>
                    </div>
                    <div class="card-body p-4 bg-white">
                        <?php if(isset($error)): ?>
                            <div class="alert alert-danger py-2 text-center"><?= $error ?></div>
                        <?php endif; ?>
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Username</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" name="login" class="btn bg-primary-custom text-white w-100 py-2">LOGIN</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>