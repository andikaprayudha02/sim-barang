<?php
// simpan.php - Pertemuan 5: pengolahan formulir sisi server

/* Aktifkan 4 baris ini jika login (Pertemuan 6) sudah dipasang:
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
*/

// Halaman utama: index.php jika ada, selain itu index.html
$halamanUtama = file_exists(__DIR__ . '/index.php') ? 'index.php' : 'index.html';

// Hanya terima kiriman POST; akses langsung dikembalikan ke form
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . $halamanUtama);
    exit;
}

// ===== FUNGSI =====
// Total estimasi nilai aset = jumlah x harga satuan
function hitungTotal(int $jumlah, int $harga): int {
    return $jumlah * $harga;
}

// Format angka menjadi rupiah, contoh 150000000 -> Rp 150.000.000
function rupiah(int $angka): string {
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

// ===== DAFTAR PILIHAN YANG DIIZINKAN =====
$daftarKategori = [
    'elektronik' => 'Elektronik',
    'furnitur'   => 'Furnitur',
    'alat-lab'   => 'Alat Lab',
];
$daftarKondisi = [
    'baik'         => 'Baik',
    'rusak-ringan' => 'Rusak Ringan',
    'rusak-berat'  => 'Rusak Berat',
];

// ===== TANGKAP DATA DARI $_POST =====
$kode        = trim($_POST['kode'] ?? '');
$nama        = trim($_POST['nama'] ?? '');
$kategoriKey = $_POST['kategori'] ?? '';
$kondisiKey  = $_POST['kondisi'] ?? '';
$jumlah      = filter_var($_POST['jumlah'] ?? '', FILTER_VALIDATE_INT);
$harga       = filter_var($_POST['harga'] ?? '', FILTER_VALIDATE_INT);

// ===== VALIDASI ULANG DI SERVER =====
$errors = [];

if (!preg_match('/^BRG-\d+$/', $kode)) {
    $errors[] = 'Kode barang harus diawali BRG- diikuti angka (contoh: BRG-001).';
}
if (strlen($nama) < 3) {
    $errors[] = 'Nama barang minimal 3 karakter.';
}
if (!isset($daftarKategori[$kategoriKey])) {
    $errors[] = 'Kategori tidak valid.';
}
if ($jumlah === false || $jumlah <= 0) {
    $errors[] = 'Jumlah harus berupa bilangan bulat lebih dari 0.';
}
if ($harga === false || $harga <= 0) {
    $errors[] = 'Harga satuan harus berupa bilangan bulat lebih dari 0.';
}
if (!isset($daftarKondisi[$kondisiKey])) {
    $errors[] = 'Kondisi tidak valid.';
}

// ===== HITUNG HASIL (hanya jika tidak ada error) =====
$berhasil = count($errors) === 0;
if ($berhasil) {
    $total = hitungTotal($jumlah, $harga);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hasil Pemrosesan - SIM-Barang</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <header>
    <div class="brand">
      <span class="logo" aria-hidden="true">📦</span>
      <div>
        <h1>SIM-Barang</h1>
        <p>Hasil Pemrosesan Data Barang</p>
      </div>
    </div>
  </header>

  <main class="hasil">
    <section>

      <?php if ($berhasil): ?>

        <h2>✅ Data Barang Berhasil Diproses</h2>
        <p class="petunjuk">Data diterima server lewat metode <strong>POST</strong> dan dihitung oleh PHP.</p>

        <div class="table-wrap">
          <table>
            <caption>Ringkasan pemrosesan</caption>
            <thead>
              <tr>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Kondisi</th>
                <th>Total Estimasi Nilai</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><?= htmlspecialchars($kode) ?></td>
                <td><?= htmlspecialchars($nama) ?></td>
                <td><?= htmlspecialchars($daftarKategori[$kategoriKey]) ?></td>
                <td><?= $jumlah ?></td>
                <td><?= rupiah($harga) ?></td>
                <td><?= htmlspecialchars($daftarKondisi[$kondisiKey]) ?></td>
                <td class="sel-total"><?= rupiah($total) ?></td>
              </tr>
            </tbody>
          </table>
        </div>

        <p class="rumus">
          🧮 Perhitungan: <?= $jumlah ?> unit &times; <?= rupiah($harga) ?> =
          <strong><?= rupiah($total) ?></strong>
        </p>

      <?php else: ?>

        <h2>⚠️ Data Belum Valid</h2>
        <div class="alert-error" role="alert">
          <ul class="daftar-error">
            <?php foreach ($errors as $pesan): ?>
              <li><?= htmlspecialchars($pesan) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>

      <?php endif; ?>

      <a class="btn-link" href="<?= $halamanUtama ?>">&larr; Kembali ke Formulir</a>

    </section>
  </main>

  <footer>
    <p>&copy; 2026 SIM-Barang &middot; Politeknik Negeri Sriwijaya</p>
  </footer>

</body>
</html>