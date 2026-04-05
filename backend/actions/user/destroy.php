<?php
require_once __DIR__ . '/../../../config/connection.php';

if (!isset($_GET['id'])) {
    echo "<script>
        alert('ID tidak ditemukan');
        window.location.href='../../pages/user/index.php';
    </script>";
    exit;
}

$id = (int) $_GET['id'];

$query = "DELETE FROM users WHERE id_user = $id";

if (mysqli_query($connect, $query)) {
    echo "<script>
        alert('User berhasil dihapus');
        window.location.href='../../pages/user/index.php';
    </script>";
} else {
    echo "<script>
        alert('Gagal menghapus user');
        window.location.href='../../pages/user/index.php';
    </script>";
}
?>