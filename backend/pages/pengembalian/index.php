<?php
include '../../partials/header.php';
include '../../partials/sidenav.php';
include '../../partials/navbar.php';
require_once __DIR__ . '/../../../config/connection.php';

/* =========================
   QUERY DATA
========================= */

$query = "SELECT 
            pg.id_kembali,
            pg.id_pinjam,
            pg.tgl_pengembalian,
            pg.kondisi_alat,
            pg.deskripsi,
            pg.denda,
            u.nama AS nama_user,
            GROUP_CONCAT(a.nama_alat SEPARATOR ', ') AS nama_alat
          FROM pengembalian pg
          
          JOIN peminjaman p 
          ON pg.id_pinjam = p.id_pinjam
          
          JOIN users u 
          ON p.id_user = u.id_user
          
          JOIN detail_peminjaman dp 
          ON p.id_pinjam = dp.id_pinjam
          
          JOIN alat a 
          ON dp.id_alat = a.id_alat
          
          GROUP BY pg.id_kembali
          ORDER BY pg.id_kembali DESC";

$result = mysqli_query($connect, $query);
?>

<div class="row">
    <div class="col-12">

        <div class="card my-4">

            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-info shadow-info border-radius-lg pt-4 pb-3 d-flex justify-content-between px-3">

                    <h6 class="text-white text-capitalize ps-3">
                        Data Pengembalian Alat
                    </h6>

                    <a href="./create.php" class="btn btn-dark btn-sm me-3">
                        Input Pengembalian
                    </a>

                </div>
            </div>

            <div class="card-body px-0 pb-2">
                <div class="table-responsive p-0">

                    <table class="table align-items-center mb-0">

                        <thead>

                            <tr>

                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    No
                                </th>

                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    User & Alat
                                </th>

                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Tgl Kembali
                                </th>

                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Aksi
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php
                            $no = 1;

                            while ($row = mysqli_fetch_object($result)) :
                            ?>

                                <tr>

                                    <td class="text-center text-sm">
                                        <?= $no++ ?>
                                    </td>

                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">

                                                <h6 class="mb-0 text-sm">
                                                    <?= $row->nama_alat ?>
                                                </h6>

                                                <p class="text-xs text-secondary mb-0">
                                                    Peminjam : <?= htmlspecialchars($row->nama_user) ?>
                                                </p>

                                            </div>
                                        </div>
                                    </td>

                                    <td class="align-middle text-center text-sm">
                                        <?= $row->tgl_pengembalian ?>
                                    </td>

                                    <td class="align-middle text-center">

                                        <a href="./detail.php?id=<?= $row->id_kembali ?>"
                                            class="btn btn-success btn-sm p-2">

                                            detail
                                            <i class="material-icons text-sm">visibility</i>

                                        </a>

                                        <a href="../../actions/pengembalian/destroy.php?id=<?= $row->id_kembali ?>"
                                            class="btn btn-danger btn-sm p-2"
                                            onclick="return confirm('Yakin ingin menghapus data ini?')">

                                            hapus
                                            <i class="material-icons text-sm">delete</i>

                                        </a>

                                    </td>

                                </tr>

                            <?php endwhile; ?>

                        </tbody>

                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php
include '../../partials/footer.php';
include '../../partials/script.php';
?>