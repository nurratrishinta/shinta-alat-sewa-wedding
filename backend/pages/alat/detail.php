<?php
include '../../partials/header.php';
include '../../partials/sidenav.php';
include '../../partials/navbar.php';
require_once __DIR__ . '/../../../config/connection.php';

// Ambil data alat dari file actions/show
include '../../actions/alat/show.php';
?>

<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header">
                <h5>Detail Data Alat</h5>
            </div>

            <div class="card-body">

                <!-- Nama Alat -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Alat</label>
                    <p class="form-control-plaintext">
                        <?= htmlspecialchars($alat->nama_alat) ?>
                    </p>
                </div>

                <!-- Kategori -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Kategori</label>
                    <p class="form-control-plaintext">
                        <?= htmlspecialchars($alat->nama_kategori) ?>
                    </p>
                </div>

                <!-- Stok -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Jumlah Stok</label>
                    <p class="form-control-plaintext">
                        <?= htmlspecialchars($alat->stok) ?> Unit
                    </p>
                </div>

                <!-- Harga -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Harga</label>
                    <p class="form-control-plaintext text-primary fw-semibold">
                        Rp <?= number_format($alat->harga, 0, ',', '.') ?>
                    </p>
                </div>

                <!-- Gambar -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Gambar Alat</label><br>

                    <?php if (!empty($alat->gambar)): ?>
                        <img src="../../../storages/alat/<?= htmlspecialchars($alat->gambar) ?>"
                            class="img-fluid rounded border"
                            style="max-width: 300px;"
                            alt="Gambar Alat">
                    <?php else: ?>
                        <p class="text-muted fst-italic">Tidak ada gambar.</p>
                    <?php endif; ?>
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