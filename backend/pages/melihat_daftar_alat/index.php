<?php
include '../../partials/header.php';
include '../../partials/sidenav.php';
include '../../partials/navbar.php';
require_once __DIR__ . '/../../../config/connection.php';

// Ambil data alat + kategori
$query = "SELECT alat.*, kategori.nama_kategori
          FROM alat
          LEFT JOIN kategori ON alat.id_kategori = kategori.id_kategori
          ORDER BY alat.id_alat DESC";

$result = mysqli_query($connect, $query) or die(mysqli_error($connect));
?>

<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h4>Data Alat Wedding</h4>
    </div>
</div>

<!-- Video Banner Template -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm overflow-hidden">

            <div style="position:relative;">
                <video id="videoWedding" autoplay muted loop playsinline
                    style="width:100%; height:250px; object-fit:cover;">
                    <source src="../../templates-admin/material-dashboard-2/assets/video/videowedding.mp4" type="video/mp4">
                </video>

                <button onclick="aktifkanSuara()"
                    style="position:absolute; bottom:10px; right:10px; background:black; color:white; border:none; padding:8px 12px;">
                    🔊 Aktifkan Suara
                </button>
            </div>

            <script>
                function aktifkanSuara() {
                    var video = document.getElementById("videoWedding");
                    video.muted = false;
                }
            </script>

        </div>
    </div>
</div>

<div class="row">
    <?php while ($alat = mysqli_fetch_object($result)) : ?>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">

                <!-- Gambar -->
                <?php if (!empty($alat->gambar)) : ?>
                    <img src="../../../storages/alat/<?= htmlspecialchars($alat->gambar) ?>"
                        class="card-img-top"
                        style="height:220px; object-fit:cover;">
                <?php else : ?>
                    <div class="bg-light d-flex align-items-center justify-content-center"
                        style="height:220px;">
                        <span class="text-muted">Tidak ada gambar</span>
                    </div>
                <?php endif; ?>

                <!-- Konten -->
                <div class="card-body">
                    <small class="text-muted d-block mb-1">
                        <?= htmlspecialchars($alat->nama_kategori) ?>
                    </small>

                    <h6 class="fw-bold mb-2">
                        <?= htmlspecialchars($alat->nama_alat) ?>
                    </h6>

                    <!-- HARGA -->
                    <p class="mb-1 fw-semibold text-primary">
                        Rp <?= number_format($alat->harga, 0, ',', '.') ?>
                    </p>

                    <!-- STOK -->
                    <p class="text-muted mb-0" style="font-size:13px;">
                        Stok: <?= htmlspecialchars($alat->stok) ?>
                    </p>
                </div>



            </div>
        </div>
    <?php endwhile; ?>
</div>

<?php
include '../../partials/footer.php';
include '../../partials/script.php';
?>