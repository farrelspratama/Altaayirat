# Altaayirat — Sistem Pemesanan Tiket Pesawat

Aplikasi web pemesanan tiket pesawat berbasis Laravel (Blade), dibangun ulang dari versi lama berbasis PHP native sebagai proyek pengembangan diri & portofolio.

## Tech Stack

- **Backend & Frontend:** Laravel (Blade)
- **Database:** MySQL
- **Styling:** Tailwind CSS
- **Auth:** Laravel Auth bawaan (session-based, role: user/admin/penjual)

## Fitur

- [x] Registrasi & Login (dengan password hashing)
- [x] Pencarian jadwal penerbangan
- [x] Pemilihan kursi & pembuatan pemesanan (dengan proteksi race condition via row locking)
- [x] Status pesanan personal (dengan authorization check kepemilikan)
- [x] Panel konfirmasi pembayaran khusus staff (role-based middleware)
- [x] E-tiket digital
- [ ] CRUD admin untuk data master (Airlines, Planes, Airports, Routes, Schedules)
- [ ] UI/UX dengan Tailwind CSS
- [ ] Automated testing
- [ ] Deployment

## Latar Belakang

Proyek ini adalah pengembangan ulang dari aplikasi Altaayirat versi lama (PHP native + MySQL) yang dibangun bersama rekan semasa kuliah. Versi lama memiliki beberapa keterbatasan teknis dan celah keamanan (SQL Injection, password plaintext, tidak ada otorisasi halaman admin, dll) yang telah dianalisis dan diperbaiki secara menyeluruh di versi ini. Detail analisis lengkap dapat dilihat di dokumen internal proyek.

## Instalasi Lokal

```bash
git clone <url-repo-ini>
cd altaayirat
composer install
npm install
cp .env.example .env
php artisan key:generate
```

Sesuaikan koneksi database di `.env`, lalu:

```bash
php artisan migrate --seed
npm run dev
php artisan serve
```

Akses di `http://127.0.0.1:8000`.

## Struktur Role

| Role | Akses |
|---|---|
| `user` | Pencarian, pemesanan, lihat status & tiket pesanan sendiri |
| `admin` / `penjual` | Semua akses `user` + panel konfirmasi pembayaran (`/admin/konfirmasi`) |

Untuk menjadikan sebuah akun sebagai staff (sementara, sebelum ada UI manajemen user):
```bash
php artisan tinker
>>> \App\Models\User::find(1)->update(['role' => 'admin']);
```

## Status Proyek

Sedang dalam pengembangan aktif sebagai proyek pembelajaran & portofolio.
