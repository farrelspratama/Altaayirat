<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Airline extends Model
{
    protected $fillable = [
        'name',
    ];

    /**
     * Satu maskapai punya banyak pesawat.
     */
    public function planes(): HasMany
    {
        return $this->hasMany(Plane::class);
    }
}
