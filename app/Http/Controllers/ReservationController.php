<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Guest;
use App\Models\Reservation;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReservationController extends Controller
{
    /**
     * Menampilkan halaman formulir pemesanan kamar (Checkout).
     * Menghitung total harga berdasarkan durasi menginap atau transit (6 Jam).
     */
    public function checkout(Request $request, $room_id)
    {
        $room = Room::findOrFail($room_id);
        $tipe_reservasi = $request->tipe_reservasi ?? 'Menginap';
        $guests         = $request->guests ?? 1;

        if ($tipe_reservasi == 'Transit') {
            if (!$room->harga_transit) {
                return back()->with('error', 'Kamar ini tidak mendukung pemesanan Transit.');
            }
            // Transit: checkin berisi datetime lengkap (Y-m-d H:i)
            $checkin_raw  = $request->checkin ?? Carbon::today()->format('Y-m-d') . ' 08:00';
            $checkin_date = Carbon::parse($checkin_raw);
            $check_out_dt = $checkin_date->copy()->addHours(6);
            $checkin  = $checkin_date->format('Y-m-d H:i');
            $checkout = $check_out_dt->format('Y-m-d H:i');
            $nights = 0;
            $durasi_teks = 'Transit (6 Jam) — ' . $checkin_date->format('H:i') . ' s/d ' . $check_out_dt->format('H:i');
            $total_harga = $room->harga_transit;
        } else {
            // Menginap: gabungkan tanggal + jam check-in yang dipilih
            $checkin_date_raw = $request->checkin_date ?? $request->checkin ?? Carbon::today()->format('Y-m-d');
            $checkin_time_raw = $request->checkin_time ?? '14:00';
            $checkin_date     = Carbon::parse($checkin_date_raw . ' ' . $checkin_time_raw);

            // Check-out: tanggal dipilih tamu, jam otomatis 12:00
            $checkout_date_raw = $request->checkout ?? Carbon::tomorrow()->format('Y-m-d');
            $check_out_dt      = Carbon::parse($checkout_date_raw)->setTime(12, 0, 0);

            $nights = (int) Carbon::parse($checkin_date_raw)->diffInDays(Carbon::parse($checkout_date_raw));
            if ($nights < 1) $nights = 1;
            $durasi_teks = $nights . ' Malam (Check-in ' . $checkin_date->format('H:i') . ', Check-out 12:00)';
            $total_harga = $room->harga_dasar * $nights;

            $checkin  = $checkin_date->format('Y-m-d H:i');
            $checkout = $check_out_dt->format('Y-m-d H:i');
        }

        // Cek Ketersediaan Kamar
        if (!$room->isAvailable($checkin_date, $check_out_dt)) {
            return redirect()->route('rooms.show', $room->id)
                ->with('error', 'Kamar tidak tersedia pada jam/tanggal tersebut. Silakan pilih waktu lain.');
        }

        return view('reservations.checkout', compact('room', 'checkin', 'checkout', 'guests', 'nights', 'total_harga', 'tipe_reservasi', 'durasi_teks'));
    }

    /**
     * Memproses data formulir checkout dari tamu.
     * Membuat data Tamu (Guest) baru jika belum ada, lalu membuat data Reservasi.
     * Setelah berhasil, tamu diarahkan ke halaman pembayaran.
     */
    public function store(Request $request, $room_id)
    {
        $request->validate([
            'nama'              => 'required',
            'kontak'            => 'required',
            'alamat'            => 'required',
            'tipe_reservasi'    => 'required|in:Menginap,Transit',
            'checkin'           => 'required',
            'metode_pembayaran' => 'required|in:Bayar di Tempat,Transfer Bank',
        ]);

        $room = Room::findOrFail($room_id);

        if ($request->tipe_reservasi == 'Transit') {
            // checkin field sudah berisi datetime lengkap (Y-m-d H:i) dari widget
            $check_in_dt  = Carbon::parse($request->checkin);
            $check_out_dt = $check_in_dt->copy()->addHours(6);
            $total_harga  = $room->harga_transit;
        } else {
            // checkin berisi datetime (tanggal + jam check-in)
            $check_in_dt  = Carbon::parse($request->checkin);
            // checkout berisi datetime (tanggal checkout + jam 12:00 otomatis)
            $check_out_dt = Carbon::parse($request->checkout);
            $nights = (int) $check_in_dt->copy()->startOfDay()->diffInDays($check_out_dt->copy()->startOfDay());
            if ($nights < 1) $nights = 1;
            $total_harga  = $room->harga_dasar * $nights;
        }

        // Cek Ketersediaan Kamar sebelum simpan
        if (!$room->isAvailable($check_in_dt, $check_out_dt)) {
            return redirect()->route('rooms.show', $room->id)
                ->with('error', 'Kamar tidak tersedia pada jam/tanggal tersebut. Silakan pilih waktu yang berbeda.');
        }

        $guest = Guest::firstOrCreate(
            ['kontak' => $request->kontak],
            ['nama' => $request->nama, 'alamat' => $request->alamat]
        );

        $reservation = Reservation::create([

            'guest_id' => $guest->id,
            'room_id' => $room->id,
            'tipe_reservasi' => $request->tipe_reservasi,
            'check_in' => $check_in_dt,
            'check_out' => $check_out_dt,
            'status' => 'Pending',
            'total_harga' => $total_harga,
            'sumber_booking' => 'Website'
        ]);

        if ($request->metode_pembayaran == 'Bayar di Tempat') {
            Payment::create([
                'reservation_id' => $reservation->id,
                'jumlah' => 0,
                'metode' => 'Bayar di Tempat (Tunai saat Datang)',
                'status' => 'Menunggu Verifikasi',
                'tanggal' => Carbon::today(),
                'bukti_bayar' => 'bayar-di-tempat.jpg'
            ]);

            return redirect()->route('booking.success')->with('cod_success', true)->with('reservation_id', $reservation->id);
        }

        return redirect()->route('payment', $reservation->id);
    }

    /**
     * Menampilkan halaman instruksi pembayaran dan formulir unggah bukti transfer.
     */
    public function payment($reservation_id)
    {
        $reservation = Reservation::with(['room', 'guest', 'payments'])->findOrFail($reservation_id);
        return view('reservations.payment', compact('reservation'));
    }

    /**
     * Memproses unggahan bukti transfer dari tamu.
     * Tamu dapat membayar Lunas atau sekadar DP (minimal Rp 50.000).
     * Status pembayaran diset 'Menunggu Verifikasi' agar dicek oleh Admin.
     */
    public function uploadPayment(Request $request, $reservation_id)
    {
        $request->validate([
            'bukti_bayar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'jumlah_transfer' => 'required|numeric|min:50000',
        ]);

        $reservation = Reservation::findOrFail($reservation_id);
        
        $path = $request->file('bukti_bayar')->store('public/payments');
        
        Payment::create([
            'reservation_id' => $reservation->id,
            'jumlah' => $request->jumlah_transfer,
            'metode' => 'Transfer Manual',
            'status' => 'Menunggu Verifikasi',
            'tanggal' => Carbon::today(),
            'bukti_bayar' => basename($path)
        ]);

        return redirect()->route('booking.success');
    }

    public function success()
    {
        return view('reservations.success');
    }
}
