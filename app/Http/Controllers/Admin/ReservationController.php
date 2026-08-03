<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Payment;
use App\Models\Room;
use App\Models\Guest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Menampilkan daftar semua reservasi yang masuk, baik yang Lunas maupun DP.
     */
    public function index()
    {
        $now = \Carbon\Carbon::now();

        $reservations = Reservation::with(['guest', 'room', 'payments'])
            ->get()
            ->sortBy(function ($r) use ($now) {
                // Prioritas 0: Reservasi Aktif / Mendatang / Pending (Di ATAS)
                // Prioritas 1: Reservasi Sudah Selesai (Checked-out / Cancelled) (Di BAWAH)
                $isFinished = in_array($r->status, ['Checked-out', 'Cancelled']);
                $priority = $isFinished ? 1 : 0;

                // Untuk grup aktif/mendatang, urutkan berdasarkan tanggal check_in terdekat
                $checkInTimestamp = \Carbon\Carbon::parse($r->check_in)->timestamp;

                return [$priority, $checkInTimestamp];
            })
            ->values();

        return view('admin.reservations.index', compact('reservations'));
    }

    public function create()
    {
        $rooms = Room::all();
        return view('admin.reservations.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kontak' => 'required|string|max:20',
            'alamat' => 'nullable|string',
            'room_id' => 'required|exists:rooms,id',
            'tipe_reservasi' => 'required|in:Menginap,Transit',
            'check_in' => 'required|date',
            'status_pembayaran' => 'required|in:Lunas,DP,Belum Bayar',
        ]);

        if ($request->tipe_reservasi == 'Menginap') {
            $request->validate([
                'check_out' => 'required|date|after:check_in',
            ]);
        }

        $room = Room::findOrFail($request->room_id);

        $guest = Guest::firstOrCreate(
            ['kontak' => $request->kontak],
            ['nama' => $request->nama, 'alamat' => $request->alamat ?? 'Tidak diisi']
        );

        if ($request->tipe_reservasi == 'Transit') {
            $check_in_dt = Carbon::parse($request->check_in);
            $check_out_dt = $check_in_dt->copy()->addHours(6);
            $total_harga = $room->harga_transit ?? $room->harga_dasar;
        } else {
            $check_in_dt = Carbon::parse($request->check_in)->startOfDay();
            $check_out_dt = Carbon::parse($request->check_out)->startOfDay();
            $nights = $check_in_dt->diffInDays($check_out_dt);
            if ($nights < 1) $nights = 1;
            $total_harga = $room->harga_dasar * $nights;
        }

        if ($request->filled('total_harga_custom') && $request->total_harga_custom > 0) {
            $total_harga = $request->total_harga_custom;
        }

        // Cek ketersediaan kamar
        if (!$room->isAvailable($check_in_dt, $check_out_dt)) {
            return back()->withInput()->with('error', 'Kamar tidak tersedia pada tanggal/waktu tersebut karena sudah terisi reservasi lain.');
        }

        $reservation = Reservation::create([

            'guest_id' => $guest->id,
            'room_id' => $room->id,
            'tipe_reservasi' => $request->tipe_reservasi,
            'check_in' => $check_in_dt,
            'check_out' => $check_out_dt,
            'status' => 'Confirmed', // Langsung confirmed karena admin yang input
            'total_harga' => $total_harga,
            'sumber_booking' => 'Walk-in / Admin',
        ]);

        if ($request->status_pembayaran != 'Belum Bayar') {
            $jumlah = $request->status_pembayaran == 'Lunas' ? $total_harga : ($request->jumlah_dp ?? 50000);
            Payment::create([
                'reservation_id' => $reservation->id,
                'jumlah' => $jumlah,
                'metode' => 'Tunai / Manual',
                'status' => 'Terverifikasi',
                'tanggal' => Carbon::today(),
                'bukti_bayar' => 'manual-admin.jpg'
            ]);
        }

        return redirect()->route('admin.reservations.index')->with('success', 'Reservasi manual berhasil dibuat!');
    }

    /**
     * Menampilkan detail spesifik dari sebuah reservasi (bukti bayar, data tamu, dll).
     */
    public function show($id)
    {
        $reservation = Reservation::with(['guest', 'room', 'payments'])->findOrFail($id);
        return view('admin.reservations.show', compact('reservation'));
    }

    /**
     * Memproses tombol "Verifikasi Pembayaran" dari halaman detail reservasi.
     * Mengubah status tabel 'payments' menjadi 'Terverifikasi'
     * dan status tabel 'reservations' menjadi 'Confirmed'.
     */
    public function verifyPayment(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        
        $payment = $reservation->payments()->first();
        if ($payment) {
            $payment->update(['status' => 'Terverifikasi']);
        }

        $reservation->update(['status' => 'Confirmed']);

        return redirect()->route('admin.reservations.show', $id)->with('success', 'Pembayaran berhasil diverifikasi.');
    }

    /**
     * Menolak pengajuan reservasi atau bukti pembayaran tamu.
     */
    public function reject(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        
        $payment = $reservation->payments()->first();
        if ($payment) {
            $payment->update(['status' => 'Ditolak']);
        }

        $reservation->update(['status' => 'Cancelled']);

        return redirect()->route('admin.reservations.show', $id)->with('success', 'Pengajuan reservasi telah ditolak.');
    }

    /**
     * Memproses check-out tamu secara manual.
     */
    public function checkoutGuest(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->update(['status' => 'Checked-out']);

        return redirect()->back()->with('success', 'Tamu telah berhasil di-check out. Kamar kini kembali Tersedia (Ready).');
    }

    /**
     * Menghapus permanen data reservasi.
     */
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return redirect()->route('admin.reservations.index')->with('success', 'Data reservasi berhasil dihapus.');
    }
}
