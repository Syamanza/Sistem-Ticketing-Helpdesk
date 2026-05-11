# Helpdesk Ticketing System

Sistem Ticketing berbasis Web yang dibangun menggunakan **Laravel 11** dan **SQLite** untuk memudahkan pencatatan keluhan (tiket) oleh Karyawan dan pengelolaan oleh IT Support.

## 🚀 Fitur Utama
Aplikasi ini memiliki 2 aktor utama (User/Employee & IT Support) dengan alur kerja berikut:
1. **User (Employee)**: Dapat membuat tiket keluhan baru beserta pemilihan kategori.
2. **IT Support**: 
   - Dapat melihat seluruh tiket yang ada.
   - Dapat melakukan *filtering* tiket berdasarkan **Status** dan **Kategori**.
   - Dapat memperbarui status tiket (*Open → On Progress → Resolved → Closed*).
3. **Ticket History (Log)**: Setiap perubahan status, termasuk pembuatan tiket dan penambahan catatan (*notes*) oleh IT Support otomatis tercatat pada log *timeline* di halaman detail tiket.

## 🛠 Syarat Sistem (System Requirements)
- PHP >= 8.2
- Composer

## 📖 Panduan Instalasi (Langkah Menjalankan Project)
Karena aplikasi ini menggunakan database **SQLite**, Anda **tidak perlu** mengkonfigurasi XAMPP, MySQL, atau `phpMyAdmin`. Cukup ikuti langkah-langkah praktis berikut:

1. **Clone Repository**
   ```bash
   git clone <isi-dengan-link-repository-github-anda>
   cd <nama-folder-repo>
   ```

2. **Install Dependencies**
   Jalankan perintah berikut untuk mengunduh semua pustaka Laravel yang dibutuhkan:
   ```bash
   composer install
   ```

3. **Konfigurasi Environment**
   Salin file konfigurasi bawaan (`.env.example`) menjadi file `.env` aktif:
   ```bash
   cp .env.example .env
   ```
   *(Catatan: Konfigurasi `.env` sudah menggunakan `DB_CONNECTION=sqlite` secara bawaan).*

4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

5. **Buat Database SQLite & Jalankan Migrasi (Beserta Seeder)**
   Jalankan perintah ini untuk membuat file database secara otomatis, memigrasikan tabel, dan mengisi data awal (seeder):
   ```bash
   php artisan migrate:fresh --seed
   ```
   *Penting: Perintah di atas akan secara otomatis menambahkan Data Dummy (Kategori Tiket & Akun Pengguna) sehingga sistem langsung siap dites.*

6. **Jalankan Development Server**
   ```bash
   php artisan serve
   ```
   Akses aplikasi di browser melalui URL: **`http://127.0.0.1:8000`**

---

## 🔐 Akun Akses Demo (Seeder)
Sistem sudah dilengkapi dengan akun contoh untuk keperluan evaluasi/pengujian. Silakan gunakan kredensial berikut di halaman Login:

**Akses Karyawan (Role: User)**
- Email: `employee@company.com`
- Password: `password`

**Akses Tim IT (Role: Support)**
- Email: `support@company.com`
- Password: `password`

---

## 🗄 Dokumentasi Database
File penjelasan skema database dan relasi Entity (Foreign Key) terlampir di dalam file `database_design.md` di root folder. Database fisik menggunakan SQLite dan akan otomatis di-generate di direktori `database/database.sqlite` saat Anda menjalankan perintah *migrate*.
