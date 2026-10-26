<?php
// koneksi.php - koneksi database memakai PDO

$host = 'localhost';
$db   = 'sim_barang';
$user = 'root';
$pass = '';        // default Laragon/XAMPP: kosong

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $e) {
    http_response_code(500);
    die('Koneksi database gagal. Pastikan MySQL menyala dan database sim_barang sudah di-import.');
}