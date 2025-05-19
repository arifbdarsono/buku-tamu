<?php
session_start();

// 1. CSRF check
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("Token CSRF tidak valid.");
}

// 2. Honeypot check
if (!empty($_POST['website_hidden'])) {
    $ip         = $_SERVER['REMOTE_ADDR'];
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $log_line   = date('c') . " | IP: $ip | UA: $user_agent\n";
    file_put_contents('logs/log_spam.txt', $log_line, FILE_APPEND);
    die("Bot terdeteksi.");
}

require 'config/database.php';

// 3. Ambil dan bersihkan input
$nama    = trim($_POST['nama']);
$pesan   = trim($_POST['pesan']);
$email   = trim($_POST['email'] ?? '');
$website = trim($_POST['website'] ?? '');
$genre   = $_POST['genre'] ?? null;

// 4. Validasi wajib
if ($nama === '' || $pesan === '') {
    die("Nama dan pesan wajib diisi.");
}

// 5. Validasi panjang
if (strlen($nama) > 100) {
    die("Nama terlalu panjang (maks 100 karakter).");
}
if (strlen($email) > 100) {
    die("Email terlalu panjang (maks 100 karakter).");
}
if (strlen($website) > 100) {
    die("Website terlalu panjang (maks 100 karakter).");
}
if (strlen($pesan) > 1000) {
    die("Pesan terlalu panjang (maks 1000 karakter).");
}

// 6. Validasi karakter nama
if (!preg_match('/^[\p{L}0-9\s\.\,\!\?\-]+$/u', $nama)) {
    die("Nama mengandung karakter tidak valid.");
}

// 7. Validasi email (jika diisi)
if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Format email tidak valid.");
}

// 8. Validasi website (jika diisi)
if ($website !== '' && !filter_var($website, FILTER_VALIDATE_URL)) {
    die("Format URL tidak valid.");
}

// 9. Validasi genre (jika dipilih)
$allowed_genre = ['male', 'female'];
if ($genre !== null && !in_array($genre, $allowed_genre)) {
    die("Pilihan genre tidak valid.");
}

// 10. Logging IP & User Agent
$ip         = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];

// 11. Simpan ke database dengan prepared statement
$stmt = $conn->prepare(
    "INSERT INTO tamu 
     (nama, email, website, genre, pesan, ip, user_agent) 
     VALUES (?, ?, ?, ?, ?, ?, ?)"
);
$stmt->bind_param("sssssss", $nama, $email, $website, $genre, $pesan, $ip, $user_agent);

if ($stmt->execute()) {
    header("Location: index.php");
    exit;
} else {
    die("Gagal menyimpan data.");
}
