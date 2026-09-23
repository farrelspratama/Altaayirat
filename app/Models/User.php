<?php

namespace App\Models;

// Illuminate\Foundation\Auth\User sudah menyertakan fitur bawaan Laravel
// untuk autentikasi (login, password hashing check, dsb), jadi kita extend
// dari situ, bukan dari Model biasa.
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    // Kolom yang boleh diisi lewat mass assignment (misal User::create([...]))
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    // Kolom yang TIDAK ikut ditampilkan kalau model ini diubah jadi JSON/array
    // (penting nanti saat bikin API di Fase 2, supaya password tidak bocor ke response)
    protected $hidden = [
        'password',
    ];

    // Otomatis meng-hash password setiap kali diisi, jadi di controller nanti
    // kamu tidak perlu manual panggil Hash::make() setiap saat assign password.
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * Satu user bisa mempunyai banyak order (riwayat pemesanan).
     * Relasi ini yang menyelesaikan bug "riwayat global" di versi lama:
     * nanti tinggal panggil $user->orders untuk dapat riwayat MILIK user ini saja.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
