<?php
session_start();
require_once __DIR__ . '/../../../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Akses tidak valid");
}

// Mengambil dan membersihkan input
$id                = $_POST['id_pinjam'];
$alamat_peminjam   = $_POST['alamat_peminjam'];
$no_telepon        = $_POST['no_telepon'];
$tgl_pinjam        = $_POST['tgl_pinjam'];
$tgl_kembali       = $_POST['tgl_kembali'];
$total_harga       = $_POST['total_harga'];
$jumlah_pinjam     = $_POST['jumlah_pinjam'];
$status_pembayaran = $_POST['status_pembayaran'];
$status            = trim($_POST['status']);

// Gunakan Prepared Statement
$sql = "UPDATE peminjaman SET 
            alamat_peminjam   = ?,
            no_telepon        = ?,
            tgl_pinjam        = ?,
            tgl_kembali       = ?,
            total_harga       = ?,
            jumlah_pinjam     = ?,
            status_pembayaran = ?,
            status            = ?
        WHERE id_pinjam = ?";

$stmt = mysqli_prepare($connect, $sql);

// s = string, i = integer/number
// Gunakan 's' untuk semua jika ragu, karena MySQL akan otomatis mengonversi tipe data
mysqli_stmt_bind_param(
    $stmt,
    "sssssssss",
    $alamat_peminjam,
    $no_telepon,
    $tgl_pinjam,
    $tgl_kembali,
    $total_harga,
    $jumlah_pinjam,
    $status_pembayaran,
    $status,
    $id
);


    echo "<script>alert('Data berhasil diupdate!'); window.location.href='../../pages/persetujuan_peminjaman/index.php';</script>";

    // Jika masih error, tampilkan detail yang sangat jelas
    die("Gagal update database: " . mysqli_stmt_error($stmt));


mysqli_stmt_close($stmt);
?>