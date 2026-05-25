<?php
/** @var mysqli $koneksi */
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'read';

if ($aksi == 'hapus') {
    $id = $_GET['id'];
    mysqli_query($koneksi, "DELETE FROM cek_pembayaran WHERE id_cek='$id'");
    echo "<script>alert('Data dihapus!'); window.location='?page=cek_pembayaran';</script>";
}

if (isset($_POST['simpan'])) {
    $id_cek = $_POST['id_cek'];
    $nisn = $_POST['nisn'];
    $tgl_sekarang = date('Y-m-d');
    
    // Ambil detail siswa & transaksi terakhir
    $q_s = mysqli_query($koneksi, "SELECT nama, no_telp FROM tb_siswa WHERE nisn='$nisn'");
    $d_s = mysqli_fetch_assoc($q_s);
    
    $q_p = mysqli_query($koneksi, "SELECT tgl_terakhir_bayar, status, jumlah_bulan FROM tb_pembayaran WHERE nisn='$nisn' ORDER BY tgl_bayar DESC LIMIT 1");
    if(mysqli_num_rows($q_p) > 0){
        $d_p = mysqli_fetch_assoc($q_p);
        $tgl_terakhir = $d_p['tgl_terakhir_bayar'];
        $status = $d_p['status'];
        $jml_bulan = $d_p['jumlah_bulan'];
    } else {
        $tgl_terakhir = date('Y-m-d'); $status = 'Belum Lunas'; $jml_bulan = '0';
    }

    if ($_GET['aksi'] == 'tambah') {
        mysqli_query($koneksi, "INSERT INTO cek_pembayaran (nisn, tgl_terakhir_bayar, tgl_sekarang, status_pembayaran, jumlah_bulan, nama, no_telp) VALUES ('$nisn', '$tgl_terakhir', '$tgl_sekarang', '$status', '$jml_bulan', '{$d_s['nama']}', '{$d_s['no_telp']}')");
    }
    echo "<script>alert('Sinkronisasi Cek Pembayaran Berhasil!'); window.location='?page=cek_pembayaran';</script>";
}

if ($aksi == 'tambah'):
?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-primary-custom mb-0">Cek Status Siswa</h3>
        <a href="?page=cek_pembayaran" class="btn btn-outline-secondary">Kembali</a>
    </div>
    <div class="card border-0 shadow-sm col-md-6">
        <div class="card-body">
            <form method="POST" action="?page=cek_pembayaran&aksi=tambah">
                <div class="mb-4">
                    <label class="form-label fw-bold">Pilih Siswa (Berdasarkan NISN)</label>
                    <select name="nisn" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        <?php 
                        $q_siswa = mysqli_query($koneksi, "SELECT nisn, nama FROM tb_siswa");
                        while($s = mysqli_fetch_assoc($q_siswa)):
                        ?>
                        <option value="<?= $s['nisn'] ?>"><?= $s['nisn'] ?> - <?= $s['nama'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <button type="submit" name="simpan" class="btn bg-primary-custom text-white w-100">Jalankan Cek Pembayaran</button>
            </form>
        </div>
    </div>
<?php else: ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-primary-custom mb-0">Riwayat Cek Pembayaran</h3>
        <a href="?page=cek_pembayaran&aksi=tambah" class="btn bg-primary-custom text-white"><i class="fa-solid fa-rotate"></i> Sinkronkan Cek</a>
    </div>
    <div class="card border-0 shadow-sm p-3 table-responsive">
        <table class="table table-hover">
            <thead class="bg-primary-custom"><tr><th>NISN</th><th>Nama</th><th>Tgl Terakhir Bayar</th><th>Status</th><th>Jml Bulan</th><th>Aksi</th></tr></thead>
            <tbody>
                <?php
                $q = mysqli_query($koneksi, "SELECT * FROM cek_pembayaran ORDER BY tgl_sekarang DESC");
                while($r = mysqli_fetch_assoc($q)): ?>
                <tr>
                    <td><?= $r['nisn'] ?></td><td class="fw-bold"><?= $r['nama'] ?></td>
                    <td><?= date('d/m/Y', strtotime($r['tgl_terakhir_bayar'])) ?></td>
                    <td><span class="badge <?= $r['status_pembayaran'] == 'Sudah Lunas' ? 'bg-success' : 'bg-warning text-dark' ?>"><?= $r['status_pembayaran'] ?></span></td>
                    <td><?= $r['jumlah_bulan'] ?></td>
                    <td><a href="?page=cek_pembayaran&aksi=hapus&id=<?= $r['id_cek'] ?>" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></a></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>