<?php
require_once __DIR__ . '/../../../config/connection.php';

mysqli_report(MYSQLI_REPORT_OFF);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Akses tidak valid');
}

$nama     = mysqli_real_escape_string($connect, trim($_POST['nama']));
$password = $_POST['password'];
$role     = mysqli_real_escape_string($connect, $_POST['role']);

if ($nama === '' || $password === '' || $role === '') {
    echo "<script>alert('Data tidak valid');history.back();</script>";
    exit;
}

// hash password
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

// cek nama sudah ada atau belum
$cekUser = mysqli_query($connect, "SELECT nama FROM users WHERE nama = '$nama'");

if (mysqli_num_rows($cekUser) > 0) {
    echo "<script>
        alert('Nama user sudah terdaftar!');
        history.back();
    </script>";
    exit;
}

// simpan user
$query = "INSERT INTO users (nama, password, role)
          VALUES ('$nama','$passwordHash','$role')";

if (mysqli_query($connect, $query)) {

    echo "<script>
        alert('User berhasil ditambahkan');
        location.href='../../pages/user/index.php';
    </script>";
} else {

    echo "<script>
        alert('Gagal menambah user');
        history.back();
    </script>";
}
?>