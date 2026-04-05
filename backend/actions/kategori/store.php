<?php
require_once __DIR__ . '/../../../config/connection.php';

if (!isset($_POST['simpan'])) {
    die('Akses tidak valid');
}

$nama_kategori = trim($_POST['nama_kategori'] ?? '');

if ($nama_kategori === '') {
    echo "<script>
            alert('Nama kategori tidak boleh kosong');
            window.history.back();
          </script>";
    exit;
}

$nama_kategori = mysqli_real_escape_string($connect, $nama_kategori);

$query = "INSERT INTO kategori (nama_kategori)
          VALUES ('$nama_kategori')";

if (mysqli_query($connect, $query)) {
    echo "<script>
            alert('Kategori berhasil ditambahkan');
            window.location.href='../../pages/kategori/index.php';
          </script>";
} else {
    echo "<script>
            alert('Gagal menyimpan kategori');
            window.history.back();
          </script>";
}
?>
