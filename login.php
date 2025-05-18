<?php
session_start();

// Ganti username dan password sesuai kebutuhan
$admin_user = 'admin';
$admin_pass = '123456';

// Jika sudah login, redirect ke halaman admin
if (isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}

// Proses form login
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['username'] ?? '');
    $pass = trim($_POST['password'] ?? '');

    if ($user === $admin_user && $pass === $admin_pass) {
        $_SESSION['admin'] = true;
        header("Location: index.php");
        exit;
    } else {
        $error = 'Username atau password salah.';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
</head>
<body>
    <h2>Login Admin</h2>

    <?php if ($error): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="post" action="login.php">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <input type="submit" value="Login">
    </form>

    <p><a href="index.php">Kembali ke Buku Tamu</a></p>
</body>
</html>
