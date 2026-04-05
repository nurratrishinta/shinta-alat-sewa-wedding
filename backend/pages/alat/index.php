<?php
include '../../partials/header.php';
include '../../partials/sidenav.php';
include '../../partials/navbar.php';
require_once __DIR__ . '/../../../config/connection.php';

$qAlat = "SELECT alat.*, kategori.nama_kategori 
          FROM alat 
          LEFT JOIN kategori ON alat.id_kategori = kategori.id_kategori";
$result = mysqli_query($connect, $qAlat);
?>

<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header d-flex justify-content-between">
                <h5>Tabel Alat Wedding</h5>
                <a href="./create.php" class="btn btn-primary">Tambah Alat</a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">

                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Alat</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Harga</th>
                                <th>Gambar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $no = 1;
                            while ($item = mysqli_fetch_object($result)): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($item->nama_alat) ?></td>
                                    <td><?= htmlspecialchars($item->nama_kategori) ?></td>
                                    <td><?= $item->stok ?></td>
                                    <td><b>Rp <?= number_format($item->harga, 0, ',', '.') ?></b></td>

                                    <td>
                                        <?php if ($item->gambar): ?>
                                            <img src="../../../storages/alat/<?= $item->gambar ?>" width="70">
                                        <?php else: ?>
                                            <span class="text-muted">Tidak ada</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <a href="detail.php?id=<?= $item->id_alat ?>" class="btn btn-success btn-sm">Detail</a>
                                        <a href="edit.php?id=<?= $item->id_alat ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="../../actions/alat/destroy.php?id=<?= $item->id_alat ?>"
                                            onclick="return confirm('Yakin hapus?')"
                                            class="btn btn-danger btn-sm">Hapus</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
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