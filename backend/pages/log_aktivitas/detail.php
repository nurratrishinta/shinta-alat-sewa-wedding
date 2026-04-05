<?php
include '../../partials/header.php';
include '../../partials/sidenav.php';
include '../../partials/navbar.php';
require_once __DIR__ . '/../../../config/connection.php';

if (!isset($_GET['id'])) {
    echo "<script>alert('ID log tidak ditemukan'); window.location='index.php';</script>";
    exit;
}

$id = (int) $_GET['id'];

$qLog = "SELECT log_aktivitas.*, users.nama 
         FROM log_aktivitas
         LEFT JOIN users ON users.id = log_aktivitas.id_user
         WHERE id_log = $id";

$result = mysqli_query($connect, $qLog);
$log = mysqli_fetch_object($result);

if (!$log) {
    echo "<script>alert('Data log tidak ditemukan'); window.location='index.php';</script>";
    exit;
}
?>

<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header">
                <h5>Detail Log Aktivitas</h5>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">User</label>
                    <p class="form-control-plaintext"><?= $log->nama ?></p>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Aktivitas</label>
                    <p class="form-control-plaintext"><?= $log->aktivitas ?></p>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Waktu</label>
                    <p class="form-control-plaintext"><?= $log->waktu ?></p>
                </div>

                <a href="./index.php" class="btn btn-primary">Kembali</a>
            </div>

        </div>
    </div>
</div>

<?php
include '../../partials/footer.php';
include '../../partials/script.php';
?>