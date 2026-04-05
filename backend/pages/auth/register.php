<?php
session_start();
require_once __DIR__ . '/../../../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama     = htmlspecialchars(trim($_POST['nama']));
    $email    = htmlspecialchars(trim($_POST['email']));
    $password = $_POST['password'];
    $role     = 'Peminjam';

    // Validasi kosong
    if ($nama == '' || $email == '' || $password == '') {

        echo "
        <script>
        alert('Semua data wajib diisi!');
        window.location.href='register.php';
        </script>
        ";
        exit;
    }

    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        echo "
        <script>
        alert('Format email tidak valid!');
        window.location.href='register.php';
        </script>
        ";
        exit;
    }

    // Cek email sudah ada
    $cek = mysqli_query($connect, "SELECT email FROM users WHERE email='$email'");

    if (mysqli_num_rows($cek) > 0) {

        echo "
        <script>
        alert('Email sudah terdaftar!');
        window.location.href='register.php';
        </script>
        ";
        exit;
    }

    // Simpan password apa adanya (Teks Biasa)
    $passwordSave = $password;

    // Insert data menggunakan $passwordSave
    $query = "INSERT INTO users (nama,email,password,role)
          VALUES ('$nama','$email','$passwordSave','$role')";
    if (mysqli_query($connect, $query)) {

        echo "
        <script>
        alert('Registrasi berhasil, silakan login');
     window.location.href='../../actions/auth/login.php';
        </script>
        ";
        exit;
    } else {

        echo "
        <script>
        alert('Registrasi gagal : " . mysqli_error($connect) . "');
        window.location.href='register.php';
        </script>
        ";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register | Sewa Alat Wedding</title>

    <link rel="icon" type="image/png"
        href="../../templates-admin/material-dashboard-2/assets/img/1setwedding.webp">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background: url('../../templates-admin/material-dashboard-2/assets/img/1setwedding.webp') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Poppins', sans-serif;
        }

        .register-card {
            width: 400px;
            border-radius: 15px;
            background: linear-gradient(160deg, #b0b9ff, #e7eafc);
            color: #1e293b;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.25);
        }

        .btn-register {
            background: linear-gradient(90deg, #2563eb, #1e40af);
            color: white;
            font-weight: 600;
            border-radius: 8px;
            border: none;
            padding: 10px;
        }

        .btn-register:hover {
            background: linear-gradient(90deg, #1e40af, #2563eb);
            color: white;
        }

        .input-group-text {
            cursor: pointer;
            background: white;
        }
    </style>

</head>

<body>

    <div class="card register-card p-4">

        <div class="text-center">

            <img src="../../templates-admin/material-dashboard-2/assets/img/1setwedding.webp"
                class="mx-auto mb-3" width="70">

            <h4 class="fw-bold mb-1">
                Daftar Akun Baru
            </h4>

            <p class="text-muted small">
                Lengkapi data untuk menyewa alat wedding
            </p>

        </div>

        <form method="POST" class="mt-3">

            <div class="mb-3">

                <label class="form-label small fw-bold">
                    Nama
                </label>

                <input type="text"
                    name="nama"
                    class="form-control"
                    placeholder="Masukkan nama"
                    required>

            </div>

            <div class="mb-3">

                <label class="form-label small fw-bold">
                    Email
                </label>

                <input type="email"
                    name="email"
                    class="form-control"
                    placeholder="contoh@mail.com"
                    required>

            </div>

            <div class="mb-4">

                <label class="form-label small fw-bold">
                    Password
                </label>

                <div class="input-group">

                    <input type="password"
                        name="password"
                        id="passwordInput"
                        class="form-control"
                        placeholder="Minimal 6 karakter"
                        required>

                    <span class="input-group-text"
                        id="togglePassword">

                        <i class="fa fa-eye"
                            id="eyeIcon"></i>

                    </span>

                </div>

            </div>

            <button type="submit"
                class="btn btn-register w-100 mb-3">

                Daftar Sekarang

            </button>

            <div class="text-center">

                <span class="small">
                    Sudah punya akun?
                </span>

                <a class="text-primary fw-bold small text-decoration-none"
                    href="login.php">

                    Login di sini

                </a>

            </div>

        </form>

    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#passwordInput');
        const eyeIcon = document.querySelector('#eyeIcon');

        togglePassword.addEventListener('click', function() {

            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');

        });
    </script>

</body>

</html>