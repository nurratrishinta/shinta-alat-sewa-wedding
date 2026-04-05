<?php
include '../../partials/header.php';
include '../../partials/sidenav.php';
include '../../partials/navbar.php';
require_once __DIR__ . '/../../../config/connection.php';

// Pastikan ID adalah angka untuk mencegah SQL Injection sederhana
$id = (int)($_GET['id'] ?? 0);

$query = mysqli_query($connect, "SELECT * FROM peminjaman WHERE id_pinjam = $id");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "<div class='alert alert-danger'>Data peminjaman tidak ditemukan!</div>";
    include '../../partials/footer.php';
    exit;
}
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5>Ubah Data Peminjaman</h5>
            </div>

            <div class="card-body">
                <form method="POST" action="../../actions/peminjaman/update.php">
                    <input type="hidden" name="id_pinjam" value="<?= $data['id_pinjam'] ?>">

                    <div class="mb-3">
                        <label class="form-label">Alamat Peminjam</label>
                        <textarea
                            name="alamat_peminjam"
                            class="form-control"
                            required><?= htmlspecialchars($data['alamat_peminjam'] ?? '') ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jumlah Pinjam</label>
                        <input
                            type="number"
                            name="jumlah_pinjam"
                            class="form-control"
                            value="<?= $data['jumlah_pinjam'] ?>"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Pinjam</label>
                        <input
                            type="date"
                            name="tgl_pinjam"
                            class="form-control"
                            value="<?= $data['tgl_pinjam'] ?>"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Kembali</label>
                        <input
                            type="date"
                            name="tgl_kembali"
                            class="form-control"
                            value="<?= $data['tgl_kembali'] ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nomor Telepon</label>
                        <input
                            type="text"
                            name="no_telepon"
                            class="form-control"
                            value="<?= htmlspecialchars($data['no_telepon'] ?? '') ?>"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Total Harga</label>
                        <input
                            type="number"
                            name="total_harga"
                            class="form-control"
                            value="<?= $data['total_harga'] ?>"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status Pembayaran</label>
                        <select name="status_pembayaran" class="form-control">
                            <option value="Belum Bayar" <?= ($data['status_pembayaran'] ?? '') == 'Belum Bayar' ? 'selected' : '' ?>>
                                Belum Bayar
                            </option>
                            <option value="Sudah Lunas" <?= ($data['status_pembayaran'] ?? '') == 'Sudah Lunas' ? 'selected' : '' ?>>
                                Sudah Lunas
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status Peminjaman</label>
                        <select name="status" class="form-control">
                            <option value="Menunggu" <?= ($data['status'] ?? '') == 'Menunggu' ? 'selected' : '' ?>>Menunggu</option>
                            <option value="Dipinjam" <?= ($data['status'] ?? '') == 'Dipinjam' ? 'selected' : '' ?>>Dipinjam</option>
                            <option value="Selesai" <?= ($data['status'] ?? '') == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                            <option value="Dibatalkan" <?= ($data['status'] ?? '') == 'Dibatalkan' ? 'selected' : '' ?>>Dibatalkan</option>
                        </select>
                    </div>

                    <hr>
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="./index.php" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include '../../partials/footer.php';
include '../../partials/script.php';
?>