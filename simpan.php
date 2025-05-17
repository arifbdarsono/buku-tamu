<?php
session_start();

// Cek token CSRF
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("Token CSRF tidak valid.");
}

// Cek honeypot
if (!empty($_POST['website'])) {
    $ip         = $_SERVER['REMOTE_ADDR'];
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $log_line   = date('c') . " | IP: $ip | UA: $user_agent\n";
    file_put_contents('logs/log_spam.txt', $log_line, FILE_APPEND);
    die("Bot terdeteksi.");
}

require 'config/database.php';

// Ambil dan bersihkan input
$nama  = trim($_POST['nama']);
$pesan = trim($_POST['pesan']);

// Validasi panjang dan karakter
if ($nama === '' || $pesan === '') {
    die("Data tidak lengkap.");
}

if (strlen($nama) > 100) {
    die("Nama terlalu panjang (maks 100 karakter).");
}

if (strlen($pesan) > 1000) {
    die("Pesan terlalu panjang (maks 1000 karakter).");
}

// Tambahan: cegah karakter aneh
if (!preg_match('/^[a-zA-Z0-9\s\p{L}.,!?-]+$/u', $nama)) {
    die("Nama mengandung karakter tidak valid.");
}

$ip         = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];

$stmt = mysqli_prepare($conn, "INSERT INTO tamu (nama, pesan, ip, user_agent) VALUES (?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "ssss", $nama, $pesan, $ip, $user_agent);

if (mysqli_stmt_execute($stmt)) {
    header("Location: index.php");
    exit;
} else {
    die("Gagal menyimpan data.");
}