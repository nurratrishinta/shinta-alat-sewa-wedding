<?php
session_start();

include '../../partials/header.php';
include '../../partials/sidenav.php';
include '../../partials/navbar.php';

require_once __DIR__ . '/../../../config/connection.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: ../../../login.php");
    exit;
}

$idLogin = $_SESSION['id_user'];

/* =========================
   QUERY DATA PEMINJAMAN
========================= */

$query = mysqli_query($connect, "
SELECT 
dp.id_detail,
dp.jumlah,
p.id_pinjam,
u.nama AS nama_user,
a.nama_alat

FROM detail_peminjaman dp

JOIN peminjaman p 
ON dp.id_pinjam = p.id_pinjam

JOIN users u 
ON p.id_user = u.id_user

JOIN alat a 
ON dp.id_alat = a.id_alat

WHERE p.status='Disetujui'
AND p.id_user='$idLogin'
");

?>

<div class="row justify-content-center">

    <div class="col-lg-8">

        <div class="card my-4">

            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">

                <div class="bg-gradient-success shadow-success border-radius-lg pt-4 pb-3">

                    <h6 class="text-white text-capitalize ps-3">
                        Form Pengembalian Barang
                    </h6>

                </div>
            </div>

            <div class="card-body">

                <?php if (mysqli_num_rows($query) == 0): ?>

                    <div class="alert alert-info">
                        Tidak ada barang yang perlu dikembalikan
                    </div>

                <?php else: ?>

                    <form action="../../actions/pengembalian/store.php" method="POST">

                        <?php while ($row = mysqli_fetch_object($query)): ?>

                            <hr>

                            <h6 class="mb-3">
                                <?= htmlspecialchars($row->nama_alat) ?>
                                <br>
                                <span class="text-sm text-secondary">
                                    Peminjam : <?= htmlspecialchars($row->nama_user) ?>
                                </span>
                            </h6>

                            <?php for ($i = 1; $i <= $row->jumlah; $i++): ?>

                                <div class="border rounded p-3 mb-3">

                                    <input type="hidden" name="id_pinjam[]" value="<?= $row->id_pinjam ?>">

                                    <label class="form-label">
                                        Kondisi Barang <?= $i ?>
                                    </label>

                                    <select name="kondisi_alat[]" class="form-control kondisi" required>

                                        <option value="">Pilih Kondisi</option>

                                        <option value="Baik">
                                            Baik
                                        </option>

                                        <option value="Rusak Ringan">
                                            Rusak Ringan
                                        </option>

                                        <option value="Rusak Berat">
                                            Rusak Berat
                                        </option>

                                    </select>

                                    <div class="deskripsi-rusak mt-3" style="display:none;">

                                        <label class="form-label">
                                            Deskripsi Kerusakan
                                        </label>

                                        <textarea
                                            name="deskripsi[]"
                                            class="form-control"
                                            rows="3"
                                            placeholder="Jelaskan kerusakan barang"></textarea>

                                    </div>

                                </div>

                            <?php endfor; ?>

                        <?php endwhile; ?>

                        <div class="text-end">

                            <button class="btn bg-gradient-success">

                                <i class="material-icons text-sm">save</i>
                                Simpan Pengembalian

                            </button>

                            <a href="index.php" class="btn btn-light">
                                Batal
                            </a>

                        </div>

                    </form>

                <?php endif; ?>

            </div>

        </div>

    </div>

</div>

<script>
    /* =========================
   SCRIPT KONDISI RUSAK
========================= */

    document.querySelectorAll('.kondisi').forEach(function(select) {

        select.addEventListener('change', function() {

            let parent = this.closest('.border');
            let deskripsi = parent.querySelector('.deskripsi-rusak');

            if (this.value === "Rusak Ringan" || this.value === "Rusak Berat") {

                deskripsi.style.display = "block";

            } else {

                deskripsi.style.display = "none";

            }

        });

    });
</script>

<?php
include '../../partials/footer.php';
include '../../partials/script.php';
?>