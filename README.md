# 📚 Buku Tamu Digital – Aplikasi Web Sekolah

Aplikasi web buku tamu digital berbasis **PHP + MySQL + Bootstrap 5** untuk keperluan sekolah/instansi.

---

## 📁 Struktur File

```
buku_tamu/
├── index.php          → Halaman formulir kedatangan tamu
├── daftar_tamu.php    → Halaman daftar & pencarian tamu
├── koneksi.php        → Konfigurasi koneksi ke database MySQL
├── db_bukutamu.sql    → Script SQL untuk membuat database & tabel
└── README.md          → Petunjuk instalasi ini
```

---

## ⚙️ Cara Instalasi

### 1. Siapkan Server Lokal
Pastikan sudah menginstall **XAMPP** (atau LAMP/WAMP/Laragon).

### 2. Import Database
1. Buka **phpMyAdmin** → `http://localhost/phpmyadmin`
2. Klik **New** → buat database baru (jika belum ada) → atau langsung import
3. Pilih menu **Import** → pilih file `db_bukutamu.sql` → klik **Go**

> Database `db_bukutamu` dan tabel `buku_tamu` akan dibuat otomatis.

### 3. Konfigurasi Koneksi
Buka file `koneksi.php` dan sesuaikan:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');       // Username MySQL Anda
define('DB_PASS', '');           // Password MySQL Anda
define('DB_NAME', 'db_bukutamu');
```

### 4. Letakkan di Folder htdocs
Salin folder `buku_tamu/` ke:
- XAMPP : `C:/xampp/htdocs/buku_tamu/`
- LAMP  : `/var/www/html/buku_tamu/`

### 5. Akses di Browser
```
http://localhost/buku_tamu/index.php        → Form Tamu
http://localhost/buku_tamu/daftar_tamu.php  → Daftar Tamu
```

---

## 🗄️ Struktur Tabel `buku_tamu`

| Kolom     | Tipe         | Keterangan            |
|-----------|--------------|-----------------------|
| `id`      | INT (PK, AI) | Primary Key           |
| `nama`    | VARCHAR(150) | Nama lengkap tamu     |
| `instansi`| VARCHAR(150) | Asal instansi/lembaga |
| `tujuan`  | TEXT         | Tujuan kedatangan     |
| `tanggal` | DATE         | Tanggal kedatangan    |
| `waktu`   | TIME         | Waktu kedatangan      |

---

## ✨ Fitur Aplikasi

- ✅ Form input tamu dengan validasi
- ✅ Tanggal & waktu diisi **otomatis** (real-time clock di tampilan)
- ✅ Data tersimpan ke MySQL menggunakan `mysqli`
- ✅ Tabel daftar tamu dengan Bootstrap (`table-striped`, `table-hover`)
- ✅ **Pencarian** berdasarkan nama atau instansi
- ✅ **Statistik ringkas**: total tamu, tamu hari ini, jumlah instansi
- ✅ Desain responsif (mobile-friendly)
- ✅ Navbar navigasi antar halaman

---

## 🛠️ Teknologi

- **Frontend**: HTML5, Bootstrap 5.3, Bootstrap Icons, Google Fonts (Poppins)
- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+ / MariaDB
- **Koneksi DB**: MySQLi (prosedural)
