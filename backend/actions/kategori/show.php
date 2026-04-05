<?php
require_once __DIR__ . '/../../../config/connection.php';

if (!isset($_GET['id'])) {
    die('ID kategori tidak ditemukan');
}

$id = (int) $_GET['id'];

$query = "SELECT * FROM kategori WHERE id_kategori = $id";
$result = mysqli_query($connect, $query);

$kategori = mysqli_fetch_object($result);

if (!$kategori) {
    die('Data kategori tidak ditemukan');
}
?>
