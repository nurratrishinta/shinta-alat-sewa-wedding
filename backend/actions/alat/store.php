<?php
require_once __DIR__ . '/../../../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Akses tidak valid');
}

// ================= AMBIL DATA =================
$nama_alat   = trim($_POST['nama_alat'] ?? '');
$id_kategori = (int) ($_POST['id_kategori'] ?? 0);
$stok        = (int) ($_POST['stok'] ?? 0);
$harga       = (int) ($_POST['harga'] ?? 0);

// ================= VALIDASI =================
if ($nama_alat === '' || $id_kategori === 0 || $harga <= 0) {
    echo "<script>
        alert('Data tidak valid');
        history.back();
    </script>";
    exit;
}

// ================= UPLOAD GAMBAR =================
$namaFile = null;

if (!empty($_FILES['gambar']['name'])) {

    $folder = __DIR__ . '/../../../storages/alat/';

    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
    $namaFile = time() . '-' . uniqid() . '.' . $ext;

    move_uploaded_file($_FILES['gambar']['tmp_name'], $folder . $namaFile);
}

// ================= INSERT DATABASE =================
$query = "
    INSERT INTO alat (nama_alat, id_kategori, harga, stok, gambar)
    VALUES ('$nama_alat', '$id_kategori', '$harga', '$stok', '$namaFile')
";

if (mysqli_query($connect, $query)) {
    echo "<script>
        alert('Data alat berhasil ditambahkan');
        location.href='../../pages/alat/index.php';
    </script>";
} else {
    echo "<script>
        alert('Gagal menambah data');
        history.back();
    </script>";
}
?>