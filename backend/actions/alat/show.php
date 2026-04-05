<?php
require_once __DIR__ . '/../../../config/connection.php';

// Validasi parameter ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('ID alat tidak ditemukan');
}

$id = (int) $_GET['id'];

// Query ambil data alat + kategori + harga
$query = "
    SELECT 
        alat.id_alat,
        alat.nama_alat,
        alat.gambar,
        alat.id_kategori,
        alat.stok,
        alat.harga,
        kategori.nama_kategori
    FROM alat
    LEFT JOIN kategori 
        ON alat.id_kategori = kategori.id_kategori
    WHERE alat.id_alat = $id
";

$result = mysqli_query($connect, $query);

// Cek query
if (!$result) {
    die('Query error: ' . mysqli_error($connect));
}

// Ambil data
$alat = mysqli_fetch_object($result);

// Validasi data
if (!$alat) {
    die('Data alat tidak ditemukan');
}
?>