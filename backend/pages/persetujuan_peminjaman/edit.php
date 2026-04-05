<?php
include '../../partials/header.php';
include '../../partials/sidenav.php';
include '../../partials/navbar.php';
require_once __DIR__ . '/../../../config/connection.php';

$id = (int) ($_GET['id'] ?? 0);

$query = mysqli_query($connect, "SELECT * FROM peminjaman WHERE id_pinjam=$id");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Data tidak ditemukan");
}
?>

<div class="card">
    <div class="card-header">
        <h5>Edit Pembayaran</h5>
    </div>

    <div class="card-body">

        <form action="../../actions/peminjaman/update.php" method="POST">

            <input type="hidden" name="id_pinjam" value="<?= $data['id_pinjam'] ?>">

            <div class="mb-3">
                <label>Total Harga</label>
                <input type="text" class="form-control" value="<?= $data['total_harga'] ?>" readonly>
            </div>

            <div class="mb-3">
                <label>Status Pembayaran</label>

                <select name="status_pembayaran" class="form-control">

                    <option value="Belum Dibayar"
                        <?= $data['status_pembayaran'] == 'Belum Dibayar' ? 'selected' : '' ?>>
                        Belum Dibayar
                    </option>

                    <option value="Sudah Dibayar"
                        <?= $data['status_pembayaran'] == 'Sudah Dibayar' ? 'selected' : '' ?>>
                        Sudah Dibayar
                    </option>

                </select>

            </div>

            <button type="submit" class="btn btn-success">
                UPDATE
            </button>

            <a href="../persetujuan/index.php" class="btn btn-secondary">
                KEMBALI
            </a>

        </form>

    </div>
</div>

<?php
include '../../partials/footer.php';
include '../../partials/script.php';
?>