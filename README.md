# Teras Abah Homestay - Sistem Reservasi Online

Sebuah aplikasi web manajemen penginapan (Homestay) berbasis Laravel yang dilengkapi dengan fitur pemesanan (*booking*) untuk tamu dan dasbor manajemen lengkap untuk pengelola (Admin).

## 🚀 Fitur Utama

**Untuk Tamu (Frontend):**
- **Katalog Kamar**: Melihat daftar kamar yang tersedia beserta harga dan fasilitasnya.
- **Pemesanan Online (Booking)**: Formulir *checkout* yang mudah untuk memesan kamar, menentukan tanggal *check-in/check-out*, dan mengatur jumlah tamu.
- **Pembayaran Fleksibel**: Mendukung pembayaran penuh maupun DP (Down Payment / Uang Muka) minimal Rp 50.000 dengan metode transfer bank atau *scan* QRIS.
- **Unggah Bukti Pembayaran**: Tamu dapat mengunggah struk transfer melalui sistem.

**Untuk Pengelola (Admin Dashboard):**
- **Sistem Login yang Aman**: Hanya admin terotorisasi yang dapat mengakses dasbor.
- **Manajemen Kamar (CRUD)**: Menambah, mengubah, dan menghapus data kamar, serta mengunggah foto kamar.
- **Manajemen Reservasi**: Melihat pesanan masuk, menyetujui (Verifikasi) pembayaran tamu, dan memantau status pembayaran (Lunas / DP).
- **Manajemen Tamu**: Melihat riwayat pengunjung yang pernah menginap.
- **Pencatatan Pengeluaran**: Mencatat biaya operasional seperti listrik, air, gaji karyawan, dsb.
- **Laporan Keuangan Otomatis**: Laporan laba/rugi yang mengakumulasi total pemasukan (reservasi Lunas & DP) dikurangi total pengeluaran. Bisa dicetak atau diekspor ke CSV.

## 🛠️ Teknologi yang Digunakan
- **Backend Framework**: Laravel (PHP)
- **Database**: SQLite (Bawaan Laravel untuk kemudahan portabilitas)
- **Styling**: Tailwind CSS (melalui CDN)
- **Interaktivitas (JS)**: Alpine.js (Untuk menu responsif *mobile* dan *sidebar*) & Flatpickr (Untuk *Datepicker*)

## 📦 Panduan Instalasi (Development)

1. **Persyaratan Sistem**: Pastikan PHP dan Composer sudah terinstal di komputer Anda.
2. **Kloning Proyek**: Unduh atau klon repositori ini.
3. **Instal Dependensi**: 
   ```bash
   composer install
   ```
4. **Pengaturan Lingkungan (Environment)**:
   Salin file `.env.example` menjadi `.env`.
   ```bash
   cp .env.example .env
   ```
5. **Buat Application Key**:
   ```bash
   php artisan key:generate
   ```
6. **Siapkan Database**:
   Jalankan migrasi untuk membangun struktur tabel.
   ```bash
   php artisan migrate
   ```
7. **Jalankan Server Lokal**:
   ```bash
   php artisan serve
   ```
8. Akses website melalui `http://localhost:8000` di *browser* Anda.

## 🔑 Akses Admin (Default)

Untuk masuk ke panel pengelolaan, klik tombol "Login Admin" di bagian paling bawah (*footer*) website, lalu gunakan kredensial berikut:
- **Email**: `admin@terasabah.com`
- **Password**: `AdminTeras2026!`

*(Sangat disarankan untuk mengubah password ini setelah website mengudara demi alasan keamanan).*

## 📁 Struktur Inti Direktori

- `app/Http/Controllers/`: Berisi logika utama aplikasi.
  - `ReservationController.php`: Logika utama proses *booking* tamu.
  - `Admin/`: Kumpulan *controller* khusus dasbor admin.
- `app/Models/`: Definisi tabel database dan relasinya (`Room`, `Reservation`, `Payment`, `Expense`).
- `database/migrations/`: Cetak biru struktur *database*.
- `resources/views/`: File-file antarmuka (UI/HTML).
  - `layouts/`: Master *template* (Tamu & Admin).
  - `admin/`: Semua tampilan dasbor admin.
  - `reservations/`: Formulir pemesanan tamu.

---
*Dibangun dengan ❤️ untuk Teras Abah Homestay.*
