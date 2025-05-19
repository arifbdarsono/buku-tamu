<?php
session_start();
require 'config/database.php';

// 1. Cek akses admin (hardcoded)
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    die("Akses ditolak.");
}

// 2. Validasi ID dari parameter GET
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    die("ID tidak valid.");
}

// 3. Ambil data lama (semua kolom baru)
$stmt = $conn->prepare("SELECT nama, email, website, genre, pesan FROM tamu WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Data tidak ditemukan.");
}

$data = $result->fetch_assoc();
$stmt->close();

// 4. Proses update ketika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil dan bersihkan input
    $nama_baru    = trim($_POST['nama']);
    $email_baru   = trim($_POST['email'] ?? '');
    $website_baru = trim($_POST['website'] ?? '');
    $genre_baru   = $_POST['genre'] ?? null;
    $pesan_baru   = trim($_POST['pesan']);

    // Validasi wajib
    if ($nama_baru === '' || $pesan_baru === '') {
        die("Nama dan pesan wajib diisi.");
    }

    // Validasi panjang
    if (strlen($nama_baru) > 100) {
        die("Nama terlalu panjang (maks 100 karakter).");
    }
    if (strlen($email_baru) > 100) {
        die("Email terlalu panjang (maks 100 karakter).");
    }
    if (strlen($website_baru) > 100) {
        die("Website terlalu panjang (maks 100 karakter).");
    }
    if (strlen($pesan_baru) > 1000) {
        die("Pesan terlalu panjang (maks 1000 karakter).");
    }

    // Validasi karakter nama
    if (!preg_match('/^[\p{L}0-9\s\.\,\!\?\-]+$/u', $nama_baru)) {
        die("Nama mengandung karakter tidak valid.");
    }

    // Validasi email jika diisi
    if ($email_baru !== '' && !filter_var($email_baru, FILTER_VALIDATE_EMAIL)) {
        die("Format email tidak valid.");
    }

    // Validasi website jika diisi
    if ($website_baru !== '' && !filter_var($website_baru, FILTER_VALIDATE_URL)) {
        die("Format URL tidak valid.");
    }

    // Validasi genre jika diisi
    $allowed_genre = ['male', 'female'];
    if ($genre_baru !== null && !in_array($genre_baru, $allowed_genre)) {
        die("Pilihan genre tidak valid.");
    }

    // 5. Simpan perubahan dengan prepared statement
    $stmt = $conn->prepare("
        UPDATE tamu 
        SET nama = ?, email = ?, website = ?, genre = ?, pesan = ?
        WHERE id = ?
    ");
    $stmt->bind_param(
        "sssssi",
        $nama_baru,
        $email_baru,
        $website_baru,
        $genre_baru,
        $pesan_baru,
        $id
    );

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        die("Gagal menyimpan perubahan.");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Entri Buku Tamu</title>
</head>
<body>
    <h2>Edit Entri Buku Tamu</h2>

    <form method="post" action="">
        <label for="nama">Nama:</label><br>
        <input
            type="text"
            name="nama"
            id="nama"
            value="<?php echo htmlspecialchars($data['nama']); ?>"
            required
        ><br><br>

        <label for="email">Email:</label><br>
        <input
            type="email"
            name="email"
            id="email"
            value="<?php echo htmlspecialchars($data['email']); ?>"
        ><br><br>

        <label for="website">Website:</label><br>
        <input
            type="url"
            name="website"
            id="website"
            value="<?php echo htmlspecialchars($data['website']); ?>"
        ><br><br>

        <label>Genre:</label><br>
        <input
            type="radio"
            name="genre"
            value="male"
            id="male"
            <?php if ($data['genre'] === 'male') echo 'checked'; ?>
        >
        <label for="male">Male</label>
        <input
            type="radio"
            name="genre"
            value="female"
            id="female"
            <?php if ($data['genre'] === 'female') echo 'checked'; ?>
        >
        <label for="female">Female</label><br><br>

        <label for="pesan">Pesan:</label><br>
        <textarea
            name="pesan"
            id="pesan"
            rows="5"
            required
        ><?php echo htmlspecialchars($data['pesan']); ?></textarea><br><br>

        <input type="submit" value="Simpan Perubahan">
    </form>

    <p><a href="index.php">Kembali ke Daftar</a></p>
</body>
</html>
