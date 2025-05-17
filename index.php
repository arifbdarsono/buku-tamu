<?php
require 'config/database.php';

// Konfigurasi pagination
$batas = 5;
$halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$mulai = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

// Pencarian
$keyword = isset($_GET['cari']) ? trim($_GET['cari']) : '';
$param = "%$keyword%";

// Hitung total data
if ($keyword) {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM tamu WHERE nama LIKE ? OR pesan LIKE ?");
    $stmt->bind_param("ss", $param, $param);
} else {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM tamu");
}
$stmt->execute();
$stmt->bind_result($total);
$stmt->fetch();
$stmt->close();

$pages = ceil($total / $batas);

// Ambil data sesuai halaman dan pencarian
if ($keyword) {
    $stmt = $conn->prepare("SELECT * FROM tamu WHERE nama LIKE ? OR pesan LIKE ? ORDER BY waktu DESC LIMIT ?, ?");
    $stmt->bind_param("ssii", $param, $param, $mulai, $batas);
} else {
    $stmt = $conn->prepare("SELECT * FROM tamu ORDER BY waktu DESC LIMIT ?, ?");
    $stmt->bind_param("ii", $mulai, $batas);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Daftar Buku Tamu</title>
</head>
<body>
    <h1>Daftar Buku Tamu</h1>

    <form method="GET" action="index.php">
        <input type="text" name="cari" value="<?php echo htmlspecialchars($keyword); ?>" placeholder="Cari nama atau pesan...">
        <button type="submit">Cari</button>
    </form>

    <p><a href="tambah.php">+ Tambah Entri Buku Tamu</a></p>

    <?php while ($row = $result->fetch_assoc()): ?>
        <hr>
        <p><strong><?php echo htmlspecialchars($row['nama']); ?></strong></p>
        <p><?php echo nl2br(htmlspecialchars($row['pesan'])); ?></p>
        <small><?php echo htmlspecialchars($row['waktu']); ?></small><br>
        <small>IP: <?php echo htmlspecialchars($row['ip']); ?> | User Agent: <?php echo htmlspecialchars($row['user_agent']); ?></small>
    <?php endwhile; ?>

    <hr>
    <p>Halaman:
<?php for ($i = 1; $i <= $pages; $i++): ?>
    <?php if ($i == $halaman): ?>
        <strong><?php echo $i; ?></strong>
    <?php else: ?>
        <a href="?halaman=<?php echo $i; ?><?php if ($keyword) echo '&cari=' . urlencode($keyword); ?>">
            <?php echo $i; ?>
        </a>
    <?php endif; ?>
<?php endfor; ?>
</p>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>