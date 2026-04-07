<?php
session_start();

// Load Partials
include '../../partials/header.php';
include '../../partials/sidenav.php';
include '../../partials/navbar.php';

// Database Connection
require_once __DIR__ . '/../../../config/connection.php';

/* =========================
   QUERY DATA PEMINJAMAN
========================= */
$query = "
SELECT 
    p.id_pinjam,
    p.alamat_peminjam,
    p.tgl_pinjam,
    p.total_harga,
    p.metode_pembayaran,
    IFNULL(p.status_pembayaran,'Belum Dibayar') AS status_pembayaran,
    p.status,
    u.nama AS nama_user,
    GROUP_CONCAT(a.nama_alat SEPARATOR ', ') AS nama_alat,
    SUM(d.jumlah) AS jumlah_pinjam
FROM peminjaman p
LEFT JOIN users u ON p.id_user = u.id_user
LEFT JOIN detail_peminjaman d ON p.id_pinjam = d.id_pinjam
LEFT JOIN alat a ON d.id_alat = a.id_alat
GROUP BY p.id_pinjam
ORDER BY p.id_pinjam DESC
";

$result = mysqli_query($connect, $query);
?>

<div class="container-fluid py-4">
    <div class="card shadow-sm">

        <div class="card-header bg-white">
            <h5 class="fw-bold text-primary">
                <i class="fas fa-handshake"></i> Persetujuan & Pembayaran Peminjaman
            </h5>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Peminjam</th>
                            <th>Alat & Jumlah</th>
                            <th>Tanggal</th>
                            <th>Total Bayar</th>
                            <th>Metode</th>
                            <th>Status Bayar</th>
                            <th>Status Pinjam</th>
                            <th width="200">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        $no = 1;
                        while ($row = mysqli_fetch_object($result)):
                        ?>

                            <tr>

                                <td class="text-center"><?= $no++ ?></td>

                                <td>
                                    <b><?= $row->nama_user ?></b><br>
                                    <small class="text-muted"><?= $row->alamat_peminjam ?></small>
                                </td>

                                <td>
                                    <?= $row->nama_alat ?>
                                    <span class="badge bg-primary"><?= $row->jumlah_pinjam ?> pcs</span>
                                </td>

                                <td class="text-center">
                                    <?= date('d M Y', strtotime($row->tgl_pinjam)) ?>
                                </td>

                                <td class="text-end">
                                    <b>Rp <?= number_format($row->total_harga, 0, ',', '.') ?></b>
                                </td>

                                <td class="text-center">
                                    <?php if ($row->metode_pembayaran == "Transfer") { ?>
                                        <span class="badge bg-primary">Transfer</span>
                                    <?php } else { ?>
                                        <span class="badge bg-info text-dark">COD</span>
                                    <?php } ?>
                                </td>

                                <td class="text-center">
                                    <?php
                                    if ($row->status_pembayaran == "Sudah Dibayar") {
                                        echo '<span class="badge bg-success">Sudah Dibayar</span>';
                                    } elseif ($row->status_pembayaran == "Sudah Transfer") {
                                        echo '<span class="badge bg-primary">Sudah Transfer</span>';
                                    } else {
                                        echo '<span class="badge bg-warning text-dark">Belum Dibayar</span>';
                                    }
                                    ?>
                                </td>

                                <td class="text-center">
                                    <?php
                                    switch ($row->status) {

                                        case "Menunggu":
                                            echo '<span class="badge bg-secondary">Menunggu</span>';
                                            break;

                                        case "Disetujui":
                                            echo '<span class="badge bg-success">Disetujui</span>';
                                            break;

                                        case "Ditolak":
                                            echo '<span class="badge bg-danger">Ditolak</span>';
                                            break;

                                        case "Dikembalikan":
                                            echo '<span class="badge bg-info">Dikembalikan</span>';
                                            break;
                                    }
                                    ?>
                                </td>

                                <td class="text-center">

                                    <?php if ($row->status == "Menunggu") { ?>

                                        <button onclick="approve(<?= $row->id_pinjam ?>)" class="btn btn-success btn-sm">
                                            Setujui
                                        </button>

                                        <button onclick="reject(<?= $row->id_pinjam ?>)" class="btn btn-danger btn-sm">
                                            Tolak
                                        </button>

                                    <?php } elseif ($row->status == "Disetujui") { ?>

                                        <?php if ($row->status_pembayaran != "Sudah Dibayar") { ?>

                                            <button onclick="bayar(<?= $row->id_pinjam ?>)" class="btn btn-primary btn-sm">
                                                Konfirmasi Bayar
                                            </button>

                                        <?php } else { ?>

                                            <span class="text-success small">
                                                Transaksi Selesai
                                            </span>

                                        <?php } ?>

                                    <?php } ?>

                                </td>

                            </tr>

                        <?php endwhile; ?>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<script>
    function approve(id) {

        let audio = new Audio('../../../templates-admin/material-dashboard-2/assets/sounds/approve.mp3');
        audio.play();

        setTimeout(function() {

            window.location.href = '../../actions/peminjaman/approve.php?id=' + id + '&status=Disetujui';

        }, 800);

    }

    function reject(id) {

        let audio = new Audio('../../../templates-admin/material-dashboard-2/assets/sounds/approve.mp3');
        audio.play();

        setTimeout(function() {

            window.location.href = '../../actions/peminjaman/approve.php?id=' + id + '&status=Ditolak';

        }, 800);

    }

    function bayar(id) {

        let audio = new Audio('../../../templates-admin/material-dashboard-2/assets/sounds/approve.mp3');
        audio.play();

        setTimeout(function() {

            window.location.href = '../../actions/peminjaman/bayar.php?id=' + id + '&status=bayar';

        }, 800);

    }
</script>

<?php
include '../../partials/footer.php';
include '../../partials/script.php';
?>