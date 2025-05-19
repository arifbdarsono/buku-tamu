<?php
session_start();
require 'config/database.php';

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    die("Akses ditolak.");
}

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=bukutamu.csv');

$output = fopen('php://output', 'w');
fputcsv($output, ['ID', 'Nama', 'Email', 'Website', 'Genre', 'Pesan', 'Waktu', 'IP', 'User Agent']);

$result = mysqli_query($conn, "SELECT * FROM tamu ORDER BY waktu DESC");
while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, [
        $row['id'],
        $row['nama'],
        $row['email'],
        $row['website'],
        $row['genre'],
        $row['pesan'],
        $row['waktu'],
        $row['ip'],
        $row['user_agent']
    ]);
}
fclose($output);
exit;
