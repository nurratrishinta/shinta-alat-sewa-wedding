<?php
session_start();
require_once __DIR__ . '/../../../config/connection.php';

$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($email === '' || $password === '') {
        $error = "Email dan password wajib diisi!";
    } else {

        $stmt = $connect->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if ($password === $user['password']) {

                $_SESSION['login']    = true;
                $_SESSION['id_user']  = $user['id_user'];
                $_SESSION['email']    = $user['email'];
                $_SESSION['nama']     = $user['nama'];
                $_SESSION['role']     = $user['role'];

                switch (strtolower($user['role'])) {
                    case 'admin':
                        $_SESSION['login_success'] = "Berhasil login sebagai Admin!";
                        header("Location: ../../pages/dashboard/index.php");
                        exit;

                    case 'petugas':
                        $_SESSION['login_success'] = "Berhasil login sebagai Petugas!";
                        header("Location: ../../pages/persetujuan_peminjaman/index.php");
                        exit;

                    case 'peminjam':
                        $_SESSION['login_success'] = "Berhasil login sebagai Peminjam!";
                        header("Location: ../../pages/melihat_daftar_alat/index.php");
                        exit;

                    default:
                        $_SESSION['login_success'] = "Login berhasil!";
                        header("Location: ../../pages/index.php");
                        exit;
                }
            } else {
                echo "
                <script> 
                alert('Password Salah');
                window.location.href='login.php';
                </script>
                ";
            }
        } else {
            echo "
            <script> 
            alert('Email Salah/Belum Terdaftar');
            window.location.href='login.php';
            </script>
            ";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login | Sewa Alat Wedding</title>

    <link rel="icon" type="image/png" sizes="128x128"
        href="../../templates-admin/material-dashboard-2/assets/img/1setwedding.webp">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- ICON MATA -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

        .login-card {
            width: 380px;
            border-radius: 15px;
            background: linear-gradient(160deg, #b0b9ff, #e7eafc);
            color: #1e293b;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.25);
        }

        .btn-login {
            background: linear-gradient(90deg, #2563eb, #1e40af);
            color: white;
            font-weight: 600;
            border-radius: 8px;
        }
    </style>
</head>

<body>

    <div class="card login-card p-4 text-center">

        <img src="../../templates-admin/material-dashboard-2/assets/img/1setwedding.webp"
            class="mx-auto mb-3" width="80">

        <h4 class="fw-bold mb-1">Selamat Datang Di Aplikasi Sewa Alat Wedding</h4>
        <p class="text-muted">Silakan login terlebih dahulu</p>

        <?php if ($error) : ?>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Login Gagal',
                    text: '<?= htmlspecialchars($error, ENT_QUOTES) ?>',
                    confirmButtonColor: '#2563eb'
                });
            </script>
        <?php endif; ?>

        <form method="POST">

            <div class="mb-3 text-start">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control"
                    value="<?= htmlspecialchars($email) ?>" required>
            </div>

            <!-- PASSWORD + ICON MATA -->
            <div class="mb-3 text-start">
                <label class="form-label">Password</label>

                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control" required>

                    <span class="input-group-text" onclick="togglePassword()" style="cursor:pointer;">
                        <i class="bi bi-eye" id="toggleIcon"></i>
                    </span>
                </div>
            </div>

            <button class="btn btn-login w-100">Login</button>

            <div class="text-center mt-3">
                <p class="mb-0 fw-bold">Belum punya akun?</p>
                <a class="text-primary fw-bold" href="./register.php">Buat Sekarang</a>
            </div>

        </form>

    </div>


    <script>
        function togglePassword() {

            var password = document.getElementById("password");
            var icon = document.getElementById("toggleIcon");

            if (password.type === "password") {
                password.type = "text";
                icon.classList.remove("bi-eye");
                icon.classList.add("bi-eye-slash");
            } else {
                password.type = "password";
                icon.classList.remove("bi-eye-slash");
                icon.classList.add("bi-eye");
            }

        }
    </script>

</body>

</html>