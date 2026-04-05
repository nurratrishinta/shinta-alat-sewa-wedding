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

if (!$result) {
    die("Query Error: " . mysqli_error($connect));
}
?>

<div class="container-fluid py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-primary">Persetujuan & Pembayaran Peminjaman</h5>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Peminjam</th>
                            <th>Alat & Jumlah</th>
                            <th>Tanggal Pinjam</th>
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
                                    <strong><?= $row->nama_user ?></strong><br>
                                    <small class="text-muted"><?= $row->alamat_peminjam ?></small>
                                </td>
                                <td>
                                    <span class="badge badge-dot border border-secondary text-dark">
                                        <?= $row->nama_alat ?> (<?= $row->jumlah_pinjam ?> pcs)
                                    </span>
                                </td>
                                <td class="text-center"><?= date('d M Y', strtotime($row->tgl_pinjam)) ?></td>
                                <td class="text-end fw-bold text-dark">
                                    Rp <?= number_format($row->total_harga, 0, ',', '.') ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($row->metode_pembayaran == "Transfer"): ?>
                                        <span class="badge bg-primary">Transfer</span>
                                    <?php else: ?>
                                        <span class="badge bg-info text-dark">COD</span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center">
                                    <?php
                                    $s_bayar = $row->status_pembayaran;
                                    $b_bayar = ($s_bayar == "Sudah Dibayar") ? "success" : (($s_bayar == "Sudah Transfer") ? "primary" : "warning text-dark");
                                    ?>
                                    <span class="badge bg-<?= $b_bayar ?>">
                                        <?= $s_bayar ?>
                                    </span>
                                </td>

                                <td class="text-center">
                                    <?php
                                    switch ($row->status) {
                                        case "Menunggu":
                                            $b_pinjam = "secondary";
                                            break;
                                        case "Disetujui":
                                            $b_pinjam = "success";
                                            break;
                                        case "Ditolak":
                                            $b_pinjam = "danger";
                                            break;
                                        case "Dikembalikan":
                                            $b_pinjam = "info";
                                            break;
                                        default:
                                            $b_pinjam = "dark";
                                    }
                                    ?>
                                    <span class="badge bg-<?= $b_pinjam ?>">
                                        <?= $row->status ?>
                                    </span>
                                </td>

                                <td class="text-center">
                                    <?php if ($row->status == "Menunggu"): ?>
                                        <div class="btn-group">
                                            <a href="../../actions/peminjaman/approve.php?id=<?= $row->id_pinjam ?>&status=Disetujui"
                                                class="btn btn-success btn-sm" onclick="return confirm('Setujui peminjaman ini?')">
                                                Setujui
                                            </a>
                                            <a href="../../actions/peminjaman/approve.php?id=<?= $row->id_pinjam ?>&status=Ditolak"
                                                class="btn btn-danger btn-sm" onclick="return confirm('Tolak peminjaman ini?')">
                                                Tolak
                                            </a>
                                        </div>

                                    <?php elseif ($row->status == "Disetujui"): ?>

                                        <?php if ($row->status_pembayaran != "Sudah Dibayar"): ?>
                                            <a href="../../actions/peminjaman/bayar.php?id=<?= $row->id_pinjam ?>&status=bayar"
                                                class="btn btn-primary btn-sm w-100 shadow-sm">
                                                Konfirmasi Bayar
                                            </a>
                                        <?php else: ?>
                                            <span class="text-success small fw-bold">
                                                <i class="fas fa-check-circle"></i> Transaksi Selesai
                                            </span>
                                        <?php endif; ?>

                                    <?php elseif ($row->status == "Ditolak"): ?>
                                        <span class="text-muted small">Peminjaman Ditolak</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
include '../../partials/footer.php';
include '../../partials/script.php';
?>