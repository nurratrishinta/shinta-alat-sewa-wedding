<?php
session_start();
// Sesuaikan path koneksi dengan struktur folder kamu
require_once __DIR__ . '/../../../config/connection.php';

if (!$connect) {
    $_SESSION['register_errors'] = ['system' => 'Koneksi database gagal: ' . mysqli_connect_error()];
    header('Location: ../../pages/auth/register.php');
    exit;
}

// Pastikan data dikirim via POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../pages/auth/register.php');
    exit;
}

$errors = [];

// Ambil dan bersihkan input
$nama     = trim($_POST['nama'] ?? '');
$email    = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm  = $_POST['confirm_password'] ?? '';
$role     = 'Peminjam';

// --- VALIDASI INPUT ---

if (empty($nama)) {
    $errors['nama'] = "Nama wajib diisi";
}

if (empty($email)) {
    $errors['email'] = "Email wajib diisi";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = "Format email tidak valid";
}

if (empty($password)) {
    $errors['password'] = "Password wajib diisi";
} elseif (strlen($password) < 6) {
    $errors['password'] = "Password minimal 6 karakter";
}

if ($password !== $confirm) {
    $errors['confirm_password'] = "Konfirmasi password tidak cocok";
}

// Jika ada error validasi, balik ke halaman register
if (!empty($errors)) {
    $_SESSION['register_errors'] = $errors;
    header('Location: ../../pages/auth/register.php');
    exit;
}

// --- CEK EMAIL DUPLIKAT ---

$sql_cek = "SELECT id_user FROM users WHERE email = ?";
$stmt_cek = mysqli_prepare($connect, $sql_cek);
mysqli_stmt_bind_param($stmt_cek, "s", $email);
mysqli_stmt_execute($stmt_cek);
mysqli_stmt_store_result($stmt_cek);

if (mysqli_stmt_num_rows($stmt_cek) > 0) {
    $_SESSION['register_errors'] = ['email' => 'Email sudah terdaftar'];
    header('Location: ../../pages/auth/register.php');
    exit;
}
mysqli_stmt_close($stmt_cek);

// --- PROSES PENYIMPANAN PASSWORD ---

/** * OPSI 1: Simpan apa adanya (Bisa dibaca di database) 
 * Gunakan ini jika kamu ingin sandinya langsung kelihatan.
 */
$passwordSave = $password;

/** * OPSI 2: Simpan dengan Hash (Keamanan Standar)
 * Gunakan ini jika ingin aman seperti data lain di gambarmu ($2y$10...).
 * Hapus komentar di bawah jika ingin beralih ke Hash.
 */
// $passwordSave = password_hash($password, PASSWORD_DEFAULT);


// --- INSERT KE DATABASE ---

$sql_insert = "INSERT INTO users (nama, email, password, role) VALUES (?, ?, ?, ?)";
$stmt_insert = mysqli_prepare($connect, $sql_insert);

// Bind parameter (s = string)
mysqli_stmt_bind_param($stmt_insert, "ssss", $nama, $email, $passwordSave, $role);

if (mysqli_stmt_execute($stmt_insert)) {
    // Berhasil
    $_SESSION['register_success'] = "Registrasi berhasil, silakan login";
    header('Location: ../../pages/auth/login.php');
    exit;
} else {
    // Gagal eksekusi
    $_SESSION['register_errors'] = ['system' => 'Gagal menyimpan data ke database'];
    header('Location: ../../pages/auth/register.php');
    exit;
}

mysqli_stmt_close($stmt_insert);
mysqli_close($connect);
?>