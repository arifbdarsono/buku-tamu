<?php
session_start();
require 'includes/header.php';

// Buat token CSRF
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<h2>Isi Buku Tamu</h2>

<form action="simpan.php" method="post">
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

    <label for="nama">Nama:</label><br>
    <input type="text" name="nama" id="nama" required><br><br>

    <label for="email">Email:</label><br>
    <input type="email" name="email" id="email"><br><br>

    <label for="website">Website:</label><br>
    <input type="url" name="website" id="website"><br><br>

    <label>Genre:</label><br>
    <input type="radio" name="genre" value="male" id="male">
    <label for="male">Male</label>
    <input type="radio" name="genre" value="female" id="female">
    <label for="female">Female</label><br><br>

    <label for="pesan">Pesan:</label><br>
    <textarea name="pesan" id="pesan" rows="5" required></textarea><br><br>

    <!-- Honeypot -->
    <input type="text" name="website_hidden" style="display:none">

    <input type="submit" value="Kirim">
</form>

<p><a href="index.php">Kembali ke daftar tamu</a></p>

<?php require 'includes/footer.php'; ?>
