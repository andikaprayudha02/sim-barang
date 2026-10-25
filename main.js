'use strict';

// Jalankan setelah seluruh HTML selesai dimuat
document.addEventListener('DOMContentLoaded', function () {

  // ===== 1. AMBIL ELEMEN =====
  const form = document.getElementById('formBarang');
  const tbody = document.querySelector('#tabelBarang tbody');
  const inputCari = document.getElementById('cari');
  const toast = document.getElementById('toast');
  const tableWrap = document.querySelector('.table-wrap');
  const statJenis = document.getElementById('statJenis');
  const statUnit = document.getElementById('statUnit');
  const statBaik = document.getElementById('statBaik');

  // Matikan validasi bawaan browser agar pesan buatan kita yang tampil
  form.noValidate = true;

  // Pesan "data tidak ditemukan" (dibuat lewat JS, awalnya tersembunyi)
  const pesanKosong = document.createElement('p');
  pesanKosong.className = 'pesan-kosong';
  pesanKosong.textContent = 'Tidak ada barang yang cocok dengan pencarian.';
  pesanKosong.hidden = true;
  tableWrap.after(pesanKosong);


  // ===== 2. TOAST =====
  let timerToast;

  function tampilToast(pesan, tipe = 'sukses') {
    clearTimeout(timerToast); // batalkan timer lama bila toast dipicu berulang
    toast.textContent = pesan;
    toast.className = 'show ' + tipe;
    timerToast = setTimeout(function () {
      toast.classList.remove('show');
    }, 2500);
  }


  // ===== 3. PESAN ERROR PER KOLOM =====
  // Cari <span class="error"> milik kolom; jika belum ada, buat baru
  function getErrorEl(input) {
    let el = input.parentElement.querySelector('.error');
    if (!el) {
      el = document.createElement('span');
      el.className = 'error';
      input.after(el);
    }
    return el;
  }

  // Tampilkan/hapus error. Mengembalikan true jika kolom valid.
  function setError(input, pesan) {
    getErrorEl(input).textContent = pesan;
    input.classList.toggle('input-error', pesan !== '');
    return pesan === '';
  }


  // ===== 4. ATURAN VALIDASI =====
  function kodeSudahAda(kode) {
    return Array.from(tbody.rows).some(function (tr) {
      return tr.cells[0].textContent.trim() === kode;
    });
  }

  // Setiap fungsi mengembalikan teks error, atau '' jika valid
  const aturan = {
    kode: function (nilai) {
      if (!/^BRG-\d+$/.test(nilai)) {
        return 'Kode harus diawali BRG- diikuti angka (contoh: BRG-001)';
      }
      if (kodeSudahAda(nilai)) {
        return 'Kode ' + nilai + ' sudah terdaftar';
      }
      return '';
    },
    nama: function (nilai) {
      return nilai.length < 3 ? 'Nama barang minimal 3 karakter' : '';
    },
    kategori: function (nilai) {
      return nilai === '' ? 'Pilih salah satu kategori' : '';
    },
    jumlah: function (nilai) {
      const angka = Number(nilai);
      if (nilai === '' || !Number.isInteger(angka) || angka <= 0) {
        return 'Jumlah harus berupa bilangan bulat lebih dari 0';
      }
      return '';
    },
    kondisi: function (nilai) {
      return nilai === '' ? 'Pilih kondisi barang' : '';
    }
  };

  // Teks yang terlihat pada dropdown (misal "Elektronik"), bukan value-nya
  function teksPilihan(select) {
    return select.options[select.selectedIndex].text;
  }


  // ===== 5. TAMBAH BARIS KE TABEL =====
  function tambahBaris(data) {
    const tr = document.createElement('tr');
    [data.kode, data.nama, data.kategori, data.jumlah, data.kondisi].forEach(function (teks) {
      const td = document.createElement('td');
      td.textContent = teks; // textContent aman: tag HTML yang diketik user tidak dijalankan
      tr.appendChild(td);
    });
    tbody.appendChild(tr);
  }
    function hitungStatistik() {
    let unit = 0;
    let baik = 0;
    Array.from(tbody.rows).forEach(function (tr) {
      const jumlah = Number(tr.cells[3].textContent);
      unit += jumlah;
      if (tr.cells[4].textContent.trim() === 'Baik') baik += jumlah;
    });
    statJenis.textContent = tbody.rows.length;
    statUnit.textContent = unit;
    statBaik.textContent = baik;
  }

  hitungStatistik(); // hitung sekali saat halaman dibuka


  // ===== 6. SUBMIT FORMULIR =====
  form.addEventListener('submit', function (e) {
    e.preventDefault(); // cegah reload halaman

    const daftarKolom = ['kode', 'nama', 'kategori', 'jumlah', 'kondisi'];
    let semuaValid = true;
    let kolomPertamaSalah = null;

    daftarKolom.forEach(function (id) {
      const input = document.getElementById(id);
      const pesan = aturan[id](input.value.trim());
      if (!setError(input, pesan)) {
        semuaValid = false;
        if (!kolomPertamaSalah) kolomPertamaSalah = input;
      }
    });

    if (!semuaValid) {
      kolomPertamaSalah.focus();
      tampilToast('Periksa kembali isian formulir', 'gagal');
      return;
    }

    tambahBaris({
      kode: document.getElementById('kode').value.trim(),
      nama: document.getElementById('nama').value.trim(),
      kategori: teksPilihan(document.getElementById('kategori')),
      jumlah: document.getElementById('jumlah').value.trim(),
      kondisi: teksPilihan(document.getElementById('kondisi'))
    });

    form.reset();
    hitungStatistik();
    filterTabel(); // sesuaikan dengan kata kunci pencarian yang masih aktif
    tampilToast('Barang berhasil ditambahkan!');
  });

  // Hapus pesan error begitu pengguna mulai memperbaiki isian
  form.addEventListener('input', function (e) {
    if (e.target.classList.contains('input-error')) {
      setError(e.target, '');
    }
  });


  // ===== 7. PENCARIAN REAL-TIME =====
  function filterTabel() {
    const kataKunci = inputCari.value.trim().toLowerCase();
    let terlihat = 0;

    Array.from(tbody.rows).forEach(function (tr) {
      const cocok = tr.textContent.toLowerCase().includes(kataKunci);
      tr.hidden = !cocok;
      if (cocok) terlihat++;
    });

    pesanKosong.hidden = terlihat > 0;
  }

  inputCari.addEventListener('input', filterTabel);

});