<?php
include '../../partials/header.php';
include '../../partials/sidenav.php';
include '../../partials/navbar.php';
require_once __DIR__ . '/../../../config/connection.php';

// Ambil ID
if (!isset($_GET['id'])) {
    echo "<script>alert('ID kategori tidak ditemukan'); window.location='index.php';</script>";
    exit;
}

$id = (int) $_GET['id'];

// Ambil data kategori
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
                <h5>Ubah Data Kategori</h5>
            </div>

            <div class="card-body">
                <form action="../../actions/kategori/update.php" method="POST">
                    <input type="hidden" name="id_kategori" value="<?= $kategori->id_kategori ?>">

                    <div class="mb-3">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text"
                            name="nama_kategori"
                            class="form-control"
                            value="<?= $kategori->nama_kategori ?>"
                            required>
                    </div>

                    <button type="submit" name="simpan" class="btn btn-success">Update</button>
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