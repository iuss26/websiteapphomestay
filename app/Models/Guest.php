<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'kontak',
        'no_identitas',
        'alamat',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
