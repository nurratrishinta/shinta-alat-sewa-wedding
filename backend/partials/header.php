<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include '../../app.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    echo "
    <script> 
    alert('Anda Harus Login dahulu');
    window.location.href='../../actions/auth/login.php';
    </script>
  ";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../../templates-admin/material-dashboard-2/assets/img/logo.png/apple-icon.png">
    <link rel="icon" type="image/png" href="../../templates-admin/material-dashboard-2/assets/img/1setwedding.webp">
    <title>
        SEWA ALAT WEDDING
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="../../templates-admin/material-dashboard-2/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../../templates-admin/material-dashboard-2/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="../../templates-admin/material-dashboard-2/assets/css/material-dashboard.css?v=3.0.0" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


    <style>
        /* Pastikan semua sel ada border */
        .table-bordered td,
        .table-bordered th {
            border: 1px solid #dee2e6 !important;
        }

        /* Tambahkan border bawah di row terakhir */
        .table-bordered tr:last-child td {
            border-bottom: 1px solid #dee2e6 !important;
        }
    </style>
</head>