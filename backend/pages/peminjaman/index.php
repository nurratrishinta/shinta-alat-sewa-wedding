<?php
include '../../partials/header.php';
include '../../partials/sidenav.php';
include '../../partials/navbar.php';
require_once __DIR__ . '/../../../config/connection.php';

$query = "
SELECT 
    p.id_pinjam,
    p.alamat_peminjam,
    p.no_telepon,
    p.tgl_pinjam,
    p.tgl_kembali,
    p.total_harga,
    p.jumlah_pinjam,
    p.status,
    p.metode_pembayaran,
    p.status_pembayaran,
    u.nama
FROM peminjaman p
LEFT JOIN users u ON p.id_user = u.id_user
ORDER BY p.id_pinjam DESC
";

$result = mysqli_query($connect, $query);

if (!$result) {
    die(mysqli_error($connect));
}
?>

<div class="card">

    <div class="card-header d-flex justify-content-between">
        <h5>Data Peminjaman</h5>

        <a href="./create.php" class="btn btn-primary btn-sm">
            <i class="material-icons">add</i> Tambah
        </a>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead class="table-light">
                    <tr class="text-center">

                        <th>No</th>
                        <th>User</th>
                        <th>Alamat</th>
                        <th>No Telepon</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Total Harga</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Metode</th>
                        <th>Pembayaran</th>

                    </tr>
                </thead>

                <tbody>

                    <?php
                    $no = 1;

                    while ($row = mysqli_fetch_object($result)) {
                    ?>

                        <tr>

                            <td class="text-center"><?= $no++ ?></td>

                            <td><?= htmlspecialchars($row->nama ?? '-') ?></td>

                            <td><?= htmlspecialchars($row->alamat_peminjam ?? '-') ?></td>

                            <td class="text-center"><?= $row->no_telepon ?></td>

                            <td class="text-center"><?= $row->tgl_pinjam ?></td>

                            <td class="text-center"><?= $row->tgl_kembali ?></td>

                            <td class="text-end">
                                Rp <?= number_format($row->total_harga, 0, ',', '.') ?>
                            </td>

                            <td class="text-center"><?= $row->jumlah_pinjam ?></td>

                            <td class="text-center">

                                <?php
                                $badge = match ($row->status) {
                                    'Menunggu' => 'warning',
                                    'Disetujui' => 'primary',
                                    'Ditolak' => 'danger',
                                    'Dikembalikan' => 'success',
                                    default => 'secondary'
                                };
                                ?>

                                <span class="badge bg-<?= $badge ?>">
                                    <?= $row->status ?>
                                </span>

                            </td>

                            <td class="text-center">
                                <?= $row->metode_pembayaran ?>
                            </td>

                            <td class="text-center">

                                <?php
                                $badge_payment = match ($row->status_pembayaran) {
                                    'Lunas' => 'success',
                                    'Belum Lunas' => 'danger',
                                    'DP' => 'warning',
                                    default => 'secondary'
                                };
                                ?>

                                <span class="badge bg-<?= $badge_payment ?>">
                                    <?= $row->status_pembayaran ?>
                                </span>

                            </td>

                        </tr>

                    <?php } ?>

                </tbody>
            </table>

        </div>
    </div>
</div>

<?php
include '../../partials/footer.php';
include '../../partials/script.php';
?>