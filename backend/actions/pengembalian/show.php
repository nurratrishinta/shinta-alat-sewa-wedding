<?php
require_once __DIR__ . '/../../../config/connection.php';

if (!isset($_GET['id'])) {
    die('ID pengembalian tidak ditemukan');
}

$id = (int) $_GET['id']; // id_kembali

$query = "
    SELECT 
        pg.*,
        p.tgl_pinjam,
        u.username,
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
    
    GROUP BY pg.id_kembali
";

$result = mysqli_query($connect, $query);

if (!$result) {
    die(mysqli_error($connect));
}

$pengembalian = mysqli_fetch_object($result);

if (!$pengembalian) {
    die('Data pengembalian tidak ditemukan');
}

// Data sekarang bisa digunakan di file detail
?>