@extends('layouts.app')

@section('content')
<div class="bg-slate-50 py-20">
    <div class="max-w-xl mx-auto px-4 text-center">
        <div class="bg-white p-8 shadow-sm rounded-2xl border border-slate-200">
            <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-5xl">check_circle</span>
            </div>
            
            <h2 class="text-3xl font-extrabold text-slate-900 mb-2">Reservasi Berhasil!</h2>

            @if(session('cod_success'))
                <p class="text-slate-600 text-sm mb-6">Terima kasih. Formulir reservasi Anda telah diterima oleh Admin Teras Abah Homestay.</p>

                <div class="bg-green-50 border border-green-200 text-green-800 p-5 rounded-2xl mb-6 text-left space-y-2 text-xs">
                    <div class="flex items-center gap-2 font-bold text-sm text-green-900 border-b border-green-200 pb-2">
                        <span class="material-symbols-outlined text-lg">payments</span>
                        <span>Metode: Bayar di Tempat (Tunai saat Datang)</span>
                    </div>
                    <p class="pt-1 leading-relaxed">
                        Anda <strong>tidak perlu mengunggah bukti transfer</strong>. Silakan datang sesuai tanggal check-in. Pembayaran dapat dilunasi secara tunai/cash saat Anda Tiba di Teras Abah Homestay.
                    </p>
                    @if(session('reservation_id'))
                    <div class="pt-2 font-mono-custom text-xs font-bold text-green-900">
                        Kode Booking: #{{ str_pad(session('reservation_id'), 5, '0', STR_PAD_LEFT) }}
                    </div>
                    @endif
                </div>
            @else
                <p class="text-slate-600 text-sm mb-6">Bukti pembayaran Anda telah berhasil diunggah.</p>
                
                <div class="bg-blue-50 border border-blue-200 text-blue-800 p-5 rounded-2xl mb-6 text-left text-xs leading-relaxed">
                    Reservasi Anda sedang dalam status <strong>Menunggu Verifikasi Pembayaran</strong>. Admin kami akan memeriksa bukti transfer Anda.
                </div>
            @endif

            <div class="space-y-3">
                <a href="https://wa.me/6282123369949?text=Halo%20Admin%20Teras%20Abah,%20saya%20sudah%20membuat%20reservasi." target="_blank" class="inline-flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white font-bold py-3.5 px-6 rounded-xl w-full text-sm shadow">
                    <span class="material-symbols-outlined text-lg">chat</span>
                    <span>Konfirmasi via WhatsApp Admin</span>
                </a>
                
                <a href="{{ route('home') }}" class="inline-block text-slate-500 hover:text-slate-800 font-semibold text-xs transition pt-2">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
