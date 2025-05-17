<?php
// Konfigurasi koneksi database
$host = "localhost";
$user = "root";      // Ganti sesuai konfigurasi server kamu
$pass = "root";          // Kosongkan jika tanpa password
$db   = "bukutamu";

// Membuat koneksi
$conn = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
