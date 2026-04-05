<?php
//untuk memulai sesi $_SESSION
session_start();

// menghapus semua variabel sesi, artinya semua data yang ada si $_SESSION akan di hapus
session_unset();

// nenghancurkan sesi sepenuhnya, da sesi akan dihapus dari server
session_destroy();

echo "
      <script>
       alert('Berhasil Logout');
       window.location.href='login.php';
      </script>
     ";
?>