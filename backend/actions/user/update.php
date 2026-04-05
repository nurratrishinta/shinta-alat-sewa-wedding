<?php
require_once __DIR__ . '/../../../config/connection.php';

$id_user = (int) $_POST['id_user'];
$nama    = trim($_POST['nama']);
$password = $_POST['password'];
$role     = $_POST['role'];

if ($nama === '' || $role === '') {
    echo "<script>alert('Data tidak valid');history.back();</script>";
    exit;
}

// jika password diisi → update password
if (!empty($password)) {

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $query = "
        UPDATE users SET
            nama     = '$nama',
            password = '$passwordHash',
            role     = '$role'
        WHERE id_user = '$id_user'
    ";
} else {

    // jika password kosong → tidak diubah
    $query = "
        UPDATE users SET
            nama = '$nama',
            role = '$role'
        WHERE id_user = '$id_user'
    ";
}

if (mysqli_query($connect, $query)) {

    echo "<script>
        alert('User berhasil diubah');
        window.location.href='../../pages/user/index.php';
    </script>";
} else {

    echo "<script>
        alert('Gagal mengubah user');
        history.back();
    </script>";
}
?>