<?php
include '../../partials/header.php';
include '../../partials/sidenav.php';
include '../../partials/navbar.php';
require_once __DIR__ . '/../../../config/connection.php';

$id = (int) ($_GET['id'] ?? 0);

/* ========================
   Ambil data peminjaman
======================== */

$query = "
SELECT 
    p.id_pinjam,
    p.alamat_peminjam,
    p.no_telepon,
    p.tgl_pinjam,
    p.total_harga,
    p.status,
    u.username
FROM peminjaman p
LEFT JOIN users u ON p.id_user = u.id_user
WHERE p.id_pinjam = $id
";

$result = mysqli_query($connect, $query);
$data = mysqli_fetch_object($result);

if (!$data) {
    die('Data tidak ditemukan');
}

/* ========================
   Ambil detail alat
======================== */

$query_detail = "
SELECT 
    a.nama_alat,
    d.jumlah
FROM detail_peminjaman d
LEFT JOIN alat a ON d.id_alat = a.id_alat
WHERE d.id_pinjam = $id
";

$result_detail = mysqli_query($connect, $query_detail);
?>

<div class="card">

    <div class="card-header">
        <h5>Detail Peminjaman</h5>
    </div>

    <div class="card-body">

        <table class="table table-borderless">

            <tr>
                <th width="200">Peminjam</th>
                <td>: <?= $data->username ?></td>
            </tr>

            <tr>
                <th>Alamat</th>
                <td>: <?= $data->alamat_peminjam ?></td>
            </tr>

            <tr>
                <th>Nomor Telepon</th>
                <td>: <?= $data->no_telepon ?></td>
            </tr>

            <tr>
                <th>Tanggal Pinjam</th>
                <td>: <?= $data->tgl_pinjam ?></td>
            </tr>

            <tr>
                <th>Status</th>
                <td>: <?= $data->status ?></td>
            </tr>

        </table>

        <hr>

        <h6>Daftar Alat Dipinjam</h6>

        <table class="table table-bordered">

            <thead class="table-light">
                <tr class="text-center">
                    <th>No</th>
                    <th>Nama Alat</th>
                    <th>Jumlah</th>
                </tr>
            </thead>

            <tbody>

                <?php
                $no = 1;
                while ($row = mysqli_fetch_object($result_detail)):
                ?>

                    <tr>

                        <td class="text-center"><?= $no++ ?></td>

                        <td><?= $row->nama_alat ?></td>

                        <td class="text-center">
                            <?= $row->jumlah ?> Unit
                        </td>

                    </tr>

                <?php endwhile; ?>

            </tbody>

        </table>

        <div class="mt-3">
            <strong>Total Harga :</strong>
            Rp <?= number_format($data->total_harga, 0, ',', '.') ?>
        </div>

        <br>

        <a href="index.php" class="btn btn-secondary">
            Kembali
        </a>

    </div>

</div>

<?php
include '../../partials/footer.php';
include '../../partials/script.php';
?>