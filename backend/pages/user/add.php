<?php
include '../../partials/header.php';
include '../../partials/sidenav.php';
include '../../partials/navbar.php';
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h5>Tambah User</h5>
        </div>

        <div class="card-body">
            <form action="../../../backend/actions/user/store.php" method="POST">

                <div class="form-group mb-3">
                    <label>Username / Email</label>
                    <input type="text" name="username" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label>Role</label>
                    <select name="role" class="form-control" required>
                        <option value="Admin">Admin</option>
                        <option value="Petugas">Petugas</option>
                        <option value="Peminjam">Peminjam</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>

<?php
include '../../partials/footer.php';
include '../../partials/script.php';
?>