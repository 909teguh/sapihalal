# SapiHalal

Sistem Informasi Sertifikat Veteriner — aplikasi web untuk mengelola data mitra dan sertifikat veteriner produk halal di Kota Padang, Sumatera Barat.

## Fitur

- **Peta Interaktif Mitra** — Halaman publik dengan peta Leaflet yang menampilkan lokasi seluruh mitra. Dapat difilter berdasarkan kecamatan dan kelurahan.
- **Manajemen Mitra** — CRUD data mitra: nama, alamat, pemilik, koordinat geografis, status aktif, upload foto, dan sertifikat.
- **Sertifikat Veteriner** — Pencatatan sertifikat per mitra: jenis hewan, volume (karkas, jeroan merah, jeroan hijau, kulit), asal produk, penerima, dokter hewan, dan scan dokumen.
- **Dashboard Analitik** — Ringkasan statistik, rekap volume produk bulan berjalan, tren sertifikat 12 bulan terakhir, dan top 5 mitra berdasarkan volume.
- **Role-Based Access Control** — 3 role (Superadmin, Admin, Guest) dengan permission granular via Spatie Laravel Permission.
- **Keamanan** — Autentikasi dengan Laravel Fortify: login, registrasi, verifikasi email, two-factor authentication, passkeys/WebAuthn, dan reset password.

## Tech Stack

| Komponen | Teknologi |
|---|---|
| Backend | PHP 8.3+, Laravel 13 |
| Frontend | Livewire 4, Flux UI 2, Tailwind CSS 4, Alpine.js |
| Autentikasi | Laravel Fortify |
| Otorisasi | Spatie Laravel Permission 8 |
| Peta | Leaflet 1.9 |
| Database | SQLite (default) / MySQL / PostgreSQL |
| Testing | Pest 4 |
| Linting | Laravel Pint |
| Static Analysis | Larastan |

## Prasyarat

- PHP 8.3 atau lebih baru
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/) 20+
- [Laravel Herd](https://herd.laravel.com/) (opsional, untuk development lokal)

## Instalasi

```bash
git clone <repository-url>
cd sapihalal
composer setup
php artisan db:seed
```

Perintah `composer setup` akan menjalankan:

1. `composer install`
2. Menyalin `.env.example` ke `.env`
3. `php artisan key:generate`
4. `php artisan migrate --force`
5. `npm install`
6. `npm run build`

## Lisensi

MIT
