<?php
include '../../partials/header.php';
include '../../partials/sidenav.php';
include '../../partials/navbar.php';

require_once __DIR__ . '/../../../config/connection.php';

$id = (int)$_GET['id'];

$query = "SELECT 
            pg.*, 
            GROUP_CONCAT(a.nama_alat SEPARATOR ', ') AS nama_alat
          FROM pengembalian pg
          
          JOIN peminjaman p 
          ON pg.id_pinjam = p.id_pinjam
          
          JOIN detail_peminjaman dp 
          ON p.id_pinjam = dp.id_pinjam
          
          JOIN alat a 
          ON dp.id_alat = a.id_alat
          
          WHERE pg.id_kembali = $id
          
          GROUP BY pg.id_kembali";

$result = mysqli_query($connect, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "<script>alert('Data tidak ditemukan'); window.location='index.php';</script>";
    exit;
}

$data = mysqli_fetch_object($result);
?>

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card my-4">

            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">

                <div class="bg-gradient-warning shadow-warning border-radius-lg pt-4 pb-3">

                    <h6 class="text-white text-capitalize ps-3">
                        Edit Pengembalian : <?= $data->nama_alat ?>
                    </h6>

                </div>
            </div>

            <div class="card-body">

                <form action="../../actions/pengembalian/update.php" method="POST">

                    <input type="hidden" name="id_kembali" value="<?= $data->id_kembali ?>">

                    <div class="input-group input-group-static mb-4">
                        <label>Tanggal Pengembalian</label>

                        <input type="date"
                            name="tgl_pengembalian"
                            class="form-control"
                            value="<?= $data->tgl_pengembalian ?>"
                            required>

                    </div>

                    <div class="input-group input-group-static mb-4">
                        <label>Kondisi Alat</label>

                        <input type="text"
                            name="kondisi_alat"
                            class="form-control"
                            value="<?= $data->kondisi_alat ?>"
                            required>

                    </div>

                    <div class="input-group input-group-static mb-4">

                        <label>Deskripsi</label>

                        <textarea
                            name="deskripsi"
                            class="form-control"
                            rows="3"><?= $data->deskripsi ?></textarea>

                    </div>

                    <div class="input-group input-group-static mb-4">

                        <label>Denda (Rp)</label>

                        <input type="number"
                            name="denda"
                            class="form-control"
                            value="<?= $data->denda ?>">

                    </div>

                    <button type="submit" class="btn bg-gradient-warning">
                        Update Data
                    </button>

                    <a href="index.php" class="btn btn-light">
                        Batal
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