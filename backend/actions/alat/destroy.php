<?php
require_once __DIR__ . '/../../../config/connection.php';

if (!isset($_GET['id'])) {
    echo "<script>
            alert('ID tidak ditemukan');
            window.location.href='../../pages/alat/index.php';
          </script>";
    exit;
}

$id = (int) $_GET['id'];

// cek apakah alat sedang dipakai di peminjaman
$check = mysqli_query($connect, "SELECT * FROM peminjaman WHERE id_alat = $id");

if (mysqli_num_rows($check) > 0) {
    echo "<script>
            alert('Alat tidak dapat dihapus karena masih dipinjam atau pernah digunakan dalam transaksi peminjaman.');
            window.location.href='../../pages/alat/index.php';
          </script>";
    exit;
}

// jika tidak dipakai → hapus
$query = "DELETE FROM alat WHERE id_alat = $id";

if (mysqli_query($connect, $query)) {
    echo "<script>
            alert('Data alat berhasil dihapus');
            window.location.href='../../pages/alat/index.php';
          </script>";
} else {
    echo "<script>
            alert('Gagal menghapus data');
            window.location.href='../../pages/alat/index.php';
          </script>";
}
?>
  