<?php
include '../../partials/header.php';
include '../../partials/sidenav.php';
include '../../partials/navbar.php';
require_once __DIR__ . '/../../../config/connection.php';

if (!isset($_GET['id'])) {
    echo "<script>alert('ID kategori tidak ditemukan'); window.location='index.php';</script>";
    exit;
}

$id = (int) $_GET['id'];
$qKategori = "SELECT * FROM kategori WHERE id_kategori = $id";
$result = mysqli_query($connect, $qKategori);
$kategori = mysqli_fetch_object($result);

if (!$kategori) {
    echo "<script>alert('Data kategori tidak ditemukan'); window.location='index.php';</script>";
    exit;
}
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5>Detail Kategori</h5>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Kategori</label>
                    <p class="form-control-plaintext"><?= $kategori->nama_kategori ?></p>
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