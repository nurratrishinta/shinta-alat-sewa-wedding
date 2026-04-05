<?php
require_once __DIR__ . '/../../../config/connection.php';

if (!isset($_GET['id'])) {
    echo "<script>alert('ID tidak ditemukan'); window.location.href='../../pages/peminjaman/index.php';</script>";
    exit;
}

$id = (int) $_GET['id']; // Ini adalah id_kembali

// Ambil id_pinjam sebelum dihapus untuk update status peminjaman
$data = mysqli_fetch_object(mysqli_query($connect, "SELECT id_pinjam FROM pengembalian WHERE id_kembali = $id"));

if ($data) {
    $id_pinjam = $data->id_pinjam;
    
    // Hapus data pengembalian
    $query = "DELETE FROM pengembalian WHERE id_kembali = $id";

    if (mysqli_query($connect, $query)) {
        // Update status peminjaman balik ke 'Disetujui'
        mysqli_query($connect, "UPDATE peminjaman SET status = 'Disetujui' WHERE id_pinjam = $id_pinjam");

        echo "<script>alert('Data pengembalian berhasil dihapus'); window.location.href='../../pages/peminjaman/index.php';</script>";
    }
} else {
    echo "<script>alert('Data tidak ditemukan'); window.location.href='../../pages/peminjaman/index.php';</script>";
}
?>