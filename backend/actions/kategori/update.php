<?php
require_once __DIR__ . '/../../../config/connection.php';

if (!isset($_POST['simpan'])) {
    die('Akses tidak valid');
}

$id_kategori   = (int) $_POST['id_kategori'];
$nama_kategori = mysqli_real_escape_string($connect, $_POST['nama_kategori']);

$query = "UPDATE kategori 
          SET nama_kategori = '$nama_kategori' 
          WHERE id_kategori = $id_kategori";

if (mysqli_query($connect, $query)) {
    echo "<script>
            alert('Data Kategori Berhasil Diubah');
            window.location.href='../../pages/kategori/index.php';
          </script>";
} else {
    echo "<script>
            alert('Data Kategori Gagal Diubah');
            window.history.back();
          </script>";
}
?>