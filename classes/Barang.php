<?php
// classes/Barang.php - OOP dasar: class Barang

class Barang
{
    // Property (data milik objek)
    public string $kode;
    public string $nama;
    public int $jumlah;
    public int $harga;

    // Constructor: dijalankan otomatis saat objek dibuat dengan "new"
    public function __construct(string $kode, string $nama, int $jumlah, int $harga = 0)
    {
        $this->kode   = $kode;
        $this->nama   = $nama;
        $this->jumlah = $jumlah;
        $this->harga  = $harga;
    }

    // Method: menghitung total estimasi nilai aset
    public function hitungTotal(): int
    {
        return $this->jumlah * $this->harga;
    }

    // Method: menampilkan format informasi barang
    public function tampilInfo(): string
    {
        return "[{$this->kode}] {$this->nama} - Jumlah: {$this->jumlah} unit";
    }
}