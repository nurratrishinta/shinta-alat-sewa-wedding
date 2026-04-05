<?php
require_once __DIR__ . '/../../../config/connection.php';

function tambah_log($id_user, $aktivitas)
{
    global $connect;

    $id_user = mysqli_real_escape_string($connect, $id_user);
    $aktivitas = mysqli_real_escape_string($connect, $aktivitas);

    $query = "INSERT INTO log_aktivitas (id_user, aktivitas) 
              VALUES ('$id_user', '$aktivitas')";

    mysqli_query($connect, $query) or die(mysqli_error($connect));
}
?>