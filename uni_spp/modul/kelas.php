<?php
/** @var mysqli $koneksi */
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'read';
// ... baris kode selanjutnya ...
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'read';

if ($aksi == 'hapus') {
    $id = $_GET['id'];
    mysqli_query($koneksi, "DELETE FROM tb_kelas WHERE id_kelas='$id'");
    echo "<script>alert('Data dihapus!'); window.location='?page=kelas';</script>";
}

if (isset($_POST['simpan'])) {
    $id_kelas = $_POST['id_kelas'];
    $nama_kelas = $_POST['nama_kelas'];
    $komp_keahlian = $_POST['komp_keahlian'];

    if ($_GET['aksi'] == 'tambah') {
        mysqli_query($koneksi, "INSERT INTO tb_kelas (id_kelas, nama_kelas, komp_keahlian) VALUES ('$id_kelas', '$nama_kelas', '$komp_keahlian')");
    } else {
        mysqli_query($koneksi, "UPDATE tb_kelas SET nama_kelas='$nama_kelas', komp_keahlian='$komp_keahlian' WHERE id_kelas='$id_kelas'");
    }
    echo "<script>alert('Data disimpan!'); window.location='?page=kelas';</script>";
}

if ($aksi == 'tambah' || $aksi == 'edit'):
    $edit = null;
    if ($aksi == 'edit') {
        $id = $_GET['id'];
        $edit = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM tb_kelas WHERE id_kelas='$id'"));
    }
?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-primary-custom mb-0"><?= $aksi == 'tambah' ? 'Tambah' : 'Edit' ?> Data Kelas</h3>
        <a href="?page=kelas" class="btn btn-outline-secondary">Kembali</a>
    </div>
    <div class="card border-0 shadow-sm col-md-6">
        <div class="card-body">
            <form method="POST" action="?page=kelas&aksi=<?= $aksi ?>">
                <div class="mb-3">
                    <label class="form-label fw-bold">ID Kelas</label>
                    <input type="text" name="id_kelas" class="form-control" value="<?= $edit['id_kelas'] ?? '' ?>" required <?= $aksi == 'edit' ? 'readonly' : '' ?> placeholder="KLS001">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Kelas</label>
                    <input type="text" name="nama_kelas" class="form-control" value="<?= $edit['nama_kelas'] ?? '' ?>" required placeholder="X RPL 1">
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold">Kompetensi Keahlian</label>
                    <input type="text" name="komp_keahlian" class="form-control" value="<?= $edit['komp_keahlian'] ?? '' ?>" required placeholder="Rekayasa Perangkat Lunak">
                </div>
                <button type="submit" name="simpan" class="btn bg-primary-custom text-white w-100">Simpan Data</button>
            </form>
        </div>
    </div>
<?php else: ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-primary-custom mb-0">Data Kelas</h3>
        <a href="?page=kelas&aksi=tambah" class="btn bg-primary-custom text-white"><i class="fa-solid fa-plus"></i> Tambah</a>
    </div>
    <div class="card border-0 shadow-sm p-3">
        <table class="table table-hover">
            <thead class="bg-primary-custom"><tr><th>ID Kelas</th><th>Nama Kelas</th><th>Keahlian</th><th>Aksi</th></tr></thead>
            <tbody>
                <?php
                $q = mysqli_query($koneksi, "SELECT * FROM tb_kelas");
                while($r = mysqli_fetch_assoc($q)): ?>
                <tr>
                    <td><?= $r['id_kelas'] ?></td><td><?= $r['nama_kelas'] ?></td><td><?= $r['komp_keahlian'] ?></td>
                    <td>
                        <a href="?page=kelas&aksi=edit&id=<?= $r['id_kelas'] ?>" class="btn btn-sm btn-info text-white"><i class="fa-solid fa-pen"></i></a>
                        <a href="?page=kelas&aksi=hapus&id=<?= $r['id_kelas'] ?>" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>