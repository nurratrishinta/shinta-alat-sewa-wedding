<?php
include '../../partials/header.php';
include '../../partials/sidenav.php';
include '../../partials/navbar.php';
require_once __DIR__ . '/../../../config/connection.php';

// Ambil data alat berdasarkan ID
include '../../actions/alat/show.php';
$kategori = mysqli_query($connect, "SELECT * FROM kategori");
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5>Ubah Data Alat</h5>
            </div>

            <div class="card-body">
                <form action="../../actions/alat/update.php"
                    method="POST"
                    enctype="multipart/form-data">

                    <input type="hidden" name="id_alat" value="<?= $alat->id_alat ?>">

                    <!-- Nama Alat -->
                    <div class="mb-3">
                        <label class="form-label">Nama Alat</label>
                        <input type="text"
                            name="nama_alat"
                            class="form-control"
                            value="<?= htmlspecialchars($alat->nama_alat) ?>"
                            required>
                    </div>

                    <!-- Kategori -->
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="id_kategori" class="form-control" required>
                            <?php while ($k = mysqli_fetch_assoc($kategori)): ?>
                                <option value="<?= $k['id_kategori'] ?>"
                                    <?= ($k['id_kategori'] == $alat->id_kategori) ? 'selected' : '' ?>>
                                    <?= $k['nama_kategori'] ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <!-- Stok -->
                    <div class="mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number"
                            name="stok"
                            class="form-control"
                            value="<?= $alat->stok ?>"
                            required>
                    </div>

                    <!-- Harga -->
                    <div class="mb-3">
                        <label class="form-label">Harga (Rp)</label>
                        <input type="number"
                            name="harga"
                            class="form-control"
                            value="<?= $alat->harga ?>"
                            required>
                    </div>

                    <!-- Gambar Lama -->
                    <?php if (!empty($alat->gambar)): ?>
                        <img src="../../../storages/alat/<?= htmlspecialchars($alat->gambar) ?>"
                            width="120"
                            class="img-thumbnail mb-2">
                    <?php endif; ?>

                    <!-- Ganti Gambar -->
                    <div class="mb-3">
                        <label class="form-label">Ganti Gambar</label>
                        <input type="file"
                            name="gambar"
                            class="form-control"
                            accept="image/*">
                    </div>

                    <button type="submit" class="btn btn-success">Update</button>
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