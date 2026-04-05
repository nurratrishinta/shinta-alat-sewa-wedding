<?php
require_once __DIR__ . '/../../../config/connection.php';

$id = (int)($_GET['id'] ?? 0);

if ($id == 0) die('ID kosong');

mysqli_query($connect, "
UPDATE peminjaman 
SET status='Ditolak'
WHERE id_pinjam=$id
") or die(mysqli_error($connect));

header("Location: ../../pages/persetujuan_peminjaman/index.php");
exit;
?>