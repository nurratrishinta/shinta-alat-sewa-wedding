<?php
include '../../partials/header.php';
include '../../partials/sidenav.php';
include '../../partials/navbar.php';
require_once __DIR__ . '/../../../config/connection.php';

$kategori = mysqli_query($connect, "SELECT * FROM kategori");
?>

<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header">
                <h5>Tambah Data Alat</h5>
            </div>

            <div class="card-body">
                <form action="../../actions/alat/store.php" method="POST" enctype="multipart/form-data">

                    <div class="mb-3">
                        <label>Nama Alat</label>
                        <input type="text" name="nama_alat" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Kategori</label>
                        <select name="id_kategori" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <?php while ($k = mysqli_fetch_assoc($kategori)): ?>
                                <option value="<?= $k['id_kategori'] ?>"><?= $k['nama_kategori'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Stok</label>
                        <input type="number" name="stok" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Harga (Rp)</label>
                        <input type="number" name="harga" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Gambar</label>
                        <input type="file" name="gambar" class="form-control">
                    </div>

                    <button class="btn btn-success">Simpan</button>
                    <a href="./index.php" class="btn btn-secondary">Kembali</a>

                </form>
            </div>

        </div>
    </div>
</div>
<?php
include '../../partials/footer.php';
include '../../partials/script.php';
?>