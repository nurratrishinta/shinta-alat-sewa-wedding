<?php
include '../../partials/header.php';
include '../../partials/sidenav.php';
include '../../partials/navbar.php';
require_once __DIR__ . '/../../../config/connection.php';

$id = (int)$_GET['id'];

$qUser = "SELECT * FROM users WHERE id_user = $id";
$result = mysqli_query($connect, $qUser);

$user = mysqli_fetch_object($result);

if (!$user) {
    echo "<script>alert('User tidak ditemukan');window.location='index.php';</script>";
    exit;
}
?>

<div class="row">
    <div class="col-12">

        <div class="card">

            <div class="card-header">
                <h5>Edit User</h5>
            </div>

            <div class="card-body">

                <form action="../../actions/user/update.php" method="POST">

                    <input type="hidden" name="id_user" value="<?= $user->id_user ?>">

                    <div class="mb-3">
                        <label class="form-label">Nama</label>

                        <input
                            type="text"
                            name="nama"
                            class="form-control"
                            value="<?= htmlspecialchars($user->nama ?? '') ?>"
                            required>

                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password (kosongkan jika tidak diubah)</label>

                        <input
                            type="password"
                            name="password"
                            class="form-control">

                    </div>

                    <div class="mb-3">

                        <label class="form-label">Role</label>

                        <select name="role" class="form-control" required>

                            <option value="admin" <?= $user->role == 'admin' ? 'selected' : '' ?>>Admin</option>

                            <option value="petugas" <?= $user->role == 'petugas' ? 'selected' : '' ?>>Petugas</option>

                            <option value="peminjam" <?= $user->role == 'peminjam' ? 'selected' : '' ?>>Peminjam</option>

                        </select>

                    </div>

                    <button type="submit" class="btn btn-success">Update</button>

                    <a href="./index.php" class="btn btn-primary">Kembali</a>

                </form>

            </div>
        </div>
    </div>
</div>

<?php
include '../../partials/footer.php';
include '../../partials/script.php';
?>