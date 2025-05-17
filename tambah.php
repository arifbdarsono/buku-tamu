<?php
session_start();

// Buat token CSRF jika belum ada
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<?php include 'includes/header.php'; ?>

<h2>Isi Buku Tamu</h2>

<form action="simpan.php" method="post">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <label for="nama">Nama:</label><br>
    <input type="text" name="nama" required><br><br>

    <label for="pesan">Pesan:</label><br>
    <textarea name="pesan" rows="4" required></textarea><br><br>

    <!-- Honeypot -->
    <input type="text" name="website" style="display:none">

    <input type="submit" value="Kirim">
</form>

<?php include 'includes/footer.php'; ?>