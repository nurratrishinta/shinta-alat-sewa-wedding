<?php
session_start();

if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    header("Location: ../dashboard/index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Sewa Alat Wedding</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .hero {
            background: url('../../templates-admin/material-dashboard-2/assets/img/1setwedding.webp') center;
            background-size: cover;
            height: 450px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
        }

        .hero h1 {
            font-weight: bold;
        }

        .card-vendor {
            transition: 0.3s;
        }

        .card-vendor:hover {
            transform: translateY(-5px);
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm">
        <div class="container">

            <a class="navbar-brand fw-bold">Sewa Wedding</a>

            <div class="ms-auto">
                <a href="../../actions/auth/login.php" class="btn btn-outline-primary me-2">Masuk</a>
                <a href="../../actions/auth/register.php" class="btn btn-primary">Daftar</a>
            </div>

        </div>
    </nav>

    <!-- HERO -->
    <section class="hero">
        <div>
            <h1>Sewa Alat Wedding Terlengkap</h1>
            <p>Temukan berbagai kebutuhan pernikahan dengan mudah</p>

            <a href="../../actions/auth/login.php" class="btn btn-light btn-lg mt-3">
                Login Sekarang
            </a>
        </div>
    </section>

    <!-- VENDOR -->
    <div class="container mt-5">

        <h3 class="fw-bold mb-4">Rekomendasi Vendor</h3>

        <div class="row">

            <div class="col-md-4">
                <div class="card card-vendor shadow-sm">
                    <img src="../../templates-admin/material-dashboard-2/assets/img/1setwedding.webp" class="card-img-top">
                    <div class="card-body">
                        <h5>Pelaminan</h5>
                        <p>Sewa pelaminan modern dan elegan</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-vendor shadow-sm">
                    <img src="../../templates-admin/material-dashboard-2/assets/img/1setwedding.webp" class="card-img-top">
                    <div class="card-body">
                        <h5>Kursi Tamu</h5>
                        <p>Kursi tamu pernikahan berbagai model</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-vendor shadow-sm">
                    <img src="../../templates-admin/material-dashboard-2/assets/img/1setwedding.webp" class="card-img-top">
                    <div class="card-body">
                        <h5>Dekorasi</h5>
                        <p>Dekorasi wedding modern dan elegan</p>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- FOOTER -->
    <footer class="bg-dark text-white text-center p-3 mt-5">
        © <?= date('Y') ?> Sewa Alat Wedding
    </footer>

</body>

</html>