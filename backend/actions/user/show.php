<?php
require_once __DIR__ . '/../../../config/connection.php';

if (!isset($_GET['id'])) {
    die('ID tidak ditemukan');
}

$id = (int) $_GET['id'];

$query = "SELECT * FROM users WHERE id_user = $id";
$result = mysqli_query($connect, $query);
$user = mysqli_fetch_object($result);

if (!$user) {
    die('Data user tidak ditemukan');
}
?>