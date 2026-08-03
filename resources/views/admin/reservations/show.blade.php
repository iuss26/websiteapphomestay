@extends('layouts.admin')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.reservations.index') }}" class="text-blue-600 hover:underline">&larr; Kembali ke Daftar Reservasi</a>
</div>

<h2 class="text-2xl font-bold text-gray-800 mb-6">Detail Reservasi #{{ str_pad($reservation->id, 5, '0', STR_PAD_LEFT) }}</h2>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Info Reservasi -->
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-bold border-b pb-2 mb-4">Informasi Reservasi</h3>
        <div class="overflow-x-auto"><table class="w-full text-sm">
            <tr><td class="py-2 text-gray-600 w-1/3">Status Booking</td><td class="py-2 font-bold">{{ $reservation->status }}</td></tr>
            <tr><td class="py-2 text-gray-600">Nama Tamu</td><td class="py-2">{{ $reservation->guest->nama }}</td></tr>
            <tr><td class="py-2 text-gray-600">Kontak</td><td class="py-2">{{ $reservation->guest->kontak }}</td></tr>
            <tr><td class="py-2 text-gray-600">Kamar</td><td class="py-2">{{ $reservation->room->nama }} ({{ $reservation->room->tipe }})</td></tr>
            <tr><td class="py-2 text-gray-600">Check-in</td><td class="py-2">{{ \Carbon\Carbon::parse($reservation->check_in)->format('d M Y') }}</td></tr>
            <tr><td class="py-2 text-gray-600">Check-out</td><td class="py-2">{{ \Carbon\Carbon::parse($reservation->check_out)->format('d M Y') }}</td></tr>
            <tr><td class="py-2 text-gray-600">Total Harga</td><td class="py-2 font-bold text-red-600">Rp {{ number_format($reservation->total_harga, 0, ',', '.') }}</td></tr>
            
            @php 
                $total_dibayar = $reservation->payments->where('status', 'Terverifikasi')->sum('jumlah');
                if($total_dibayar == 0 && $reservation->payments->where('status', 'Menunggu Verifikasi')->count() > 0) {
                    $total_dibayar = $reservation->payments->where('status', 'Menunggu Verifikasi')->sum('jumlah');
                }
                $sisa_tagihan = $reservation->total_harga - $total_dibayar;
            @endphp
            
            <tr><td class="py-2 text-gray-600">Total Dibayar</td><td class="py-2 font-bold text-green-600">Rp {{ number_format($total_dibayar, 0, ',', '.') }}</td></tr>
            <tr><td class="py-2 text-gray-600">Sisa Tagihan</td><td class="py-2 font-bold {{ $sisa_tagihan > 0 ? 'text-orange-500' : 'text-gray-800' }}">Rp {{ number_format($sisa_tagihan, 0, ',', '.') }}</td></tr>
        </table></div>
    </div>

    <!-- Info Pembayaran -->
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-bold border-b pb-2 mb-4">Verifikasi Pembayaran</h3>
        @php $payment = $reservation->payments->first(); @endphp
        
        @if($payment)
            <div class="overflow-x-auto"><table class="w-full text-sm mb-4">
                <tr><td class="py-2 text-gray-600 w-1/3">Status Bayar</td><td class="py-2 font-bold">{{ $payment->status }}</td></tr>
                <tr><td class="py-2 text-gray-600">Metode</td><td class="py-2">{{ $payment->metode }}</td></tr>
            </table></div>

            @if($payment->status == 'Menunggu Verifikasi')
                <div class="border p-2 bg-gray-50 mb-4 rounded">
                    <p class="font-bold mb-2">Bukti Transfer:</p>
                    <img src="{{ Storage::url('payments/' . $payment->bukti_bayar) }}" class="w-full rounded mb-2">
                    <p class="text-sm font-bold text-center text-blue-800">Transfer sejumlah: Rp {{ number_format($payment->jumlah, 0, ',', '.') }}</p>
                </div>

                <div class="grid grid-cols-2 gap-3 mt-3">
                    <form action="{{ route('admin.reservations.verify', $reservation->id) }}" method="POST" onsubmit="return confirm('Apakah bukti transfer valid dan dana sudah masuk?');">
                        @csrf
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-3 rounded-xl text-xs flex items-center justify-center gap-1 shadow">
                            <span class="material-symbols-outlined text-sm">check_circle</span>
                            <span>Verifikasi Bayar</span>
                        </button>
                    </form>

                    <form action="{{ route('admin.reservations.reject', $reservation->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menolak pengajuan reservasi ini?');">
                        @csrf
                        <button type="submit" class="w-full bg-amber-600 hover:bg-amber-700 text-white font-bold py-2.5 px-3 rounded-xl text-xs flex items-center justify-center gap-1 shadow">
                            <span class="material-symbols-outlined text-sm">cancel</span>
                            <span>Tolak Reservasi</span>
                        </button>
                    </form>
                </div>
            @elseif($payment->status == 'Terverifikasi')
                <div class="bg-green-100 text-green-800 p-4 rounded-xl text-center font-bold text-sm mb-3">
                    Pembayaran sebesar Rp {{ number_format($payment->jumlah, 0, ',', '.') }} telah diverifikasi.
                </div>
            @else
                <div class="bg-amber-100 text-amber-800 p-4 rounded-xl text-center text-sm mb-3">
                    Status Pembayaran: <strong>{{ $payment->status }}</strong>
                </div>
            @endif
        @else
            <p class="text-sm text-gray-500 mb-4">Data pembayaran belum tercatat.</p>
        @endif

        @if(!in_array($reservation->status, ['Checked-out', 'Cancelled']))
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mt-4">
            <p class="text-xs text-slate-600 mb-3">Tamu sudah selesai menginap atau meninggalkan lokasi?</p>
            <form action="{{ route('admin.reservations.checkout_guest', $reservation->id) }}" method="POST" onsubmit="return confirm('Proses check-out tamu ini sekarang? Kamar akan langsung menjadi Tersedia (Ready).');">
                @csrf
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded-xl text-xs flex items-center justify-center gap-2 shadow">
                    <span class="material-symbols-outlined text-sm">output</span>
                    <span>Proses Check-out Tamu Sekarang</span>
                </button>
            </form>
        </div>
        @endif

        <div class="border-t pt-4 mt-4 flex justify-between items-center">
            <span class="text-xs text-gray-500">Tindakan Bahaya:</span>
            <form action="{{ route('admin.reservations.destroy', $reservation->id) }}" method="POST" onsubmit="return confirm('Hapus permanen reservasi ini? Data tidak dapat dikembalikan.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 font-bold rounded-xl text-xs flex items-center gap-1 border border-red-200 transition">
                    <span class="material-symbols-outlined text-sm">delete</span>
                    <span>Hapus Permanen Reservasi</span>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

