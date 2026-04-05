<?php
require_once __DIR__ . '/../../../config/connection.php';

$id = (int)($_GET['id'] ?? 0);

mysqli_begin_transaction($connect);

try {

    // ambil semua alat yang dipinjam
    $q = mysqli_query($connect, "
    SELECT id_alat, jumlah
    FROM detail_peminjaman
    WHERE id_pinjam=$id
    ");

    while ($data = mysqli_fetch_assoc($q)) {

        $id_alat = $data['id_alat'];
        $jumlah  = $data['jumlah'];

        mysqli_query($connect, "
        UPDATE alat 
        SET stok = stok + $jumlah
        WHERE id_alat=$id_alat
        ");
    }

    // ubah status peminjaman
    mysqli_query($connect, "
    UPDATE peminjaman 
    SET status='Dikembalikan'
    WHERE id_pinjam=$id
    ");

    mysqli_commit($connect);
} catch (Exception $e) {

    mysqli_rollback($connect);
    die('Gagal mengembalikan alat');
}

header("Location: ../../pages/persetujuan_peminjaman/index.php");
exit;
?>