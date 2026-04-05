<?php
session_start();

include '../../partials/header.php';
include '../../partials/sidenav.php';
include '../../partials/navbar.php';
require_once __DIR__ . '/../../../config/connection.php';

$idLogin   = $_SESSION['id_user'] ?? '';
$namaLogin = $_SESSION['nama'] ?? '';

// ambil data alat
$alat = mysqli_query($connect, "SELECT * FROM alat ORDER BY nama_alat ASC");

if (!$alat) {
    die(mysqli_error($connect));
}
?>

<div class="card">

    <div class="card-header">
        <h5>Tambah Peminjaman</h5>
    </div>

    <div class="card-body">

        <form action="../../actions/peminjaman/store.php" method="POST">

            <input type="hidden" name="id_user" value="<?= $idLogin ?>">

            <!-- USER -->
            <div class="mb-3">
                <label class="form-label">User</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($namaLogin) ?>" readonly>
            </div>

            <!-- ALAMAT -->
            <div class="mb-3">
                <label class="form-label">Alamat Peminjam</label>
                <textarea name="alamat_peminjam" class="form-control" rows="3" required></textarea>
            </div>

            <!-- TELEPON -->
            <div class="mb-3">
                <label class="form-label">Nomor Telepon</label>
                <input type="text" name="no_telepon" class="form-control" placeholder="08123456789" required>
            </div>

            <!-- BARANG -->
            <div class="mb-3">

                <label class="form-label">Barang yang Dipinjam</label>

                <table class="table table-bordered" id="table-alat">

                    <thead class="table-light">
                        <tr>
                            <th>Alat</th>
                            <th width="150">Harga</th>
                            <th width="120">Jumlah</th>
                            <th width="150">Subtotal</th>
                            <th width="100">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr>

                            <td>

                                <select name="id_alat[]" class="form-control pilih-alat" required>

                                    <option value="">-- Pilih Alat --</option>

                                    <?php
                                    $alat2 = mysqli_query($connect, "SELECT * FROM alat ORDER BY nama_alat ASC");

                                    while ($a = mysqli_fetch_object($alat2)) {
                                    ?>

                                        <option
                                            value="<?= $a->id_alat ?>"
                                            data-harga="<?= $a->harga ?>"
                                            data-stok="<?= $a->stok ?>">

                                            <?= htmlspecialchars($a->nama_alat) ?>
                                            | Stok: <?= $a->stok ?>
                                            | Rp <?= number_format($a->harga, 0, ',', '.') ?>

                                        </option>

                                    <?php } ?>

                                </select>

                            </td>

                            <td>
                                <input type="number" class="form-control harga" readonly>
                            </td>

                            <td>
                                <input type="number" name="jumlah_pinjam[]" class="form-control jumlah" value="1" min="1" required>
                            </td>

                            <td>
                                <input type="number" class="form-control subtotal" readonly>
                            </td>

                            <td>
                                <button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button>
                            </td>

                        </tr>

                    </tbody>

                </table>

                <button type="button" class="btn btn-success btn-sm" id="tambah-row">
                    + Tambah Barang
                </button>

            </div>

            <!-- TANGGAL -->
            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Pinjam</label>
                    <input type="date" name="tgl_pinjam" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Kembali</label>
                    <input type="date" name="tgl_kembali" class="form-control">
                </div>

            </div>

            <!-- METODE PEMBAYARAN -->
            <div class="mb-3">

                <label class="form-label">Metode Pembayaran</label>

                <select name="metode_pembayaran" class="form-control" required>

                    <option value="">-- Pilih Metode --</option>
                    <option value="COD">COD (barang ketika udah datang)</option>
                  

                </select>

            </div>

            <!-- TOTAL -->
            <div class="mb-3">

                <label class="form-label">Total Harga</label>

                <input type="number" name="total_harga" class="form-control" readonly required>

            </div>

            <button type="submit" class="btn btn-primary">
                Simpan
            </button>

            <a href="./index.php" class="btn btn-secondary">
                Kembali
            </a>

        </form>

    </div>
</div>


<script>
    function hitungTotal() {

        let total = 0;

        document.querySelectorAll("#table-alat tbody tr").forEach(function(row) {

            let harga = parseInt(row.querySelector(".harga").value) || 0;
            let jumlah = parseInt(row.querySelector(".jumlah").value) || 0;

            let subtotal = harga * jumlah;

            row.querySelector(".subtotal").value = subtotal;

            total += subtotal;

        });

        document.querySelector("input[name='total_harga']").value = total;

    }


    // pilih alat
    document.addEventListener("change", function(e) {

        if (e.target.classList.contains("pilih-alat")) {

            let option = e.target.selectedOptions[0];

            let harga = option.getAttribute("data-harga") || 0;

            let row = e.target.closest("tr");

            row.querySelector(".harga").value = harga;

            hitungTotal();

        }

    });


    // ubah jumlah
    document.addEventListener("input", function(e) {

        if (e.target.classList.contains("jumlah")) {

            hitungTotal();

        }

    });


    // tambah barang
    document.getElementById("tambah-row").addEventListener("click", function() {

        let table = document.querySelector("#table-alat tbody");

        let row = table.rows[0].cloneNode(true);

        row.querySelectorAll("input").forEach(input => input.value = "");

        row.querySelector(".jumlah").value = 1;

        row.querySelector(".harga").value = "";

        row.querySelector(".subtotal").value = "";

        row.querySelectorAll("select").forEach(select => select.selectedIndex = 0);

        table.appendChild(row);

    });


    // hapus barang
    document.addEventListener("click", function(e) {

        if (e.target.classList.contains("remove-row")) {

            let table = document.querySelector("#table-alat tbody");

            if (table.rows.length > 1) {

                e.target.closest("tr").remove();

                hitungTotal();

            }

        }

    });
</script>


<?php
include '../../partials/footer.php';
include '../../partials/script.php';
?>