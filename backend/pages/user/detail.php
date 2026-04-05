<?php
include '../../partials/header.php';
include '../../partials/sidenav.php';
include '../../partials/navbar.php';
require_once __DIR__ . '/../../../config/connection.php';

$id = (int) $_GET['id'];

$qUser = "SELECT * FROM users WHERE id_user = $id";
$result = mysqli_query($connect, $qUser);
$user = mysqli_fetch_object($result);

if (!$user) {
    echo "<script>alert('User tidak ditemukan'); window.location='index.php';</script>";
    exit;
}
?>

<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header">
                <h5>Detail User</h5>
            </div>

            <div class="card-body">

                <div class="mb-3">
                    <label class="fw-bold">Nama</label>
                    <p class="form-control-plaintext">
                        <?= htmlspecialchars($user->nama ?? '') ?>
                    </p>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Email</label>
                    <p class="form-control-plaintext">
                        <?= htmlspecialchars($user->email ?? '') ?>
                    </p>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Role</label>
                    <p class="form-control-plaintext">
                        <?= htmlspecialchars($user->role ?? '') ?>
                    </p>
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