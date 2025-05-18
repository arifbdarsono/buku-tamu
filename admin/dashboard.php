<?php
session_start();
require '../config/database.php';

// Cegah akses jika belum login admin
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: ../login.php");
    exit;
}

// Hitung total entri
$total_sql = mysqli_query($conn, "SELECT COUNT(*) as total FROM tamu");
$total = mysqli_fetch_assoc($total_sql)['total'];

// Hitung entri hari ini
$today_sql = mysqli_query($conn, "SELECT COUNT(*) as total FROM tamu WHERE DATE(waktu) = CURDATE()");
$today = mysqli_fetch_assoc($today_sql)['total'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
</head>
<body>
    <h1>Dashboard Admin</h1>

    <p>Selamat datang, Admin!</p>

    <ul>
        <li>Total Entri Buku Tamu: <strong><?php echo $total; ?></strong></li>
        <li>Entri Hari Ini: <strong><?php echo $today; ?></strong></li>
    </ul>

    <p>
        <a href="../export.php">Ekspor Data ke CSV</a><br>
        <a href="../index.php">Lihat Buku Tamu</a><br>
        <a href="../logout.php">Logout</a>
    </p>
</body>
</html>
