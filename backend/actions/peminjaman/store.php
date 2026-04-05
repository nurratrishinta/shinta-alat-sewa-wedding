<?php
session_start();
require_once __DIR__ . '/../../../config/connection.php';

if (!isset($_SESSION['id_user'])) {
  header("Location: ../../pages/auth/login.php");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  die("Akses tidak valid");
}

$id_user = $_SESSION['id_user'];

$tgl_pinjam  = $_POST['tgl_pinjam'] ?? '';
$tgl_kembali = $_POST['tgl_kembali'] ?? '';

$alamat  = $_POST['alamat_peminjam'] ?? '';
$telepon = $_POST['no_telepon'] ?? '';

$metode = $_POST['metode_pembayaran'] ?? '';
$total  = $_POST['total_harga'] ?? 0;

$id_alat = $_POST['id_alat'] ?? [];
$jumlah  = $_POST['jumlah_pinjam'] ?? [];

/* VALIDASI */

if (!$tgl_pinjam || !$tgl_kembali) {
  die("Tanggal tidak boleh kosong");
}

if (empty($id_alat)) {
  die("Barang belum dipilih");
}

mysqli_begin_transaction($connect);

try {

  /* INSERT PEMINJAMAN */

  $query = mysqli_query($connect, "
        INSERT INTO peminjaman
        (id_user,alamat_peminjam,no_telepon,tgl_pinjam,tgl_kembali,total_harga,metode_pembayaran,status)
        VALUES
        ('$id_user','$alamat','$telepon','$tgl_pinjam','$tgl_kembali','$total','$metode','Menunggu')
    ");

  if (!$query) {
    throw new Exception(mysqli_error($connect));
  }

  $id_pinjam = mysqli_insert_id($connect);

  /* DETAIL PEMINJAMAN */

  foreach ($id_alat as $key => $alat) {

    $qty = isset($jumlah[$key]) ? (int)$jumlah[$key] : 0;

    if ($qty <= 0) continue;

    $cek = mysqli_query($connect, "
            SELECT stok
            FROM alat
            WHERE id_alat='$alat'
        ");

    $data = mysqli_fetch_assoc($cek);

    if (!$data) {
      throw new Exception("Alat tidak ditemukan");
    }

    if ($data['stok'] < $qty) {
      throw new Exception("Stok tidak cukup");
    }

    /* INSERT DETAIL */

    $insert = mysqli_query($connect, "
            INSERT INTO detail_peminjaman
            (id_pinjam,id_alat,jumlah)
            VALUES
            ('$id_pinjam','$alat','$qty')
        ");

    if (!$insert) {
      throw new Exception(mysqli_error($connect));
    }

    /* UPDATE STOK */

    $update = mysqli_query($connect, "
            UPDATE alat
            SET stok = stok - $qty
            WHERE id_alat='$alat'
        ");

    if (!$update) {
      throw new Exception(mysqli_error($connect));
    }
  }

  /* LOG */

  $aktivitas = "Menambahkan peminjaman ID $id_pinjam";

  mysqli_query($connect, "
        INSERT INTO log_aktivitas
        (id_user,aktivitas,created_at)
        VALUES
        ('$id_user','$aktivitas',NOW())
    ");

  mysqli_commit($connect);

  echo "<script>
        alert('Peminjaman berhasil dibuat');
        window.location.href='../../pages/peminjaman/index.php';
    </script>";
} catch (Exception $e) {

  mysqli_rollback($connect);

  die("Terjadi kesalahan : " . $e->getMessage());
}
?>