<?php
/** @var mysqli $koneksi */
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'read';

if ($aksi == 'hapus') {
    $id = $_GET['id'];
    mysqli_query($koneksi, "DELETE FROM tb_spp WHERE id_spp='$id'");
    echo "<script>alert('Data dihapus!'); window.location='?page=spp';</script>";
}

if (isset($_POST['simpan'])) {
    $id_spp = $_POST['id_spp'];
    $tahun = $_POST['tahun'];
    $nominal = $_POST['nominal'];

    if ($_GET['aksi'] == 'tambah') {
        mysqli_query($koneksi, "INSERT INTO tb_spp (id_spp, tahun, nominal) VALUES ('$id_spp', '$tahun', '$nominal')");
    } else {
        mysqli_query($koneksi, "UPDATE tb_spp SET tahun='$tahun', nominal='$nominal' WHERE id_spp='$id_spp'");
    }
    echo "<script>alert('Data disimpan!'); window.location='?page=spp';</script>";
}

if ($aksi == 'tambah' || $aksi == 'edit'):
    $edit = null;
    if ($aksi == 'edit') {
        $id = $_GET['id'];
        $edit = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM tb_spp WHERE id_spp='$id'"));
    }
?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-primary-custom mb-0"><?= $aksi == 'tambah' ? 'Tambah' : 'Edit' ?> Data SPP</h3>
        <a href="?page=spp" class="btn btn-outline-secondary">Kembali</a>
    </div>
    <div class="card border-0 shadow-sm col-md-6">
        <div class="card-body">
            <form method="POST" action="?page=spp&aksi=<?= $aksi ?>">
                <div class="mb-3">
                    <label class="form-label fw-bold">ID SPP</label>
                    <input type="text" name="id_spp" class="form-control" value="<?= $edit['id_spp'] ?? '' ?>" required <?= $aksi == 'edit' ? 'readonly' : '' ?> placeholder="SPP001">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Tahun</label>
                    <input type="number" name="tahun" class="form-control" value="<?= $edit['tahun'] ?? '' ?>" required placeholder="2024">
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold">Nominal (Rp)</label>
                    <input type="number" name="nominal" class="form-control" value="<?= $edit['nominal'] ?? '' ?>" required>
                </div>
                <button type="submit" name="simpan" class="btn bg-primary-custom text-white w-100">Simpan Data</button>
            </form>
        </div>
    </div>
<?php else: ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-primary-custom mb-0">Data SPP</h3>
        <a href="?page=spp&aksi=tambah" class="btn bg-primary-custom text-white"><i class="fa-solid fa-plus"></i> Tambah</a>
    </div>
    <div class="card border-0 shadow-sm p-3">
        <table class="table table-hover">
            <thead class="bg-primary-custom"><tr><th>ID SPP</th><th>Tahun</th><th>Nominal</th><th>Aksi</th></tr></thead>
            <tbody>
                <?php
                $q = mysqli_query($koneksi, "SELECT * FROM tb_spp");
                while($r = mysqli_fetch_assoc($q)): ?>
                <tr>
                    <td><?= $r['id_spp'] ?></td><td><?= $r['tahun'] ?></td><td>Rp <?= number_format($r['nominal'],0,',','.') ?></td>
                    <td>
                        <a href="?page=spp&aksi=edit&id=<?= $r['id_spp'] ?>" class="btn btn-sm btn-info text-white"><i class="fa-solid fa-pen"></i></a>
                        <a href="?page=spp&aksi=hapus&id=<?= $r['id_spp'] ?>" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>