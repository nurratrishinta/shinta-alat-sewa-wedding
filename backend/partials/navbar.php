<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <!-- Sidebar (tetap) -->

    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg shadow-none custom-navbar" id="navbarBlur" navbar-scroll="true">
        <div class="container-fluid py-1 px-3 d-flex justify-content-between align-items-center">

            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb"></nav>

            <div class="d-flex align-items-center gap-4">
                <!-- Hari, Tanggal & Jam -->
                <div class="text-white fw-bold" id="datetime"></div>

                <!-- Profile dropdown -->
                <div class="nav-item dropdown">
                    <a id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                        <img src="../../templates-admin/material-dashboard-2/assets/img/icon.jpg"
                            width="40" height="40"
                            class="rounded-circle"
                            style="object-fit: cover;">
                    </a>
                    <?php
                    $username = $_SESSION['username'] ?? 'User';
                    $role     = ucfirst($_SESSION['role'] ?? '');
                    ?>

                    <ul class="dropdown-menu dropdown-menu-end shadow" style="min-width:200px">

                        <li class="px-3 py-2 text-center">
                            <strong><?= $username ?></strong><br>
                            <small class="text-muted"><?= $role ?></small>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a href="../../actions/auth/logout.php" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </a>
                        </li>

                    </ul>

                </div>
            </div>
        </div>
    </nav>

    <!-- JS untuk Tanggal & Jam -->
    <script>
        function updateDateTime() {
            const now = new Date();
            const days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
            const months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
                "Juli", "Agustus", "September", "Oktober", "November", "Desember"
            ];

            const dayName = days[now.getDay()];
            const day = now.getDate();
            const month = months[now.getMonth()];
            const year = now.getFullYear();

            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');

            document.getElementById("datetime").innerHTML =
                `${dayName}, ${day} ${month} ${year} | ${hours}:${minutes}:${seconds}`;
        }

        setInterval(updateDateTime, 1000);
        updateDateTime();
    </script>

    <!-- Main Content -->
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- isi halaman -->
    </main>


    <!-- CSS -->
    <style>
        .custom-navbar {
            background: linear-gradient(90deg, rgb(240, 157, 190), #6a1b9a);
            /* Sama kayak sidebar */
            color: white !important;
        }

        .custom-navbar strong,
        .custom-navbar small {
            color: white !important;
        }

        .custom-navbar .dropdown-menu {
            background-color: #fff;
            /* Dropdown tetap putih */
        }

        .custom-navbar {
            background: linear-gradient(90deg, rgb(7, 10, 160), #6a1b9a);
            color: white !important;
        }

        /* Teks di NAVBAR (tetap putih) */
        .custom-navbar strong,
        .custom-navbar small {
            color: white !important;
        }

        /* Teks di dalam DROPDOWN */
        .custom-navbar .dropdown-menu strong {
            color: #000 !important;
            /* Nama user jadi hitam */
            font-size: 0.95rem;
        }

        .custom-navbar .dropdown-menu small {
            color: #555 !important;
            /* Email jadi abu tua */
            font-size: 0.8rem;
        }
    </style>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>