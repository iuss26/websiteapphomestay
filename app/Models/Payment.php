<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Payment (Pembayaran)
 * Menyimpan riwayat pembayaran DP atau Pelunasan untuk sebuah reservasi.
 */
class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'jumlah',
        'metode',
        'status',
        'tanggal',
        'bukti_bayar',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'datetime',
        ];
    }

    /**
     * Relasi Many-to-One: Setiap pembayaran merujuk pada satu Reservasi.
     */
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
