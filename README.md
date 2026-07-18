<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# PPDB — Penerimaan Peserta Didik Baru

Aplikasi **Penerimaan Siswa Sekolah (PPDB)** berbasis Laravel dengan Filament Admin Panel, Socialite login, dan integrasi Spatie Settings. Aplikasi ini digunakan untuk mengelola proses pendaftaran siswa baru secara digital, mulai dari pengisian formulir pendaftaran, verifikasi berkas, seleksi, hingga pelaporan.

## Informasi untuk Developer

Aplikasi ini adalah sistem penerimaan peserta didik baru (_student admission_) yang mencakup fitur:

- **Pendaftaran Siswa** — Formulir pendaftaran online dengan upload dokumen (KK, akta, ijazah, dll.)
- **Verifikasi & Seleksi** — Panel admin untuk memverifikasi berkas dan menyeleksi calon siswa
- **Manajemen Data Master** — Kelola data sekolah, jurusan, tahun ajaran, dan lain-lain
- **Pelaporan** — Ekspor data pendaftar dan laporan statistik

## Stack Teknologi

- **Backend:** Laravel 12, PHP 8.3
- **Admin Panel:** Filament v4
- **Frontend:** Livewire 3, Alpine.js, Tailwind CSS v4
- **Auth:** Socialite (Google), Filament Shield (RBAC)
- **Settings:** Spatie Settings (konfigurasi dinamis)

## Fitur Utama

- Filament Admin Panel v4 untuk backoffice
- Login dengan Socialite (Google) dan email/password
- Manajemen pengguna dan hak akses berbasis role (Filament Shield)
- Pengaturan aplikasi dinamis via panel admin (Spatie Settings)
- Upload logo & favicon dari panel
- Formulir pendaftaran siswa dengan upload dokumen
- PDF viewer untuk preview dokumen pendaftar
- Footer custom dan lockscreen

## Instalasi

1. **Clone repository**
   ```bash
   git clone <repo-url>
   cd laravel-filament-socialite
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install && npm run dev
   ```

3. **Copy file .env dan konfigurasi**
   ```bash
   cp .env.example .env
   # Edit APP_URL, database, dan Socialite credentials di .env
   ```

4. **Generate key & migrate**
   ```bash
   php artisan key:generate
   php artisan migrate
   php artisan storage:link
   ```

5. **Seed user (opsional)**
   ```bash
   php artisan db:seed
   ```

6. **Jalankan aplikasi**
   ```bash
   php artisan serve
   ```

## Cara Menggunakan

- **Akses panel admin:**  
  Buka `http://localhost:8000/admin`
- **Login:**  
  Bisa menggunakan email/password atau Socialite (Google).
- **Pendaftaran:**  
  Resource "Pendaftaran" untuk melihat dan mengelola data calon siswa yang sudah mendaftar.
- **Verifikasi berkas:**  
  Panel admin menyediakan PDF viewer untuk melihat dokumen pendaftar (KK, akta, ijazah, dll.).
- **Pengaturan aplikasi:**  
  Menu "Pengaturan" di sidebar untuk mengubah nama situs, logo, favicon, dan deskripsi termasuk info PPDB (tahun ajaran, jadwal, dll.).
- **Manajemen pengguna:**  
  Menu "Pengguna" untuk CRUD user dan pengaturan role (admin, panitia, dll.).
- **Footer & lockscreen:**  
  Fitur tambahan untuk keamanan dan branding.

## Kustomisasi

- Tambahkan resource baru dengan:
  ```bash
  php artisan make:filament-resource NamaModel
  ```
- Tambahkan halaman custom:
  ```bash
  php artisan make:filament-page NamaPage
  ```
- Integrasi Socialite provider lain di `AdminPanelProvider.php`.

## Konfigurasi Socialite

- Pastikan redirect URI di Google Console sesuai dengan `.env`:
  ```
  GOOGLE_REDIRECT_URI=http://localhost:8000/admin/oauth/callback/google
  ```

## Pengaturan Dinamis

- Semua pengaturan aplikasi tersimpan di database menggunakan Spatie Settings.
- Logo dan favicon di-upload ke folder `storage/app/public/site-logos` dan `site-favicons`.

## Lisensi

MIT

---

> Dibuat dengan Laravel & Filament.  
> Untuk dokumentasi lebih lanjut, kunjungi [FilamentPHP](https://filamentphp.com) dan [Laravel](https://laravel.com).
