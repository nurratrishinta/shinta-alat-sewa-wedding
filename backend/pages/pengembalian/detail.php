<?php
include '../../partials/header.php';
include '../../partials/sidenav.php';
include '../../partials/navbar.php';

require_once __DIR__ . '/../../../config/connection.php';

$id = (int)$_GET['id'];

$query = "SELECT 
            pg.*,
            p.tgl_pinjam,
            p.tgl_kembali AS tgl_rencana,
            u.nama AS nama_user,
            GROUP_CONCAT(a.nama_alat SEPARATOR ', ') AS nama_alat
          FROM pengembalian pg
          
          JOIN peminjaman p 
          ON pg.id_pinjam = p.id_pinjam
          
          JOIN users u 
          ON p.id_user = u.id_user
          
          JOIN detail_peminjaman dp 
          ON p.id_pinjam = dp.id_pinjam
          
          JOIN alat a 
          ON dp.id_alat = a.id_alat
          
          WHERE pg.id_kembali = $id
          
          GROUP BY pg.id_kembali";

$result = mysqli_query($connect, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='index.php';</script>";
    exit;
}

$data = mysqli_fetch_object($result);
?>

<div class="row">
    <div class="col-md-8">

        <div class="card shadow-lg">

            <div class="card-header bg-gradient-info pt-4 pb-3">
                <h6 class="text-white ps-3">
                    Detail Pengembalian #<?= $data->id_kembali ?>
                </h6>
            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6">

                        <p class="text-sm mb-0">Nama Peminjam</p>
                        <h6 class="font-weight-bold"><?= $data->nama_user ?></h6>

                        <hr>

                        <p class="text-sm mb-0">Alat yang Dipinjam</p>
                        <h6 class="font-weight-bold"><?= $data->nama_alat ?></h6>

                    </div>

                    <div class="col-md-6">

                        <p class="text-sm mb-0">Tanggal Pinjam</p>
                        <h6 class="font-weight-bold">
                            <?= date('d M Y', strtotime($data->tgl_pinjam)) ?>
                        </h6>

                        <hr>

                        <p class="text-sm mb-0">Tanggal Pengembalian</p>
                        <h6 class="font-weight-bold text-success">
                            <?= date('d M Y', strtotime($data->tgl_pengembalian)) ?>
                        </h6>

                    </div>

                </div>

                <div class="bg-light p-3 mt-4 border-radius-lg">

                    <div class="row">

                        <div class="col-md-6">

                            <p class="text-sm mb-1">Kondisi Saat Kembali</p>

                            <span class="badge bg-info">
                                <?= $data->kondisi_alat ?>
                            </span>

                        </div>

                        <div class="col-md-6 text-end">

                            <p class="text-sm mb-0">Total Denda</p>

                            <h5 class="text-danger font-weight-bold">
                                Rp <?= number_format($data->denda, 0, ',', '.') ?>
                            </h5>

                        </div>

                    </div>

                    <hr>

                    <p class="text-sm mb-1">Deskripsi</p>

                    <p class="text-dark">
                        <?= $data->deskripsi ? $data->deskripsi : 'Tidak ada keterangan' ?>
                    </p>

                </div>

                <a href="index.php" class="btn btn-secondary mt-3">
                    Kembali
                </a>

            </div>
        </div>
    </div>
</div>

<?php
include '../../partials/footer.php';
include '../../partials/script.php';
?>