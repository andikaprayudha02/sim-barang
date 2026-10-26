<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SIM-Barang - Inventaris Barang Jurusan</title>
</head>
<body>

  <header>
    <h1>SIM-Barang</h1>
    <p>Sistem Pengelolaan Inventaris Barang Jurusan</p>
  </header>

  <nav>
    <ul>
      <li><a href="#inventaris">Inventaris</a></li>
      <li><a href="#form-barang">Tambah Barang</a></li>
    </ul>
  </nav>

  <main>

    <section id="inventaris">
      <h2>Tabel Inventaris Barang</h2>
      <table border="1">
        <caption>Daftar barang di jurusan</caption>
        <thead>
          <tr>
            <th>Kode</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Jumlah</th>
            <th>Kondisi</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>BRG-001</td>
            <td>Laptop Asus</td>
            <td>Elektronik</td>
            <td>20</td>
            <td>Baik</td>
          </tr>
          <tr>
            <td>BRG-002</td>
            <td>Proyektor Epson</td>
            <td>Elektronik</td>
            <td>5</td>
            <td>Baik</td>
          </tr>
          <tr>
            <td>BRG-003</td>
            <td>Kursi Lab</td>
            <td>Furnitur</td>
            <td>40</td>
            <td>Rusak Ringan</td>
          </tr>
        </tbody>
      </table>
    </section>

    <section id="form-barang">
      <h2>Formulir Input Barang</h2>
      <form action="#" method="post">
        <p>
          <label for="kode">Kode Barang</label><br>
          <input type="text" id="kode" name="kode" placeholder="Contoh: BRG-001" required>
        </p>
        <p>
          <label for="nama">Nama Barang</label><br>
          <input type="text" id="nama" name="nama" placeholder="Nama barang" required>
        </p>
        <p>
          <label for="kategori">Kategori</label><br>
          <select id="kategori" name="kategori" required>
            <option value="">-- Pilih Kategori --</option>
            <option value="elektronik">Elektronik</option>
            <option value="furnitur">Furnitur</option>
            <option value="alat-lab">Alat Lab</option>
          </select>
        </p>
        <p>
          <label for="jumlah">Jumlah</label><br>
          <input type="number" id="jumlah" name="jumlah" placeholder="0" required>
        </p>
        <p>
          <label for="kondisi">Kondisi</label><br>
          <select id="kondisi" name="kondisi" required>
            <option value="">-- Pilih Kondisi --</option>
            <option value="baik">Baik</option>
            <option value="rusak-ringan">Rusak Ringan</option>
            <option value="rusak-berat">Rusak Berat</option>
          </select>
        </p>
        <button type="submit">Simpan</button>
      </form>
    </section>

  </main>

  <footer>
    <p>&copy; 2026 SIM-Barang - (Nama Anda)</p>
  </footer>

</body>
</html>