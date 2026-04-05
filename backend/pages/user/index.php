<?php
include '../../partials/header.php';
include '../../partials/sidenav.php';
include '../../partials/navbar.php';
require_once __DIR__ . '/../../../config/connection.php';

$qUser = "SELECT * FROM users ORDER BY id_user DESC";
$result = mysqli_query($connect, $qUser);
?>

<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Tabel User</h5>
                <a href="./create.php" class="btn btn-primary">Tambah User</a>
            </div>

            <div class="card-body">

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama</th>
                            <th>Role</th>
                            <th width="25%">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <?php $no = 1; ?>

                            <?php while ($user = mysqli_fetch_object($result)): ?>

                                <tr>
                                    <td><?= $no++ ?></td>

                                    <td><?= htmlspecialchars($user->nama ?? '') ?></td>

                                    <td><?= htmlspecialchars($user->role ?? '') ?></td>

                                    <td>

                                        <a href="./edit.php?id=<?= $user->id_user ?>" class="btn btn-warning btn-sm">
                                            <span class="material-icons">edit</span> edit
                                        </a>

                                        <a href="../../actions/user/destroy.php?id=<?= $user->id_user ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin hapus user ini?')">

                                            <span class="material-icons">delete</span> hapus

                                        </a>

                                    </td>

                                </tr>

                            <?php endwhile; ?>

                        <?php else: ?>

                            <tr>
                                <td colspan="4" class="text-center">Data user belum ada</td>
                            </tr>

                        <?php endif; ?>

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<?php
include '../../partials/footer.php';
include '../../partials/script.php';
?>