<?php
/** @var mysqli $koneksi */
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'read';

if ($aksi == 'hapus') {
    $id = $_GET['id'];
    mysqli_query($koneksi, "DELETE FROM tb_siswa WHERE nisn='$id'");
    echo "<script>alert('Data dihapus!'); window.location='?page=siswa';</script>";
}

if (isset($_POST['simpan'])) {
    $nisn = $_POST['nisn'];
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $id_kelas = $_POST['id_kelas'];
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];
    $id_spp = $_POST['id_spp'];

    // Ambil nama_kelas berdasarkan id_kelas
    $q_kls = mysqli_query($koneksi, "SELECT nama_kelas FROM tb_kelas WHERE id_kelas='$id_kelas'");
    $d_kls = mysqli_fetch_assoc($q_kls);
    $nama_kelas = $d_kls['nama_kelas'];

    if ($_GET['aksi'] == 'tambah') {
        mysqli_query($koneksi, "INSERT INTO tb_siswa (nisn, nis, nama, id_kelas, nama_kelas, alamat, no_telp, id_spp) VALUES ('$nisn', '$nis', '$nama', '$id_kelas', '$nama_kelas', '$alamat', '$no_telp', '$id_spp')");
    } else {
        mysqli_query($koneksi, "UPDATE tb_siswa SET nis='$nis', nama='$nama', id_kelas='$id_kelas', nama_kelas='$nama_kelas', alamat='$alamat', no_telp='$no_telp', id_spp='$id_spp' WHERE nisn='$nisn'");
    }
    echo "<script>alert('Data disimpan!'); window.location='?page=siswa';</script>";
}

if ($aksi == 'tambah' || $aksi == 'edit'):
    $edit = null;
    if ($aksi == 'edit') {
        $id = $_GET['id'];
        $edit = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM tb_siswa WHERE nisn='$id'"));
    }
?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-primary-custom mb-0"><?= $aksi == 'tambah' ? 'Tambah' : 'Edit' ?> Data Siswa</h3>
        <a href="?page=siswa" class="btn btn-outline-secondary">Kembali</a>
    </div>
    <div class="card border-0 shadow-sm col-md-8">
        <div class="card-body">
            <form method="POST" action="?page=siswa&aksi=<?= $aksi ?>">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">NISN</label>
                        <input type="text" name="nisn" class="form-control" value="<?= $edit['nisn'] ?? '' ?>" required <?= $aksi == 'edit' ? 'readonly' : '' ?>>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">NIS</label>
                        <input type="text" name="nis" class="form-control" value="<?= $edit['nis'] ?? '' ?>" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" value="<?= $edit['nama'] ?? '' ?>" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Pilih Kelas</label>
                        <select name="id_kelas" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            <?php 
                            $q_k = mysqli_query($koneksi, "SELECT * FROM tb_kelas");
                            while($k = mysqli_fetch_assoc($q_k)):
                            ?>
                            <option value="<?= $k['id_kelas'] ?>" <?= (isset($edit['id_kelas']) && $edit['id_kelas'] == $k['id_kelas']) ? 'selected' : '' ?>><?= $k['nama_kelas'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">No. Telp</label>
                        <input type="text" name="no_telp" class="form-control" value="<?= $edit['no_telp'] ?? '' ?>" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="2" required><?= $edit['alamat'] ?? '' ?></textarea>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold">Tarif SPP (ID SPP)</label>
                    <select name="id_spp" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        <?php 
                        $q_s = mysqli_query($koneksi, "SELECT * FROM tb_spp");
                        while($s = mysqli_fetch_assoc($q_s)):
                        ?>
                        <option value="<?= $s['id_spp'] ?>" <?= (isset($edit['id_spp']) && $edit['id_spp'] == $s['id_spp']) ? 'selected' : '' ?>><?= $s['tahun'] ?> - Rp <?= number_format($s['nominal'],0,',','.') ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <button type="submit" name="simpan" class="btn bg-primary-custom text-white w-100">Simpan Data</button>
            </form>
        </div>
    </div>
<?php else: ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-primary-custom mb-0">Data Siswa</h3>
        <a href="?page=siswa&aksi=tambah" class="btn bg-primary-custom text-white"><i class="fa-solid fa-plus"></i> Tambah</a>
    </div>
    <div class="card border-0 shadow-sm p-3 table-responsive">
        <table class="table table-hover">
            <thead class="bg-primary-custom"><tr><th>NISN</th><th>Nama</th><th>Kelas</th><th>Telp</th><th>Aksi</th></tr></thead>
            <tbody>
                <?php
                $q = mysqli_query($koneksi, "SELECT * FROM tb_siswa");
                while($r = mysqli_fetch_assoc($q)): ?>
                <tr>
                    <td><?= $r['nisn'] ?></td><td class="fw-bold"><?= $r['nama'] ?></td><td><?= $r['nama_kelas'] ?></td><td><?= $r['no_telp'] ?></td>
                    <td>
                        <a href="?page=siswa&aksi=edit&id=<?= $r['nisn'] ?>" class="btn btn-sm btn-info text-white"><i class="fa-solid fa-pen"></i></a>
                        <a href="?page=siswa&aksi=hapus&id=<?= $r['nisn'] ?>" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>