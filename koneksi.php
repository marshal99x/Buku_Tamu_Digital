<?php
// koneksi.php
// Konfigurasi koneksi ke database MySQL

define('DB_HOST', 'localhost');
define('DB_USER', 'root');     
define('DB_PASS', '');          
define('DB_NAME', 'db_bukutamu');

$koneksi = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$koneksi) {
    die('<div style="font-family:sans-serif;color:#b91c1c;padding:20px;">
            <strong>Koneksi Database Gagal!</strong><br>
            Error: ' . mysqli_connect_error() . '
         </div>');
}

// Set charset agar mendukung karakter khusus
mysqli_set_charset($koneksi, 'utf8mb4');
?>
