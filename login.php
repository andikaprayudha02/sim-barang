<?php
session_start();

// Sudah login? Langsung ke dashboard
if (isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

// Data pengguna pada array asosiatif (username => data)
$users = [
    'admin' => ['password' => 'password123', 'nama' => 'Administrator'],
    'dosen' => ['password' => 'dosen123',    'nama' => 'Dosen Pengampu'],
];

$error = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (isset($users[$username]) && hash_equals($users[$username]['password'], $password)) {
        session_regenerate_id(true);               // cegah session fixation
        $_SESSION['username'] = $username;
        $_SESSION['nama']     = $users[$username]['nama'];
        header('Location: index.php');
        exit;
    }
    $error = 'Username atau password salah.';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - SIM-Barang</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="halaman-login">

  <main class="login-wrap">

    <aside class="login-info">
      <span class="logo" aria-hidden="true">📦</span>
      <h1>SIM-Barang</h1>
      <p>Sistem Pengelolaan Inventaris Barang Jurusan</p>
      <ul>
        <li>📋 Catat dan pantau aset laboratorium</li>
        <li>🔍 Cari barang dengan cepat</li>
        <li>📊 Lihat ringkasan inventaris</li>
      </ul>
    </aside>

    <section class="login-card">
      <h2>👋 Selamat Datang</h2>
      <p class="login-sub">Silakan masuk untuk melanjutkan.</p>

      <?php if ($error !== ''): ?>
        <div class="alert-error" role="alert">⚠️ <?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form action="login.php" method="post" class="login-form">
        <div class="field">
          <label for="username">👤 Username</label>
          <input type="text" id="username" name="username"
                 value="<?= htmlspecialchars($username) ?>"
                 placeholder="Masukkan username" required autofocus>
        </div>

        <div class="field">
          <label for="password">🔒 Password</label>
          <div class="pass-wrap">
            <input type="password" id="password" name="password"
                   placeholder="Masukkan password" required>
            <button type="button" id="lihat" class="btn-lihat">Lihat</button>
          </div>
        </div>

        <button type="submit">🔐 Masuk</button>
      </form>

      <p class="login-hint">Demo: <strong>admin</strong> / <strong>password123</strong></p>
    </section>

  </main>

  <script>
    // Tombol lihat/sembunyikan password
    const pw = document.getElementById('password');
    const lihat = document.getElementById('lihat');
    lihat.addEventListener('click', function () {
      const tampil = pw.type === 'password';
      pw.type = tampil ? 'text' : 'password';
      lihat.textContent = tampil ? 'Sembunyi' : 'Lihat';
    });
  </script>
</body>
</html>