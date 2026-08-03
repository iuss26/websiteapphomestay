<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Room (Kamar)
 * Merepresentasikan data kamar homestay.
 */
class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'tipe',
        'kapasitas',
        'fasilitas',
        'harga_dasar',
        'harga_transit',
        'foto',
        'foto2',
        'foto3',
        'foto4',
        'foto5',
    ];

    /**
     * Relasi One-to-Many: Satu kamar bisa memiliki banyak riwayat harga khusus.
     */
    public function rates()
    {
        return $this->hasMany(RoomRate::class);
    }

    /**
     * Relasi One-to-Many: Satu kamar bisa dipesan berkali-kali (banyak reservasi).
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Memeriksa apakah kamar sedang terisi secara real-time.
     * Aturan Checkout: Pukul 12:00 WIB (Siang) pada tanggal check-out.
     * Jika waktu saat ini sudah lewat jam 12:00 siang di tanggal checkout, kamar otomatis menjadi Tersedia (Ready).
     */
    public function isOccupiedNow()
    {
        $now = \Carbon\Carbon::now();

        return $this->reservations()
            ->whereIn('status', ['Pending', 'Confirmed', 'Checked-in'])
            ->where(function ($query) use ($now) {
                // Check-in harus sudah terjadi
                $query->where('check_in', '<=', $now)
                    ->where(function ($q) use ($now) {
                        // Kasus 1: check_out menyimpan jam spesifik (misal Transit) -> bandingkan langsung
                        // Kasus 2: check_out menyimpan tanggal menginap -> batas checkout jam 12:00 siang
                        $q->where(function($sub1) use ($now) {
                            $sub1->whereDate('check_out', '>', $now->toDateString());
                        })->orWhere(function($sub2) use ($now) {
                            $sub2->whereDate('check_out', '=', $now->toDateString())
                                 ->whereRaw("? < '12:00:00'", [$now->format('H:i:s')]);
                        });
                    });
            })
            ->exists();
    }

    /**
     * Memeriksa apakah kamar tersedia pada rentang waktu check-in dan check-out tertentu.
     * Menginap harian hanya bisa 1 kali reservasi per tanggal,
     * KECUALI reservasi Transit (6 Jam) di mana beberapa transit di tanggal yang sama diperbolehkan
     * selama interval waktunya tidak tumpang tindih (overlap).
     */
    public function isAvailable($checkIn, $checkOut, $excludeReservationId = null)

    {
        $checkInDt = \Carbon\Carbon::parse($checkIn);
        $checkOutDt = \Carbon\Carbon::parse($checkOut);

        return !$this->reservations()
            ->whereIn('status', ['Pending', 'Confirmed', 'Checked-in'])
            ->when($excludeReservationId, function ($query, $id) {
                $query->where('id', '!=', $id);
            })
            ->where(function ($query) use ($checkInDt, $checkOutDt) {
                $query->where('check_in', '<', $checkOutDt)
                      ->where('check_out', '>', $checkInDt);
            })
            ->exists();
    }
}

