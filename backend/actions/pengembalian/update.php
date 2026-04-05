<?php
session_start();
require_once __DIR__ . '/../../../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    die("Akses tidak valid");
}

/* =========================
   AMBIL DATA
========================= */

$id_kembali = $_POST['id_kembali'];
$kondisi = $_POST['kondisi_alat'];
$deskripsi = $_POST['deskripsi'];
$denda = $_POST['denda'];

/* =========================
   UPDATE DATA
========================= */

$update = mysqli_query($connect, "
UPDATE pengembalian
SET
kondisi_alat = '$kondisi',
deskripsi = '$deskripsi',
denda = '$denda'
WHERE id_kembali = '$id_kembali'
");

if ($update) {

    echo "
    <script>
    alert('Data pengembalian berhasil diperbarui');
    window.location='../../pages/pengembalian/index.php';
    </script>
    ";
} else {

    echo "
    <script>
    alert('Gagal mengupdate data');
    history.back();
    </script>
    ";
}
?>