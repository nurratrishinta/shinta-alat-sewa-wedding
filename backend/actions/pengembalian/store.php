<?php
session_start();
require_once __DIR__ . '/../../../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    die("Akses tidak valid");
}

$id_pinjam = $_POST['id_pinjam'] ?? [];
$kondisi = $_POST['kondisi_alat'] ?? [];
$deskripsi = $_POST['deskripsi'] ?? [];

if (empty($id_pinjam)) {
    echo "<script>alert('Data tidak lengkap');history.back();</script>";
    exit;
}

$total = count($id_pinjam);

for ($i = 0; $i < $total; $i++) {

    $idPinjam = mysqli_real_escape_string($connect, $id_pinjam[$i]);
    $kondisiAlat = mysqli_real_escape_string($connect, $kondisi[$i]);
    $desk = mysqli_real_escape_string($connect, $deskripsi[$i] ?? '');

    $tgl = date('Y-m-d');

    $denda = 0; // denda default

    /* SIMPAN DATA PENGEMBALIAN */

    $insert = mysqli_query($connect, "
INSERT INTO pengembalian
(id_pinjam,tgl_pengembalian,kondisi_alat,deskripsi,denda)
VALUES
('$idPinjam','$tgl','$kondisiAlat','$desk','$denda')
");

    if (!$insert) {
        die(mysqli_error($connect));
    }

    /* UPDATE STATUS PEMINJAMAN */

    mysqli_query($connect, "
UPDATE peminjaman
SET status='Dikembalikan'
WHERE id_pinjam='$idPinjam'
");

    /* KEMBALIKAN STOK */

    $detail = mysqli_query($connect, "
SELECT id_alat,jumlah
FROM detail_peminjaman
WHERE id_pinjam='$idPinjam'
");

    while ($d = mysqli_fetch_assoc($detail)) {

        $id_alat = $d['id_alat'];
        $jumlah = $d['jumlah'];

        mysqli_query($connect, "
UPDATE alat
SET stok = stok + $jumlah
WHERE id_alat='$id_alat'
");
    }
}

echo "
<script>
alert('Pengembalian berhasil disimpan');
window.location='../../pages/pengembalian/index.php';
</script>
";
?>  