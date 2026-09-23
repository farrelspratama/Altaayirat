<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Passenger extends Model
{
    protected $fillable = [
        'full_name',
        'phone_number',
        'email',
        'birth_date',
        'gender',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date', // otomatis jadi object Carbon, bukan string mentah
        ];
    }

    /**
     * Satu data penumpang bisa dipakai di banyak order (ingat: satu akun
     * bisa memesankan tiket untuk orang yang sama berkali-kali).
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
