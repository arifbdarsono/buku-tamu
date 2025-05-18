<?php
session_start();
require 'config/database.php';

// Cek akses admin
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    die("Akses ditolak.");
}

// Validasi ID
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    die("ID tidak valid.");
}

// Ambil data lama
$stmt = $conn->prepare("SELECT nama, pesan FROM tamu WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Data tidak ditemukan.");
}

$data = $result->fetch_assoc();

// Proses update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_baru = trim($_POST['nama']);
    $pesan_baru = trim($_POST['pesan']);

    if ($nama_baru === '' || $pesan_baru === '') {
        die("Nama dan pesan tidak boleh kosong.");
    }

    $stmt = $conn->prepare("UPDATE tamu SET nama = ?, pesan = ? WHERE id = ?");
    $stmt->bind_param("ssi", $nama_baru, $pesan_baru, $id);
    $stmt->execute();

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Entri</title>
</head>
<body>
    <h2>Edit Entri Buku Tamu</h2>

    <form method="post" action="">
        <label>Nama:</label><br>
        <input type="text" name="nama" value="<?php echo htmlspecialchars($data['nama']); ?>" required><br><br>

        <label>Pesan:</label><br>
        <textarea name="pesan" rows="5" required><?php echo htmlspecialchars($data['pesan']); ?></textarea><br><br>

        <input type="submit" value="Simpan Perubahan">
    </form>

    <p><a href="index.php">Kembali ke Daftar</a></p>
</body>
</html>
