<?php
require 'config.php';

// Ambil ID dari URL dan pastikan berupa angka
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id > 0) {
    $stmt = mysqli_prepare($conn, "DELETE FROM tamu WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
}

// Arahkan kembali ke halaman utama
header("Location: index.php");
exit;
?>