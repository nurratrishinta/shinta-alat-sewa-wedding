<?php
require_once __DIR__ . '/../../../config/connection.php';

if (!isset($_GET['id'])) {
    echo "<script>
            alert('ID tidak ditemukan');
            window.location.href='../../pages/kategori/index.php';
          </script>";
    exit;
}

$id = (int) $_GET['id'];

$query = "DELETE FROM kategori WHERE id_kategori = $id";

if (mysqli_query($connect, $query)) {
    echo "<script>
            alert('Kategori berhasil dihapus');
            window.location.href='../../pages/kategori/index.php';
          </script>";
} else {
    echo "<script>
            alert('Kategori gagal dihapus');
            window.location.href='../../pages/kategori/index.php';
          </script>";
}
?>