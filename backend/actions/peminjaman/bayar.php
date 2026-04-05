<?php

session_start();
require_once __DIR__ . '/../../../config/connection.php';

$id = $_GET['id'] ?? 0;
$status = $_GET['status'] ?? '';

if (!$id) {
    die("ID tidak valid");
}

if ($status == "transfer") {
    $update = "Sudah Transfer";
} elseif ($status == "bayar") {
    $update = "Sudah Dibayar";
} else {
    $update = "Belum Dibayar";
}

$query = mysqli_query($connect, "
UPDATE peminjaman
SET status_pembayaran='$update'
WHERE id_pinjam='$id'
");

if ($query) {

    $_SESSION['success'] = "Status pembayaran berhasil diperbarui";
} else {

    $_SESSION['error'] = "Gagal update pembayaran";
}

header("Location: ../../pages/peminjaman/index.php");
exit;
?>