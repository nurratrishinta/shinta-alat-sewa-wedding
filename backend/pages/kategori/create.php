<?php
include '../../partials/header.php';
include '../../partials/sidenav.php';
include '../../partials/navbar.php';
require_once __DIR__ . '/../../../config/connection.php';
?>

<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header">
                <h5>Tambah Data Kategori</h5>
            </div>

            <div class="card-body">

                <!-- FORM TAMBAH KATEGORI -->
                <form action="../../actions/kategori/store.php" method="POST">

                    <div class="mb-3">
                        <label class="form-label">Nama Kategori</label>
                        <input
                            type="text"
                            name="nama_kategori"
                            class="form-control"
                            placeholder="Contoh: Alat / Bunga / Dekorasi"
                            required>
                    </div>

                    <button type="submit" class="btn btn-success">
                        Simpan
                    </button>

                    <a href="./index.php" class="btn btn-primary">
                        Kembali
                    </a>

                </form>

            </div>
        </div>
    </div>
</div>

<?php
include '../../partials/footer.php';
include '../../partials/script.php';
?>