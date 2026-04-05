<?php
session_start();
require_once __DIR__ . '/../../../config/connection.php';

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $query = "UPDATE peminjaman 
              SET status='Disetujui' 
              WHERE id_pinjam='$id'";

    if (mysqli_query($connect, $query)) {

        $_SESSION['success'] = "Peminjaman berhasil disetujui";
    } else {

        $_SESSION['error'] = "Gagal menyetujui peminjaman";
    }
}

header("Location: ../../pages/peminjaman/index.php");
exit();
?>