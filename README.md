# Kasirius POS

Aplikasi web **Point of Sale (POS) + Inventori** berbasis Laravel. Dibuat untuk
mengelola produk, kategori, stok masuk, transaksi penjualan, hingga pencetakan
struk dan ekspor laporan ke Excel. Dibangun sebagai proyek mata kuliah di
Politeknik Negeri Samarinda dengan pembagian peran berbasis pola **MVC**
(Model–View–Controller).

---

## Daftar Isi

- [Fitur](#fitur)
- [Tampilan & UI/UX](#tampilan--uiux)
- [Teknologi yang Digunakan](#teknologi-yang-digunakan)
- [Kebutuhan Sistem](#kebutuhan-sistem)
- [Cara Mengambil & Menjalankan](#cara-mengambil--menjalankan)
- [Akun & Role](#akun--role)
- [Struktur Singkat Proyek](#struktur-singkat-proyek)
- [Troubleshooting](#troubleshooting)

---

## Fitur

### Autentikasi & Role
- Login / register (menggunakan Laravel Breeze).
- Dua peran pengguna: **Admin** dan **Kasir**.
- Pembatasan akses per-halaman lewat middleware `role` (mis. `role:admin`,
  `role:admin|kasir`).

### Dashboard
- Ringkasan penjualan hari ini, jumlah transaksi, jumlah produk, dan jumlah
  produk stok habis.
- Daftar transaksi terakhir dan daftar produk yang stoknya menipis.

### Kasir (POS)
- Grid produk dengan pencarian cepat (live search).
- Keranjang berbasis sesi: tambah, tambah qty, kurangi qty, dan hapus item.
- Pengecekan stok otomatis (tidak bisa menjual melebihi stok tersedia).
- Checkout dengan input uang bayar dan perhitungan kembalian.
- Proses checkout bersifat **atomik** (dibungkus database transaction) sehingga
  stok dan transaksi tidak akan tersimpan setengah-setengah bila terjadi error.

### Struk (Receipt)
- Struk siap cetak bergaya thermal (auto-print saat dibuka).
- Menyertakan **QR code** berisi ringkasan transaksi.
- Mencatat nama kasir yang melakukan transaksi.

### Manajemen Produk
- CRUD produk (khusus Admin).
- Pencarian dan filter berdasarkan kategori.
- Pagination pada daftar produk.
- Kasir dapat melihat daftar produk dan mengklik baris untuk menambahkannya ke
  keranjang.

### Kategori
- Tambah dan hapus kategori produk (khusus Admin).

### Stok Masuk (Stock In)
- Pencatatan barang yang baru datang beserta supplier (khusus Admin).
- Otomatis menambah stok produk terkait.

### Transaksi & Laporan
- Daftar riwayat transaksi (dengan pagination) dan halaman detail transaksi.
- **Ekspor laporan ke Excel** (.xlsx) untuk rentang: Hari Ini, Minggu Ini,
  Bulan Ini, Tahun Ini, dan rentang tanggal kustom.

### Peringatan Stok
- Halaman "Stok Habis / Menipis".
- Ambang batas stok menipis dipusatkan di `config/inventory.php`.

---

## Tampilan & UI/UX

- **Sidebar navigasi** dengan menu yang menyesuaikan role pengguna dan penanda
  halaman aktif.
- **Kartu statistik** pada dashboard untuk ringkasan angka penting.
- **Tabel konsisten** di seluruh halaman: header abu-abu, baris dengan efek
  hover, dan badge status (mis. "Habis" / "Menipis").
- **Vokabulari tombol yang seragam**: tombol aksi utama (biru), tombol sekunder
  / batal (outline), dan tombol semantik (hijau untuk "Bayar").
- **Ikon** memakai FontAwesome (tanpa emoji).
- **Pencarian**: debounce pada halaman produk, live filter pada halaman kasir.
- **Struk ramah cetak** memanfaatkan aturan `@media print`.
- **Notifikasi sukses/error** lewat flash message sesi.
- **Layout responsif** menggunakan utility grid Tailwind.

---

## Teknologi yang Digunakan

| Kategori        | Teknologi                                             |
|-----------------|-------------------------------------------------------|
| Framework       | Laravel 12 (PHP 8.2+)                                  |
| Database        | MySQL                                                  |
| Autentikasi     | Laravel Breeze                                         |
| Frontend build  | Vite 7                                                 |
| Styling         | Tailwind CSS 3                                         |
| Interaktivitas  | Alpine.js                                              |
| Ikon            | FontAwesome 6.5.1 (via CDN)                            |
| Ekspor Excel    | maatwebsite/excel 3.1 (PhpSpreadsheet)                |
| QR Code         | simplesoftwareio/simple-qrcode 4.2                    |

Pola arsitektur: **MVC** (Model, View, Controller) — bawaan Laravel.

---

## Kebutuhan Sistem

Pastikan terpasang di komputer:

- **PHP 8.2 atau lebih baru**
- **Composer** (manajer paket PHP)
- **Node.js + npm** (untuk membangun aset frontend)
- **MySQL** (mis. lewat XAMPP / Laragon)
- **Ekstensi PHP yang wajib aktif:**
  - `gd` — diperlukan oleh PhpSpreadsheet (ekspor Excel) dan simple-qrcode (QR).
  - `zip` — diperlukan untuk membuat file `.xlsx`.
  - `pdo_mysql`, `mbstring`, `openssl`, `fileinfo` — kebutuhan dasar Laravel.

> **Penting:** Ekstensi `gd` sering kali masih nonaktif secara default. Jika
> tidak diaktifkan, `composer install` akan gagal dan fitur Ekspor Excel serta
> QR code tidak berjalan. Cara mengaktifkannya ada di bagian
> [Troubleshooting](#troubleshooting).

---

## Cara Mengambil & Menjalankan

Ikuti langkah berikut dari awal hingga aplikasi berjalan di browser.

### 1. Ambil kode proyek

Jika menggunakan Git:

```bash
git clone <url-repository> kasirius
cd kasirius
```

Atau unduh ZIP-nya, lalu ekstrak dan masuk ke folder proyek.

> **Catatan:** Jangan menyalin folder `vendor/` atau `node_modules/` dari
> komputer lain. Keduanya harus dihasilkan ulang dengan `composer install` dan
> `npm install` agar sesuai dengan versi paket pada proyek ini.

### 2. Aktifkan ekstensi `gd` (jika belum)

Lihat bagian [Troubleshooting](#troubleshooting). Lakukan ini **sebelum**
`composer install`.

### 3. Pasang dependensi PHP

```bash
composer install
```

### 4. Siapkan file environment

```bash
# Windows (Command Prompt)
copy .env.example .env

# Linux / macOS
cp .env.example .env
```

Lalu buka `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kasirius_db
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Buat application key

```bash
php artisan key:generate
```

### 6. Buat database

Buat database kosong bernama **`kasirius_db`** (sesuai `DB_DATABASE` di `.env`),
misalnya lewat phpMyAdmin atau terminal MySQL:

```sql
CREATE DATABASE kasirius_db;
```

### 7. Jalankan migrasi (dan seeder bila perlu)

```bash
php artisan migrate
```

Untuk mengisi data awal (membuat satu user default):

```bash
php artisan migrate --seed
```

### 8. Pasang dependensi frontend & bangun aset

```bash
npm install
npm run build
```

> Saat aktif mengembangkan tampilan, jalankan `npm run dev` (bukan `build`) agar
> perubahan CSS/JS langsung ter-compile.

### 9. Jalankan server

```bash
php artisan serve
```

Buka browser ke alamat yang ditampilkan, biasanya:

```
http://127.0.0.1:8000
```

Selesai. Aplikasi siap digunakan.

---

## Akun & Role

- Aplikasi memiliki dua role: **admin** dan **kasir**.
- Secara default, kolom `role` pada tabel users bernilai **`kasir`**.
- Untuk membuat akun **admin**, daftar lewat halaman register lalu ubah nilai
  `role` menjadi `admin` langsung di database, atau lewat Tinker:

```bash
php artisan tinker
```

```php
$u = App\Models\User::where('email', 'emailanda@contoh.com')->first();
$u->role = 'admin';
$u->save();
```

Perbedaan hak akses:

| Fitur                          | Admin | Kasir |
|--------------------------------|:-----:|:-----:|
| Dashboard                      |  Ya   |  Ya   |
| Kasir & Checkout               |  Ya   |  Ya   |
| Lihat Produk                   |  Ya   |  Ya   |
| Tambah/Edit/Hapus Produk       |  Ya   |  -    |
| Kategori                       |  Ya   |  -    |
| Stok Masuk                     |  Ya   |  -    |
| Stok Habis                     |  Ya   |  -    |
| Transaksi & Ekspor Excel       |  Ya   |  Ya   |

---

## Struktur Singkat Proyek

```
app/
  Http/Controllers/   Controller (logika request/response)
  Http/Middleware/    RoleMiddleware (pembatasan akses per-role)
  Models/             Model Eloquent (Product, Category, Transaction, dst.)
  Exports/            TransactionExport (definisi ekspor Excel)
config/
  inventory.php       Ambang batas stok menipis
database/
  migrations/         Definisi struktur tabel
  seeders/            Data awal
resources/
  views/              Tampilan Blade (View)
  css/ js/            Sumber aset frontend
routes/
  web.php             Definisi route aplikasi
  auth.php            Route autentikasi (Breeze)
```

---

## Troubleshooting

### `composer install` gagal: `ext-gd is missing`

PhpSpreadsheet dan simple-qrcode membutuhkan ekstensi `gd`. Aktifkan dengan:

1. Cari lokasi file `php.ini` yang dipakai:
   ```bash
   php --ini
   ```
2. Buka `php.ini` tersebut, cari baris:
   ```ini
   ;extension=gd
   ```
3. Hapus tanda titik koma (`;`) di depannya sehingga menjadi:
   ```ini
   extension=gd
   ```
4. Simpan, lalu verifikasi:
   ```bash
   php -m
   ```
   Pastikan `gd` muncul di daftar. Jika menjalankan lewat Apache (XAMPP),
   **restart Apache** agar perubahan terbaca.
5. Ulangi `composer install`.

### Tampilan berantakan / CSS tidak muncul

Aset frontend belum dibangun. Jalankan:

```bash
npm install
npm run build
```

### Error koneksi database

- Pastikan layanan **MySQL sudah berjalan** (mis. dari panel XAMPP/Laragon).
- Pastikan database `kasirius_db` sudah dibuat.
- Pastikan kredensial di `.env` sesuai, lalu jalankan:
  ```bash
  php artisan config:clear
  ```

### Halaman selalu 403 (Akses ditolak)

Akun yang dipakai kemungkinan berperan `kasir` sementara halaman tersebut khusus
`admin`. Ubah role akun menjadi `admin` (lihat bagian
[Akun & Role](#akun--role)).
