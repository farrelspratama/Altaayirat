<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AirlineController;
use App\Http\Controllers\AirportController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');
Route::redirect('/', 'cari-pesawat');

/*
|--------------------------------------------------------------------------
| Rute Pencarian Jadwal (tetap bisa diakses tanpa login)
|--------------------------------------------------------------------------
*/
Route::get('/cari-pesawat', [ScheduleController::class, 'searchForm'])
    ->name('schedules.search');

Route::get('/hasil-pencarian', [ScheduleController::class, 'searchResults'])
    ->name('schedules.results');

/*
|--------------------------------------------------------------------------
| Rute Autentikasi
|--------------------------------------------------------------------------
| middleware('guest') = HANYA boleh diakses kalau BELUM login.
| Kalau user yang sudah login coba buka /register atau /login, Laravel
| otomatis redirect mereka pergi dari sini (tidak masuk ke Controller sama sekali).
*/
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('auth.register.form');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('auth.login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
});

/*
|--------------------------------------------------------------------------
| middleware('auth') = HANYA boleh diakses kalau SUDAH login.
| Ini yang nanti akan membungkus fitur pemesanan (booking) - memastikan
| tidak ada lagi celah "halaman tanpa proteksi" seperti bug versi lama.
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/pesan/{schedule}', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/pesan/{schedule}', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/pesanan/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/tiket/{order}', [TicketController::class, 'show'])->name('tickets.show'); 
    // Route pemesanan (OrderController) akan kita tambahkan DI SINI,
    // di dalam grup middleware('auth') ini, pada langkah berikutnya.
});

/*
|--------------------------------------------------------------------------
| Rute Panel Konfirmasi Pembayaran (Khusus Staff / Admin)
|--------------------------------------------------------------------------
| Urutan middleware ['auth', 'staff'] sangat penting: pastikan user login dulu
| sebelum sistem memeriksa apakah dia memiliki hak akses 'staff'.
*/
Route::middleware(['auth', 'staff'])->prefix('admin')->group(function () {
    Route::get('/konfirmasi', [PaymentController::class, 'index'])->name('payments.index');
    Route::post('/konfirmasi/{payment}', [PaymentController::class, 'update'])->name('payments.update');
    Route::resource('airlines', AirlineController::class)->except(['show']);
    Route::resource('airports', AirportController::class)->except(['show']);
});