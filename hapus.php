<?php
session_start();
require 'config/database.php';

// Hanya admin yang boleh menghapus
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    die("Akses ditolak.");
}

// Validasi ID
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    die("ID tidak valid.");
}

// Hapus data dengan prepared statement
$stmt = $conn->prepare("DELETE FROM tamu WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

// Kembali ke halaman utama
header("Location: index.php");
exit;
