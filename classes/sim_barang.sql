-- sim_barang.sql : DDL (CREATE TABLE) dan DML (INSERT INTO)

CREATE DATABASE IF NOT EXISTS sim_barang
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sim_barang;

-- Hapus tabel lama (anak dulu, baru induk) agar skrip bisa diulang
DROP TABLE IF EXISTS barang;
DROP TABLE IF EXISTS kategori;
DROP TABLE IF EXISTS users;

-- ===== DDL =====
CREATE TABLE users (
  id_user      INT AUTO_INCREMENT PRIMARY KEY,
  username     VARCHAR(50)  NOT NULL UNIQUE,
  password     VARCHAR(255) NOT NULL,
  nama_lengkap VARCHAR(100) NOT NULL,
  role         ENUM('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB;

CREATE TABLE kategori (
  id_kategori   INT AUTO_INCREMENT PRIMARY KEY,
  nama_kategori VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE barang (
  id_barang   INT AUTO_INCREMENT PRIMARY KEY,
  kode        VARCHAR(20)  NOT NULL UNIQUE,
  nama        VARCHAR(150) NOT NULL,
  id_kategori INT NOT NULL,
  jumlah      INT NOT NULL,
  harga       DECIMAL(15,0) NOT NULL DEFAULT 0,
  kondisi     ENUM('Baik','Rusak Ringan','Rusak Berat') NOT NULL DEFAULT 'Baik',
  dibuat_oleh INT NULL,
  CONSTRAINT fk_barang_kategori FOREIGN KEY (id_kategori)
    REFERENCES kategori(id_kategori) ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_barang_user FOREIGN KEY (dibuat_oleh)
    REFERENCES users(id_user) ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB;

-- ===== DML =====
INSERT INTO users (username, password, nama_lengkap, role) VALUES
  ('admin', SHA2('password123', 256), 'Administrator', 'admin'),
  ('user',  SHA2('user123', 256),     'User Demo',     'user');

INSERT INTO kategori (nama_kategori) VALUES
  ('Elektronik'),
  ('Furnitur'),
  ('Alat Lab');

INSERT INTO barang (kode, nama, id_kategori, jumlah, harga, kondisi, dibuat_oleh) VALUES
  ('BRG-001', 'Laptop Asus',     1, 20, 7500000, 'Baik',         1),
  ('BRG-002', 'Proyektor Epson', 1,  5, 5000000, 'Baik',         1),
  ('BRG-003', 'Kursi Lab',       2, 40,  350000, 'Rusak Ringan', 1);