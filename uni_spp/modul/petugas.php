<?php
/** @var mysqli $koneksi */
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'read';

if ($aksi == 'hapus') {
    $id = $_GET['id'];
    mysqli_query($koneksi, "DELETE FROM tb_petugas WHERE id_petugas='$id'");
    echo "<script>alert('Data dihapus!'); window.location='?page=petugas';</script>";
}

if (isset($_POST['simpan'])) {
    $id_petugas = $_POST['id_petugas'];
    $username = $_POST['username'];
    $nama_petugas = $_POST['nama_petugas'];
    $level = $_POST['level'];

    if ($_GET['aksi'] == 'tambah') {
        $password = ($_POST['password']);
        mysqli_query($koneksi, "INSERT INTO tb_petugas (id_petugas, username, password, nama_petugas, level) VALUES ('$id_petugas', '$username', '$password', '$nama_petugas', '$level')");
    } else {
        if (!empty($_POST['password'])) {
            $password = ($_POST['password']);
            mysqli_query($koneksi, "UPDATE tb_petugas SET username='$username', password='$password', nama_petugas='$nama_petugas', level='$level' WHERE id_petugas='$id_petugas'");
        } else {
            mysqli_query($koneksi, "UPDATE tb_petugas SET username='$username', nama_petugas='$nama_petugas', level='$level' WHERE id_petugas='$id_petugas'");
        }
    }
    echo "<script>alert('Data disimpan!'); window.location='?page=petugas';</script>";
}

if ($aksi == 'tambah' || $aksi == 'edit'):
    $edit = null;
    if ($aksi == 'edit') {
        $id = $_GET['id'];
        $edit = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM tb_petugas WHERE id_petugas='$id'"));
    }
?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-primary-custom mb-0"><?= $aksi == 'tambah' ? 'Tambah' : 'Edit' ?> Data Petugas</h3>
        <a href="?page=petugas" class="btn btn-outline-secondary">Kembali</a>
    </div>
    <div class="card border-0 shadow-sm col-md-6">
        <div class="card-body">
            <form method="POST" action="?page=petugas&aksi=<?= $aksi ?>">
                <div class="mb-3">
                    <label class="form-label fw-bold">ID Petugas</label>
                    <input type="text" name="id_petugas" class="form-control" value="<?= $edit['id_petugas'] ?? '' ?>" required <?= $aksi == 'edit' ? 'readonly' : '' ?> placeholder="PTG002">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Petugas</label>
                    <input type="text" name="nama_petugas" class="form-control" value="<?= $edit['nama_petugas'] ?? '' ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Username</label>
                    <input type="text" name="username" class="form-control" value="<?= $edit['username'] ?? '' ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Password</label>
                    <input type="password" name="password" class="form-control" <?= $aksi == 'tambah' ? 'required' : '' ?> placeholder="<?= $aksi == 'edit' ? 'Kosongkan jika tak ingin ganti' : '' ?>">
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold">Level</label>
                    <select name="level" class="form-select" required>
                        <option value="admin" <?= (isset($edit['level']) && $edit['level'] == 'admin') ? 'selected' : '' ?>>Admin</option>
                        <option value="petugas" <?= (isset($edit['level']) && $edit['level'] == 'petugas') ? 'selected' : '' ?>>Petugas</option>
                        <option value="siswa" <?= (isset($edit['level']) && $edit['level'] == 'siswa') ? 'selected' : '' ?>>Siswa</option>
                    </select>
                </div>
                <button type="submit" name="simpan" class="btn bg-primary-custom text-white w-100">Simpan Data</button>
            </form>
        </div>
    </div>
<?php else: ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-primary-custom mb-0">Data Petugas</h3>
        <a href="?page=petugas&aksi=tambah" class="btn bg-primary-custom text-white"><i class="fa-solid fa-plus"></i> Tambah</a>
    </div>
    <div class="card border-0 shadow-sm p-3">
        <table class="table table-hover">
            <thead class="bg-primary-custom"><tr><th>ID</th><th>Nama</th><th>Username</th><th>Level</th><th>Aksi</th></tr></thead>
            <tbody>
                <?php
                $q = mysqli_query($koneksi, "SELECT * FROM tb_petugas");
                while($r = mysqli_fetch_assoc($q)): ?>
                <tr>
                    <td><?= $r['id_petugas'] ?></td><td><?= $r['nama_petugas'] ?></td><td><?= $r['username'] ?></td><td><?= strtoupper($r['level']) ?></td>
                    <td>
                        <a href="?page=petugas&aksi=edit&id=<?= $r['id_petugas'] ?>" class="btn btn-sm btn-info text-white"><i class="fa-solid fa-pen"></i></a>
                        <a href="?page=petugas&aksi=hapus&id=<?= $r['id_petugas'] ?>" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>