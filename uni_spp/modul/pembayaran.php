<?php
/** @var mysqli $koneksi */
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'read';

if ($aksi == 'hapus') {
    $id = $_GET['id'];
    mysqli_query($koneksi, "DELETE FROM tb_pembayaran WHERE id_pembayaran='$id'");
    echo "<script>alert('Data terhapus!'); window.location='?page=pembayaran';</script>";
}

if (isset($_POST['simpan'])) {
    $id_pembayaran = $_POST['id_pembayaran'];
    $nisn = $_POST['nisn'];
    $status = $_POST['status'];
    $tgl_bayar = $_POST['tgl_bayar'];
    $tgl_terakhir_bayar = $_POST['tgl_terakhir_bayar'];
    $batas_pembayaran = $_POST['batas_pembayaran'];
    $jumlah_bulan = $_POST['jumlah_bulan'];
    $nominal_bayar = $_POST['nominal_bayar'];
    $jumlah_bayar = $_POST['jumlah_bayar'];
    $kembalian = (int)$jumlah_bayar - (int)$nominal_bayar; 

    $q_spp = mysqli_query($koneksi, "SELECT id_spp FROM tb_siswa WHERE nisn='$nisn'");
    $d_spp = mysqli_fetch_assoc($q_spp);
    $id_spp = $d_spp['id_spp'];

    $cek_id = mysqli_query($koneksi, "SELECT * FROM tb_pembayaran WHERE id_pembayaran='$id_pembayaran'");
    
    if (mysqli_num_rows($cek_id) == 0 && $_GET['aksi'] == 'tambah') {
        mysqli_query($koneksi, "INSERT INTO tb_pembayaran (id_pembayaran, status, nisn, tgl_bayar, tgl_terakhir_bayar, batas_pembayaran, jumlah_bulan, id_spp, nominal_bayar, jumlah_bayar, kembalian) 
        VALUES ('$id_pembayaran', '$status', '$nisn', '$tgl_bayar', '$tgl_terakhir_bayar', '$batas_pembayaran', '$jumlah_bulan', '$id_spp', '$nominal_bayar', '$jumlah_bayar', '$kembalian')");
    } else {
        mysqli_query($koneksi, "UPDATE tb_pembayaran SET status='$status', nisn='$nisn', tgl_bayar='$tgl_bayar', tgl_terakhir_bayar='$tgl_terakhir_bayar', batas_pembayaran='$batas_pembayaran', jumlah_bulan='$jumlah_bulan', nominal_bayar='$nominal_bayar', jumlah_bayar='$jumlah_bayar', kembalian='$kembalian' 
        WHERE id_pembayaran='$id_pembayaran'");
    }
    echo "<script>alert('Transaksi berhasil disimpan!'); window.location='?page=pembayaran';</script>";
}

if ($aksi == 'tambah' || $aksi == 'edit'):
    $edit = null;
    if ($aksi == 'edit') {
        $id = $_GET['id'];
        $edit = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM tb_pembayaran WHERE id_pembayaran='$id'"));
    }
?>
    <div class="d-flex justify-content-between mb-4">
        <h3 class="text-primary-custom fw-bold"><?= $aksi == 'tambah' ? 'Input' : 'Edit' ?> Pembayaran</h3>
        <a href="?page=pembayaran" class="btn btn-secondary">Kembali</a>
    </div>
    <div class="card shadow-sm col-md-8">
        <div class="card-body">
            <form method="POST" action="?page=pembayaran&aksi=<?= $aksi ?>">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">ID Pembayaran</label>
                        <input type="text" name="id_pembayaran" class="form-control" value="<?= $edit['id_pembayaran'] ?? 'TRX'.time() ?>" <?= $aksi == 'edit' ? 'readonly' : '' ?> required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Siswa (NISN)</label>
                        <select name="nisn" class="form-select" required>
                            <option value="">Pilih Siswa</option>
                            <?php 
                            $q_siswa = mysqli_query($koneksi, "SELECT nisn, nama FROM tb_siswa");
                            while($s = mysqli_fetch_assoc($q_siswa)):
                            ?>
                            <option value="<?= $s['nisn'] ?>" <?= (isset($edit['nisn']) && $edit['nisn'] == $s['nisn']) ? 'selected' : '' ?>><?= $s['nisn'] ?> - <?= $s['nama'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4 mb-3"><label>Tgl Bayar</label><input type="date" name="tgl_bayar" class="form-control" value="<?= $edit['tgl_bayar'] ?? date('Y-m-d') ?>" required></div>
                    <div class="col-md-4 mb-3"><label>Tgl Terakhir Bayar</label><input type="date" name="tgl_terakhir_bayar" class="form-control" value="<?= $edit['tgl_terakhir_bayar'] ?? '' ?>" required></div>
                    <div class="col-md-4 mb-3"><label>Batas Pembayaran</label><input type="date" name="batas_pembayaran" class="form-control" value="<?= $edit['batas_pembayaran'] ?? '' ?>" required></div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3"><label>Jml Bulan</label><input type="text" name="jumlah_bulan" class="form-control" value="<?= $edit['jumlah_bulan'] ?? '1' ?>" required></div>
                    <div class="col-md-4 mb-3"><label>Nominal Tagihan</label><input type="text" name="nominal_bayar" class="form-control" value="<?= $edit['nominal_bayar'] ?? '' ?>" required></div>
                    <div class="col-md-4 mb-3"><label>Uang Diterima</label><input type="text" name="jumlah_bayar" class="form-control" value="<?= $edit['jumlah_bayar'] ?? '' ?>" required></div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Status Lunas</label>
                    <select name="status" class="form-select" required>
                        <option value="Belum Lunas" <?= (isset($edit['status']) && $edit['status'] == 'Belum Lunas') ? 'selected' : '' ?>>Belum Lunas</option>
                        <option value="Sudah Lunas" <?= (isset($edit['status']) && $edit['status'] == 'Sudah Lunas') ? 'selected' : '' ?>>Sudah Lunas</option>
                    </select>
                </div>
                <button type="submit" name="simpan" class="btn bg-primary-custom text-white w-100">Simpan Transaksi</button>
            </form>
        </div>
    </div>

<?php else: ?>
    <div class="d-flex justify-content-between mb-4">
        <h3 class="text-primary-custom fw-bold">Data Transaksi</h3>
        <a href="?page=pembayaran&aksi=tambah" class="btn bg-primary-custom text-white"><i class="fa-solid fa-plus me-1"></i> Transaksi Baru</a>
    </div>
    <div class="card shadow-sm table-responsive p-3">
        <table class="table table-hover align-middle">
            <thead class="bg-primary-custom">
                <tr><th>ID Trx</th><th>NISN</th><th>Tanggal</th><th>Status</th><th>Tagihan</th><th>Kembalian</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                <?php
                $query = mysqli_query($koneksi, "SELECT * FROM tb_pembayaran ORDER BY tgl_bayar DESC");
                if(mysqli_num_rows($query) > 0){ while($row = mysqli_fetch_assoc($query)): ?>
                <tr>
                    <td class="fw-bold"><?= $row['id_pembayaran']; ?></td>
                    <td><?= $row['nisn']; ?></td>
                    <td><?= date('d/m/Y', strtotime($row['tgl_bayar'])); ?></td>
                    <td><span class="badge <?= $row['status'] == 'Sudah Lunas' ? 'bg-success' : 'bg-warning text-dark' ?>"><?= $row['status'] ?></span></td>
                    <td>Rp <?= number_format($row['nominal_bayar'],0,',','.'); ?></td>
                    <td>Rp <?= number_format($row['kembalian'],0,',','.'); ?></td>
                    <td>
                        <a href="cetak.php?id=<?= $row['id_pembayaran'] ?>" target="_blank" class="btn btn-sm btn-success"><i class="fa-solid fa-print"></i></a>
                        <a href="?page=pembayaran&aksi=edit&id=<?= $row['id_pembayaran'] ?>" class="btn btn-sm btn-info text-white"><i class="fa-solid fa-pen"></i></a>
                        <a href="?page=pembayaran&aksi=hapus&id=<?= $row['id_pembayaran'] ?>" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>
                <?php endwhile; } else { echo "<tr><td colspan='7' class='text-center'>Data kosong.</td></tr>"; } ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>