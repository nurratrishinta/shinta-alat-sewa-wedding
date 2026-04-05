<?php
include '../../partials/header.php';
include '../../partials/sidenav.php';
include '../../partials/navbar.php';
require_once __DIR__ . '/../../../config/connection.php';

/** * SOLUSI: 
 * Pastikan nama kolom di tabel 'users' benar. 
 * Jika di database kolomnya bukan 'username' (misal 'nama'), 
 * ganti 'users.username' menjadi 'users.nama AS username'
 */

$qLog = "SELECT log_aktivitas.*, users.nama AS username 
         FROM log_aktivitas 
         LEFT JOIN users ON users.id_user = log_aktivitas.id_user
         ORDER BY log_aktivitas.waktu DESC";

$result = mysqli_query($connect, $qLog);

// Cek jika query gagal untuk debugging lebih mudah
if (!$result) {
    die("Query Error: " . mysqli_error($connect));
}
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Log Aktivitas User</h5>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="50">No</th>
                                <th>User</th>
                                <th>Aktivitas</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (mysqli_num_rows($result) > 0): ?>
                                <?php $no = 1; ?>
                                <?php while ($item = mysqli_fetch_object($result)): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td>
                                            <strong><?= $item->username ?? '<span class="text-muted">User tidak ditemukan</span>' ?></strong>
                                        </td>
                                        <td><?= htmlspecialchars($item->aktivitas) ?></td>
                                        <td>
                                            <small class="text-muted">
                                                <?= date('d M Y, H:i', strtotime($item->waktu)) ?>
                                            </small>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada aktivitas.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include '../../partials/footer.php';
include '../../partials/script.php';
?>