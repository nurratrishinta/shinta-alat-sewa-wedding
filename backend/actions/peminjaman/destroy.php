<?php
require_once __DIR__ . '/../../../config/connection.php';

if (!isset($_GET['id'])) {
    echo "<script>
            alert('ID peminjaman tidak ditemukan');
            window.location.href='../../pages/peminjaman/index.php';
          </script>";
    exit;
}

$id = (int) $_GET['id'];

// Cek apakah sedang dipakai di tabel pengembalian
$check = mysqli_query($connect, "SELECT * FROM pengembalian WHERE id_pinjam = $id");

if (mysqli_num_rows($check) > 0) {
    echo "<script>
            alert('Peminjaman tidak bisa dihapus karena sudah memiliki data pengembalian!');
            window.location.href='../../pages/peminjaman/index.php';
          </script>";
    exit;
}

// Jika tidak dipakai → hapus
$query = "DELETE FROM peminjaman WHERE id_pinjam = $id";

if (mysqli_query($connect, $query)) {
    echo "<script>
            alert('Data peminjaman berhasil dihapus');
            window.location.href='../../pages/peminjaman/index.php';
          </script>";
} else {
    echo "<script>
            alert('Data peminjaman gagal dihapus');
            window.location.href='../../pages/peminjaman/index.php';
          </script>";
}
?>
