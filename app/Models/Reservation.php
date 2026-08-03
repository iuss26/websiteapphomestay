<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Reservation (Reservasi/Pemesanan)
 * Menyimpan data pemesanan kamar oleh tamu, tanggal menginap, dan total harga.
 */
class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'guest_id',
        'room_id',
        'tipe_reservasi',
        'check_in',
        'check_out',
        'status',
        'total_harga',
        'sumber_booking',
    ];

    /**
     * Relasi Many-to-One: Setiap reservasi pasti milik satu Tamu (Guest).
     */
    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    /**
     * Relasi Many-to-One: Setiap reservasi pasti memesan satu Kamar (Room).
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Relasi One-to-Many: Satu reservasi bisa memiliki beberapa pembayaran (DP lalu Pelunasan).
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Relasi One-to-One: Satu reservasi bisa memiliki satu ulasan (Review).
     */
    public function review()
    {
        return $this->hasOne(Review::class);
    }
}
