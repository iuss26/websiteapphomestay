@extends('layouts.app')

@section('content')
<div class="bg-gray-50 py-10">
    <div class="max-w-3xl mx-auto px-4">
        <div class="bg-white p-8 shadow-lg rounded-xl text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Selesaikan Pembayaran Anda</h2>
            <p class="text-gray-600 mb-8">Booking ID: #{{ str_pad($reservation->id, 5, '0', STR_PAD_LEFT) }}</p>

            <div class="bg-blue-50 border border-blue-200 p-6 rounded-lg mb-8 inline-block text-left w-full max-w-md">
                <p class="text-sm text-gray-500 mb-1">Total Tagihan:</p>
                <p class="text-3xl font-bold text-red-600 mb-4">Rp {{ number_format($reservation->total_harga, 0, ',', '.') }}</p>
                
                <div class="mb-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                <h3 class="font-bold text-blue-800 mb-2">Informasi Pembayaran:</h3>
                <p class="mb-1"><strong>Bank:</strong> BCA</p>
                <p class="mb-1"><strong>No. Rekening:</strong> 6510518967</p>
                <p class="mb-4"><strong>Atas Nama:</strong> Teras Abah Homestay / Pengelola</p>

                <h3 class="font-bold text-blue-800 mb-2 border-t border-blue-200 pt-4">Atau Bayar via QRIS:</h3>
                <div class="bg-white p-4 rounded shadow-sm inline-block mb-2">
                    <img src="{{ asset('images/qris.jpg') }}" alt="QRIS Teras Abah Homestay" class="max-w-[250px] mx-auto rounded border border-gray-200">
                </div>
                <p class="text-sm text-gray-600 mt-2">Scan kode QR di atas menggunakan aplikasi m-banking atau e-wallet (GoPay, OVO, Dana, ShopeePay, dll).</p>
            </div>
            </div>

            <div class="border-t pt-8">
                <h3 class="text-xl font-bold mb-2">Konfirmasi Pembayaran</h3>
                <p class="text-gray-600 mb-2">Sudah melakukan transfer? Silakan unggah bukti pembayaran Anda di bawah ini agar kami dapat memproses reservasi Anda.</p>
                <p class="text-xs text-blue-600 font-semibold mb-6">
                    Butuh bantuan? <a href="https://wa.me/6282123369949?text=Halo%20Admin,%20saya%20butuh%20bantuan%20pembayaran%20booking%20%23{{ str_pad($reservation->id, 5, '0', STR_PAD_LEFT) }}" target="_blank" class="underline hover:text-blue-800">Hubungi Admin via WhatsApp (0821-2336-9949)</a>
                </p>
                
                <form action="{{ route('payment.upload', $reservation->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Jumlah Transfer (Rp)</label>
                        <p class="text-xs text-gray-500 mb-2">Anda dapat membayar Lunas atau membayar DP sebagai tanda jadi (Minimal Rp 50.000). Sisa tagihan dapat dilunasi saat kedatangan.</p>
                        <input type="number" name="jumlah_transfer" min="50000" value="{{ $reservation->total_harga }}" class="w-full border rounded p-3 focus:outline-none focus:border-blue-500" required>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Upload Bukti Transfer</label>
                        <input type="file" name="bukti_bayar" accept="image/*" class="w-full border rounded p-3 bg-gray-50" required>
                    </div>
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded text-lg transition">
                        Kirim Bukti Pembayaran
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
