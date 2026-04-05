<?php
include '../../partials/header.php';
include '../../partials/sidenav.php';
include '../../partials/navbar.php';
?>

<div class="row">
    <div class="col-12">

        <div class="card">

            <div class="card-header">
                <h5>Tambah User</h5>
            </div>

            <div class="card-body">

                <form action="../../actions/user/store.php" method="POST">

                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Role</label>

                        <select name="role" class="form-control" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="admin">Admin</option>
                            <option value="petugas">Petugas</option>
                            <option value="peminjam">Peminjam</option>
                        </select>

                    </div>

                    <button type="submit" class="btn btn-success">Simpan</button>
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