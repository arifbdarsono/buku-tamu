<?php
session_start();
require 'config/database.php';

// Pastikan hanya admin yang bisa mengakses
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    die("Akses ditolak.");
}

// Set header untuk file CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=bukutamu.csv');

// Buka output stream
$output = fopen('php://output', 'w');

// Tulis baris judul kolom
fputcsv($output, ['ID', 'Nama', 'Pesan', 'Waktu', 'IP', 'User Agent']);

// Ambil data dari database
$result = mysqli_query($conn, "SELECT * FROM tamu ORDER BY waktu DESC");

while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, [
        $row['id'],
        $row['nama'],
        $row['pesan'],
        $row['waktu'],
        $row['ip'],
        $row['user_agent']
    ]);
}

// Tutup koneksi
fclose($output);
exit;
