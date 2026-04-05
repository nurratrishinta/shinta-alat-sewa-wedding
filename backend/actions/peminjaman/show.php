<?php
require_once __DIR__ . '/../../../config/connection.php';

/* =========================
   CEK ID
========================= */

if (!isset($_GET['id'])) {
    die('ID peminjaman tidak ditemukan');
}

$id = (int) $_GET['id'];

/* =========================
   QUERY DATA PEMINJAMAN
========================= */

$query = "
SELECT 
    p.id_pinjam,
    p.alamat_peminjam,
    p.no_telepon,
    p.tgl_pinjam,
    p.tgl_kembali,
    p.total_harga,
    p.jumlah_pinjam,
    p.status,
    p.metode_pembayaran,
    p.status_pembayaran,
    u.nama AS nama_user,
    a.nama_alat
FROM peminjaman p
LEFT JOIN users u ON p.id_user = u.id_user
LEFT JOIN alat a ON p.id_alat = a.id_alat
WHERE p.id_pinjam = $id
";

$result = mysqli_query($connect, $query);

if (!$result) {
    die('Query error: ' . mysqli_error($connect));
}

$peminjaman = mysqli_fetch_object($result);

if (!$peminjaman) {
    die('Data peminjaman tidak ditemukan');
}
?>