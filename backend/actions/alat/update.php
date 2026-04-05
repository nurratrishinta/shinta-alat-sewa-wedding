<?php
require_once __DIR__ . '/../../../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Akses tidak valid');
}

// ================= AMBIL DATA =================
$id_alat     = (int) ($_POST['id_alat'] ?? 0);
$nama_alat   = trim($_POST['nama_alat'] ?? '');
$id_kategori = (int) ($_POST['id_kategori'] ?? 0);
$stok        = (int) ($_POST['stok'] ?? 0);
$harga       = (int) ($_POST['harga'] ?? 0);

// ================= VALIDASI =================
if ($id_alat === 0 || $nama_alat === '' || $id_kategori === 0 || $harga <= 0) {
    echo "<script>
        alert('Data tidak valid');
        history.back();
    </script>";
    exit;
}

// ================= FOLDER GAMBAR =================
$folder = __DIR__ . '/../../../storages/alat/';

// ================= AMBIL DATA LAMA =================
$qShow = mysqli_query(
    $connect,
    "SELECT gambar FROM alat WHERE id_alat = $id_alat"
);

$alat = mysqli_fetch_object($qShow);
$imageNew = $alat->gambar ?? null;

// ================= UPLOAD GAMBAR BARU =================
if (!empty($_FILES['gambar']['name'])) {

    // Hapus gambar lama
    if (!empty($imageNew) && file_exists($folder . $imageNew)) {
        unlink($folder . $imageNew);
    }

    $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
    $imageNew = time() . '-' . uniqid() . '.' . $ext;

    move_uploaded_file(
        $_FILES['gambar']['tmp_name'],
        $folder . $imageNew
    );
}

// ================= UPDATE DATABASE =================
$qUpdate = "
    UPDATE alat SET
        nama_alat   = '$nama_alat',
        id_kategori = '$id_kategori',
        harga       = '$harga',
        stok        = '$stok',
        gambar      = '$imageNew'
    WHERE id_alat = '$id_alat'
";

$result = mysqli_query($connect, $qUpdate);

if ($result) {
    echo "
        <script>
            alert('Data alat berhasil diubah!');
            window.location.href='../../pages/alat/index.php';
        </script>
    ";
} else {
    echo "
        <script>
            alert('Gagal mengubah data!');
            window.location.href='../../pages/alat/edit.php?id=$id_alat';
        </script>
    ";
}
?>