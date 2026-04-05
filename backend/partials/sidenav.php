  <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // role bisa: admin | petugas | masyarakat
    $role = strtolower($_SESSION['role'] ?? '');

    // ambil file dan folder saat ini
    $current_file = basename($_SERVER['PHP_SELF']); // misal: index.php
    $current_dir  = basename(dirname($_SERVER['PHP_SELF'])); // misal: dashboard

    // helper fungsi untuk kasih class active
    function isActive($file, $dir = null)
    {
        global $current_file, $current_dir;
        if ($dir) {
            return ($current_file === $file && $current_dir === $dir) ? 'active' : '';
        }
        return ($current_file === $file) ? 'active' : '';
    }
    ?>


  <style>
      aside.sidenav .nav-link {
          color: white !important;
      }

      aside.sidenav .nav-link.active {
          background: rgba(192, 33, 139, 0.3);
          border-radius: 0.375rem;
      }

      aside.sidenav .material-icons {
          vertical-align: middle;
      }

      .sidebar-header {
          text-align: center;
          padding: 1rem;
      }

      .sidebar-header img {
          width: 80px;
          height: 80px;
          border-radius: 50%;
          border: 2px solid white;
      }

      .sidebar-header h5 {
          color: white;
          margin-top: .5rem;
          font-weight: bold;
      }
  </style>

  <aside class="sidenav navbar navbar-vertical navbar-expand-xs fixed-start ms-3 my-3"
      style="background: linear-gradient(180deg, rgb(38,34,233), rgb(105,109,163));">

      <div class="sidebar-header">
          <img src="../../templates-admin/material-dashboard-2/assets/img/1setwedding.webp">
          <h5>Sewa Alat Wedding</h5>
      </div>

      <hr class="horizontal light mt-0 mb-2">

      <div class="navbar-collapse h-auto show">
          <ul class="navbar-nav">

              

              <!-- ================= ADMIN ================= -->
              <?php if ($role === 'admin') : ?>

                  <li class="nav-item">
                      <a class="nav-link <?= isActive('index.php', 'dashboard') ?>"
                          href="../dashboard/index.php">
                          <i class="material-icons me-2">dashboard</i> Dashboard
                      </a>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link <?= isActive('index.php', 'user') ?>"
                          href="../user/index.php">
                          <i class="material-icons me-2">person</i> User
                      </a>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link <?= isActive('index.php', 'alat') ?>"
                          href="../alat/index.php">
                          <i class="material-icons me-2">build</i> Alat
                      </a>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link <?= isActive('index.php', 'kategori') ?>"
                          href="../kategori/index.php">
                          <i class="material-icons me-2">category</i> Kategori
                      </a>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link <?= isActive('index.php', 'peminjaman') ?>"
                          href="../peminjaman/index.php">
                          <i class="material-icons me-2">assignment</i> Peminjaman
                      </a>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link <?= isActive('index.php', 'pengembalian') ?>"
                          href="../pengembalian/index.php">
                          <i class="material-icons me-2">assignment_return</i> Pengembalian
                      </a>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link <?= isActive('index.php', 'log_aktivitas') ?>"
                          href="../log_aktivitas/index.php">
                          <i class="material-icons me-2">history</i> Log Aktivitas
                      </a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link <?= isActive('laporan.php', 'laporan_peminjaman') ?>"
                          href="../laporan_peminjaman/laporan.php">
                          <i class="material-icons me-2">description</i> Laporan
                      </a>
                  </li>

              <?php endif; ?>



              <!-- ================= PETUGAS ================= -->
              <?php if ($role === 'petugas') : ?>

                  <li class="nav-item">
                      <a class="nav-link <?= isActive('index.php', 'persetujuan_peminjaman') ?>"
                          href="../persetujuan_peminjaman/index.php">
                          <i class="material-icons me-2">check_circle</i> Persetujuan
                      </a>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link <?= isActive('index.php', 'pengembalian') ?>"
                          href="../pengembalian/index.php">
                          <i class="material-icons me-2">assignment_return</i> Pantau Pengembalian
                      </a>
                  </li>


                  
                  <li class="nav-item">
                      <a class="nav-link <?= isActive('laporan.php', 'laporan_peminjaman') ?>"
                          href="../laporan_peminjaman/laporan.php">
                          <i class="material-icons me-2">description</i> Laporan
                      </a>
                  </li>


              <?php endif; ?>


              <!-- ================= PEMINJAM ================= -->
              <?php if ($role === 'peminjam') : ?>

                  <li class="nav-item">
                      <a class="nav-link <?= isActive('index.php', 'melihat_daftar_alat') ?>"
                          href="../melihat_daftar_alat/index.php">
                          <i class="material-icons me-2">list</i> Daftar Alat
                      </a>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link <?= isActive('index.php', 'peminjaman') ?>"
                          href="../peminjaman/index.php">
                          <i class="material-icons me-2">add_circle</i> Ajukan Peminjaman
                      </a>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link <?= isActive('index.php', 'pengembalian') ?>"
                          href="../pengembalian/index.php">
                          <i class="material-icons me-2">keyboard_return</i> Pengembalian
                      </a>
                  </li>

              <?php endif; ?>


          </ul>
      </div>
  </aside>