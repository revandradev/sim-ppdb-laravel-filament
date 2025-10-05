<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Laravel Filament Socialite Boilerplate

Boilerplate aplikasi Laravel dengan Filament Admin Panel, Socialite login, dan integrasi Spatie Settings. Cocok untuk pengembangan backoffice modern dengan autentikasi sosial dan pengaturan dinamis.

## Fitur Utama

- Filament Admin Panel v4
- Login dengan Socialite (Google, dll)
- Manajemen pengguna dan hak akses (Filament Shield)
- Pengaturan aplikasi dinamis (Spatie Settings)
- Upload logo & favicon dari panel
- Footer custom dan lockscreen
- Struktur siap pakai untuk resource, page, dan widget

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
- **Pengaturan aplikasi:**  
  Menu "Pengaturan" di sidebar untuk mengubah nama situs, logo, favicon, dan deskripsi.
- **Manajemen pengguna:**  
  Menu "Pengguna" untuk CRUD user dan pengaturan role.
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
