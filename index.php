<?php
session_start();
require 'config/database.php';

// Konfigurasi pagination
$batas    = 5;
$halaman  = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$mulai    = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

// Pencarian
$keyword      = isset($_GET['cari']) ? trim($_GET['cari']) : '';
$genre_filter = isset($_GET['genre']) ? trim($_GET['genre']) : '';
$param        = "%$keyword%";

// Siapkan klausa WHERE dinamis
$where_clauses = [];
$params         = [];
$types          = '';

// Jika ada kata kunci pencarian
if ($keyword !== '') {
    $where_clauses[] = "(nama LIKE ? OR pesan LIKE ?)";
    $params[]        = $param;
    $params[]        = $param;
    $types          .= 'ss';
}

// Jika ada filter genre (male/female)
if ($genre_filter === 'male' || $genre_filter === 'female') {
    $where_clauses[] = "genre = ?";
    $params[]        = $genre_filter;
    $types          .= 's';
}

// Gabungkan klausa WHERE
$where_sql = '';
if (count($where_clauses) > 0) {
    $where_sql = 'WHERE ' . implode(' AND ', $where_clauses);
}

// Hitung total data (dengan filter/pencarian jika ada)
$sql_count = "SELECT COUNT(*) FROM tamu $where_sql";
$stmt = $conn->prepare($sql_count);
if ($types !== '') {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$stmt->bind_result($total);
$stmt->fetch();
$stmt->close();

$pages = ceil($total / $batas);

// Ambil data sesuai halaman, filter, dan pencarian
$sql_data = "SELECT * FROM tamu $where_sql ORDER BY waktu DESC LIMIT ?, ?";
$stmt = $conn->prepare($sql_data);

// Ikat parameter: filter/pencarian diikuti oleh offset & limit
if ($types === '') {
    // Hanya pagination (tanpa filter/pencarian)
    $stmt->bind_param("ii", $mulai, $batas);
} else {
    // Dengan filter/pencarian + offset & limit
    $types_with_limits = $types . 'ii';
    $params[]          = $mulai;
    $params[]          = $batas;
    $stmt->bind_param($types_with_limits, ...$params);
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

    <!-- Navigasi admin -->
    <?php if (isset($_SESSION['admin'])): ?>
        <p>
            Login sebagai admin |
            <a href="admin/dashboard.php">Dashboard</a> |
            <a href="logout.php">Logout</a> |
            <a href="export.php">Ekspor CSV</a>
        </p>
    <?php else: ?>
        <p><a href="login.php">Login Admin</a></p>
    <?php endif; ?>

    <!-- Form pencarian dan filter genre -->
    <form method="GET" action="index.php">
        <input
            type="text"
            name="cari"
            value="<?php echo htmlspecialchars($keyword); ?>"
            placeholder="Cari nama atau pesan..."
        >
        <select name="genre">
            <option value="">-- Semua Genre --</option>
            <option value="male"   <?php if ($genre_filter === 'male')   echo 'selected'; ?>>Male</option>
            <option value="female" <?php if ($genre_filter === 'female') echo 'selected'; ?>>Female</option>
        </select>
        <button type="submit">Cari</button>
    </form>

    <p><a href="tambah.php">+ Tambah Entri Buku Tamu</a></p>

    <!-- Daftar entri -->
    <?php if ($result->num_rows === 0): ?>
        <p><strong>Tidak ada entri yang ditemukan.</strong></p>
        <p><a href="index.php">Kembali ke buku tamu</a></p>
    <?php else: ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <hr>
            <p><strong><?php echo htmlspecialchars($row['nama']); ?></strong></p>

            <!-- Tampilkan email hanya jika admin login -->
            <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] === true): ?>
                <?php if ($row['email'] !== null && $row['email'] !== ''): ?>
                    <p>
                        Email: 
                        <a href="mailto:<?php echo htmlspecialchars($row['email']); ?>">
                            <?php echo htmlspecialchars($row['email']); ?>
                        </a>
                    </p>
                <?php endif; ?>
            <?php endif; ?>

            <!-- Tampilkan website (publik) jika ada -->
            <?php if ($row['website'] !== null && $row['website'] !== ''): ?>
                <p>
                    Website: 
                    <a href="<?php echo htmlspecialchars($row['website']); ?>" target="_blank">
                        <?php echo htmlspecialchars($row['website']); ?>
                    </a>
                </p>
            <?php endif; ?>

            <!-- Tampilkan genre jika ada -->
            <?php if ($row['genre'] !== null && $row['genre'] !== ''): ?>
                <p>Genre: <?php echo htmlspecialchars(ucfirst($row['genre'])); ?></p>
            <?php endif; ?>

            <p><?php echo nl2br(htmlspecialchars($row['pesan'])); ?></p>
            <small><?php echo htmlspecialchars($row['waktu']); ?></small><br>

            <!-- Tampilkan IP/User Agent hanya untuk admin -->
            <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] === true): ?>
                <small>
                    IP: <?php echo htmlspecialchars($row['ip']); ?> |
                    User Agent: <?php echo htmlspecialchars($row['user_agent']); ?>
                </small>
                <br>
                <a href="hapus.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Hapus entri ini?')">
                    [Hapus]
                </a>
                <a href="edit.php?id=<?php echo $row['id']; ?>">[Edit]</a>
            <?php endif; ?>
        <?php endwhile; ?>

        <!-- Navigasi halaman -->
        <hr>
        <p>Halaman:
        <?php 
        for ($i = 1; $i <= $pages; $i++):
            $link = "?halaman=$i";
            if ($keyword !== '') {
                $link .= "&cari=" . urlencode($keyword);
            }
            if ($genre_filter !== '') {
                $link .= "&genre=" . urlencode($genre_filter);
            }
        ?>
            <?php if ($i == $halaman): ?>
                <strong><?php echo $i; ?></strong>
            <?php else: ?>
                <a href="<?php echo $link; ?>"><?php echo $i; ?></a>
            <?php endif; ?>
        <?php endfor; ?>
        </p>
    <?php endif; ?>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
