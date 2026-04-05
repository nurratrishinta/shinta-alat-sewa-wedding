<?php
include '../../partials/header.php';
include '../../partials/sidenav.php';
include '../../partials/navbar.php';
require_once __DIR__ . '/../../../config/connection.php';

// Ambil data kategori
$qKategori = "SELECT * FROM kategori ORDER BY nama_kategori ASC";
$result = mysqli_query($connect, $qKategori) or die(mysqli_error($connect));
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5>Tabel Kategori Wedding</h5>
                <a href="./create.php" class="btn btn-primary">Tambah Kategori</a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Kategori</th>
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($result) > 0): ?>
                                <?php $no = 1; ?>
                                <?php while ($item = mysqli_fetch_object($result)): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $item->nama_kategori ?></td>
                                        <td>
                                            <a href="./edit.php?id=<?= $item->id_kategori ?>"
                                                class="btn btn-warning btn-sm"
                                                title="Edit"> edit
                                                <span class="material-icons">edit</span>
                                            </a>

                                            <a href="../../actions/kategori/destroy.php?id=<?= $item->id_kategori ?>"
                                                class="btn btn-danger btn-sm"
                                                title="Hapus"   
                                                onclick="return confirm('Yakin ingin menghapus kategori ini?')"> hapus
                                                <span class="material-icons">delete</span>
                                            </a>

                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center">
                                        Data kategori belum ada
                                    </td>
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