<?php
require_once __DIR__ . '/../../../config/connection.php';

$bulan = $_GET['bulan'] ?? '';
$tahun = $_GET['tahun'] ?? '';

$where = "";

// filter data
if ($bulan != '' && $tahun != '') {

    $where = "WHERE MONTH(p.tgl_pinjam) = '$bulan' 
              AND YEAR(p.tgl_pinjam) = '$tahun'";
} elseif ($bulan != '') {

    $where = "WHERE MONTH(p.tgl_pinjam) = '$bulan'";
} elseif ($tahun != '') {

    $where = "WHERE YEAR(p.tgl_pinjam) = '$tahun'";
}

$q = "
SELECT 
p.id_pinjam,
p.tgl_pinjam,
p.tgl_kembali,
p.total_harga,
p.status,
p.no_telepon,
u.nama,
GROUP_CONCAT(a.nama_alat SEPARATOR ', ') as nama_alat

FROM peminjaman p

LEFT JOIN users u 
ON p.id_user = u.id_user

LEFT JOIN detail_peminjaman dp 
ON p.id_pinjam = dp.id_pinjam

LEFT JOIN alat a 
ON dp.id_alat = a.id_alat

$where

GROUP BY p.id_pinjam
ORDER BY p.id_pinjam DESC
";

$result = mysqli_query($connect, $q);

$total_penghasilan = 0;
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <link rel="icon" type="image/png" href="../../templates-admin/material-dashboard-2/assets/img/1setwedding.webp">

    <meta charset="UTF-8">
    <title>Laporan Peminjaman</title>

    <style>
        body {
            font-family: Arial;
        }

        .judul {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .filter {
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        table th {
            background: #eaeaea;
        }

        .btn {
            padding: 6px 12px;
            background: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            text-decoration: none;
        }

        .btn-print {
            background: #007bff;
        }

        @media print {

            .filter,
            .btn-print {
                display: none;
            }

        }
    </style>

</head>

<body>

    <div class="filter">

        <form method="GET">

            Bulan :

            <select name="bulan">

                <option value="">Semua</option>

                <?php
                for ($i = 1; $i <= 12; $i++) {

                    $selected = ($bulan == $i) ? "selected" : "";

                    echo "<option value='$i' $selected>$i</option>";
                }
                ?>

            </select>

            Tahun :

            <select name="tahun">

                <option value="">Semua</option>

                <?php

                $year = date("Y");

                for ($i = $year; $i >= 2020; $i--) {

                    $selected = ($tahun == $i) ? "selected" : "";

                    echo "<option value='$i' $selected>$i</option>";
                }

                ?>

            </select>

            <button type="submit" class="btn">Filter</button>

            <a href="../persetujuan_peminjaman/index.php" class="btn" style="background:#6c757d;">Kembali</a>

            <a href="#" onclick="window.print()" class="btn btn-print">Cetak</a>

        </form>

    </div>

    <div class="judul">

        LAPORAN DATA PEMINJAMAN ALAT

        <?php

        if ($bulan && $tahun) {
            echo "<br>Bulan $bulan Tahun $tahun";
        } elseif ($bulan) {
            echo "<br>Bulan $bulan";
        } elseif ($tahun) {
            echo "<br>Tahun $tahun";
        }

        ?>

    </div>

    <table>

        <thead>

            <tr>

                <th>No</th>
                <th>Nama User</th>
                <th>No Telepon</th>
                <th>Nama Alat</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Total Harga</th>
                <th>Status</th>

            </tr>

        </thead>

        <tbody>

            <?php

            if (mysqli_num_rows($result) == 0) {

                echo "<tr><td colspan='8'>Belum ada data</td></tr>";
            } else {

                $no = 1;

                while ($row = mysqli_fetch_object($result)) {

                    $total_penghasilan += $row->total_harga;

            ?>

                    <tr>

                        <td><?= $no++ ?></td>
                        <td><?= $row->nama ?></td>
                        <td><?= $row->no_telepon ?></td>
                        <td><?= $row->nama_alat ?></td>
                        <td><?= $row->tgl_pinjam ?></td>
                        <td><?= $row->tgl_kembali ?></td>
                        <td>Rp <?= number_format($row->total_harga, 0, ',', '.') ?></td>
                        <td><?= $row->status ?></td>

                    </tr>

            <?php
                }
            }
            ?>

            <tr>

                <td colspan="6"><b>Total Penghasilan</b></td>

                <td colspan="2">
                    <b>Rp <?= number_format($total_penghasilan, 0, ',', '.') ?></b>
                </td>

            </tr>

        </tbody>

    </table>

</body>

</html>