<?php
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../../actions/auth/login.php");
    exit;
}

include '../../partials/header.php';
include '../../partials/sidenav.php';
include '../../partials/navbar.php';
require_once __DIR__ . '/../../../config/connection.php';

/* =========================
   QUERY JUMLAH DATA
========================= */

$qAlat         = mysqli_fetch_row(mysqli_query($connect, "SELECT COUNT(*) FROM alat"))[0];
$qKategori     = mysqli_fetch_row(mysqli_query($connect, "SELECT COUNT(*) FROM kategori"))[0];
$qPeminjaman   = mysqli_fetch_row(mysqli_query($connect, "SELECT COUNT(*) FROM peminjaman"))[0];
$qPengembalian = mysqli_fetch_row(mysqli_query($connect, "SELECT COUNT(*) FROM pengembalian"))[0];

/* =========================
   DATA GRAFIK PEMINJAMAN BULANAN
========================= */

$dataChart = [];

for ($i = 1; $i <= 12; $i++) {

    $q = mysqli_query($connect, "
        SELECT COUNT(*) as total 
        FROM peminjaman 
        WHERE MONTH(tgl_pinjam) = '$i'
    ");

    $d = mysqli_fetch_assoc($q);

    $dataChart[] = $d['total'];
}
?>

<div class="container mt-4">

    <!-- Judul -->
    <div class="row mb-3">
        <div class="col-12 text-center">
            <h2 class="fw-bold text-dark">DASHBOARD SEWA ALAT WEDDING</h2>
            <p class="text-muted">Selamat datang di halaman admin</p>
        </div>
    </div>

    <!-- Card Statistik -->
    <div class="row g-3">

        <!-- Alat -->
        <div class="col-md-3">
            <a href="../alat/" class="text-decoration-none">
                <div class="card text-white bg-primary shadow-sm rounded-3">
                    <div class="card-body d-flex justify-content-between">
                        <h5 class="fw-bold">Jumlah Alat</h5>
                        <i class="fas fa-tools fa-2x"></i>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <span class="fw-bold">Detail</span>
                        <span class="fw-bold"><?= $qAlat ?></span>
                        <i class="fas fa-arrow-circle-right"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- Kategori -->
        <div class="col-md-3">
            <a href="../kategori/" class="text-decoration-none">
                <div class="card text-white bg-success shadow-sm rounded-3">
                    <div class="card-body d-flex justify-content-between">
                        <h5 class="fw-bold">Jumlah Kategori</h5>
                        <i class="fas fa-th-large fa-2x"></i>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <span class="fw-bold">Detail</span>
                        <span class="fw-bold"><?= $qKategori ?></span>
                        <i class="fas fa-arrow-circle-right"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- Peminjaman -->
        <div class="col-md-3">
            <a href="../peminjaman/" class="text-decoration-none">
                <div class="card text-white bg-warning shadow-sm rounded-3">
                    <div class="card-body d-flex justify-content-between">
                        <h5 class="fw-bold">Peminjaman</h5>
                        <i class="fas fa-hand-holding fa-2x"></i>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <span class="fw-bold">Detail</span>
                        <span class="fw-bold"><?= $qPeminjaman ?></span>
                        <i class="fas fa-arrow-circle-right"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- Pengembalian -->
        <div class="col-md-3">
            <a href="../pengembalian/" class="text-decoration-none">
                <div class="card text-white bg-danger shadow-sm rounded-3">
                    <div class="card-body d-flex justify-content-between">
                        <h5 class="fw-bold">Pengembalian</h5>
                        <i class="fas fa-undo fa-2x"></i>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <span class="fw-bold">Detail</span>
                        <span class="fw-bold"><?= $qPengembalian ?></span>
                        <i class="fas fa-arrow-circle-right"></i>
                    </div>
                </div>
            </a>
        </div>

    </div>

    <!-- Grafik -->
    <div class="card mt-4 shadow-sm">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Statistik Peminjaman Bulanan</h5>
            <canvas id="chartPeminjaman" height="110"></canvas>
        </div>
    </div>

    <!-- Video Panduan -->
    <div class="card mt-4 shadow-sm">
        <div class="card-body">

            <h5 class="fw-bold mb-3">Video Panduan Sistem</h5>

            <div class="ratio ratio-16x9">
                <iframe
                    src="https://www.youtube.com/embed/4DGkMyQYyac?autoplay=1&mute=1&loop=1&playlist=4DGkMyQYyac"
                    title="Video Panduan Dashboard"
                    frameborder="0"
                    allow="autoplay; accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen>
                </iframe>
            </div>

        </div>
    </div>

</div>

<!-- ChartJS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('chartPeminjaman');

    new Chart(ctx, {

        type: 'bar',

        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Jumlah Peminjaman',
                data: <?= json_encode($dataChart) ?>,
                borderWidth: 1
            }]
        },

        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }

    });
</script>

<style>
    .card {
        transition: 0.2s;
        cursor: pointer;
    }

    .card:hover {
        transform: scale(1.05);
    }
</style>

<?php
include '../../partials/footer.php';
include '../../partials/script.php';
?>