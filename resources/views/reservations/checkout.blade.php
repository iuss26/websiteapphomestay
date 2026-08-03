@extends('layouts.app')

@section('content')
<div class="bg-slate-50 py-12">
    <div class="max-w-4xl mx-auto px-4">
        
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-extrabold text-slate-900">Formulir Reservasi Tamu</h2>
            <p class="text-sm text-slate-600 mt-1">Lengkapi data Anda. Data reservasi akan langsung masuk ke Admin Teras Abah Homestay.</p>
        </div>
        
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Form Data Tamu -->
            <div class="w-full md:w-2/3">
                <div class="bg-white p-6 sm:p-8 shadow-sm rounded-2xl border border-slate-200">
                    <div class="flex items-center gap-3 border-b border-slate-200 pb-4 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900">Informasi Data Tamu</h3>
                            <p class="text-xs text-slate-500">Pastikan nomor WhatsApp aktif untuk konfirmasi admin</p>
                        </div>
                    </div>
                    
                    @if(session('error'))
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl text-sm font-semibold">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl text-sm">
                            <ul class="space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    <form action="{{ route('checkout.store', $room->id) }}" method="POST" class="space-y-5">
                        @csrf
                        <input type="hidden" name="tipe_reservasi" value="{{ $tipe_reservasi }}">
                        <input type="hidden" name="checkin" value="{{ $checkin }}">
                        @if($tipe_reservasi == 'Menginap')
                            <input type="hidden" name="checkout" value="{{ $checkout }}">
                        @endif
                        <input type="hidden" name="guests" value="{{ $guests }}">

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Lengkap (Sesuai KTP) *</label>
                            <input type="text" name="nama" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3.5 text-sm font-semibold focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition" placeholder="Contoh: Ahmad Wijaya" required>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">No. Handphone / WhatsApp Active *</label>
                            <input type="text" name="kontak" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3.5 text-sm font-semibold focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition" placeholder="Contoh: 081234567890" required>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kota Asal / Alamat Domisili *</label>
                            <textarea name="alamat" rows="2" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3.5 text-sm font-semibold focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition" placeholder="Contoh: Jakarta Selatan" required></textarea>
                        </div>

                        <!-- Pilihan Metode Pembayaran -->
                        <div class="border-t pt-5 mt-5 space-y-3">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Pilihan Metode Pembayaran *</label>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <!-- Opsi Bayar di Tempat (COD / Cash) -->
                                <label class="relative flex flex-col p-4 rounded-xl border-2 border-slate-200 cursor-pointer hover:border-blue-500 transition group bg-slate-50/50 has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50/50">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center gap-2 font-bold text-slate-900 text-sm">
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                            <span>Bayar di Tempat</span>
                                        </div>
                                        <input type="radio" name="metode_pembayaran" value="Bayar di Tempat" class="w-4 h-4 text-blue-600" checked>
                                    </div>
                                    <span class="text-xs text-slate-500 leading-relaxed">Bayar secara tunai saat Anda Tiba / Check-in di Teras Abah Homestay. (Hanya perlu isi formulir ini).</span>
                                </label>

                                <!-- Opsi Transfer Bank / QRIS -->
                                <label class="relative flex flex-col p-4 rounded-xl border-2 border-slate-200 cursor-pointer hover:border-blue-500 transition group bg-slate-50/50 has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50/50">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center gap-2 font-bold text-slate-900 text-sm">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                            </svg>
                                            <span>Transfer Bank / QRIS</span>
                                        </div>
                                        <input type="radio" name="metode_pembayaran" value="Transfer Bank" class="w-4 h-4 text-blue-600">
                                    </div>
                                    <span class="text-xs text-slate-500 leading-relaxed">Transfer via Bank BCA / QRIS dan upload bukti pembayaran secara online.</span>
                                </label>
                            </div>
                        </div>

                        <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 flex items-start gap-3 text-xs text-blue-800">
                            <svg class="w-5 h-5 text-blue-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            <p>Data reservasi Anda akan <strong>langsung diterima & dicatat otomatis oleh Admin Teras Abah Homestay</strong>.</p>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-6 rounded-xl text-base shadow-lg transition-transform active:scale-95 flex items-center justify-center gap-2">
                            <span>Konfirmasi & Buat Reservasi</span>
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Ringkasan Booking Card -->
            <div class="w-full md:w-1/3">
                <div class="bg-white p-6 shadow-sm rounded-2xl border border-slate-200 sticky top-24 space-y-4">
                    <h3 class="text-base font-bold text-slate-900 border-b pb-3">Ringkasan Kamar Dipesan</h3>
                    
                    <div class="relative rounded-xl overflow-hidden aspect-video bg-slate-100">
                        <img src="{{ $room->foto }}" alt="{{ $room->nama }}" class="w-full h-full object-cover">
                    </div>

                    <div>
                        <h4 class="font-extrabold text-slate-900 text-lg">{{ $room->nama }}</h4>
                        <span class="inline-block px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 text-xs font-bold mt-1">{{ $room->tipe }}</span>
                    </div>
                    
                    <div class="space-y-2 text-xs border-t pt-3 font-medium">
                        <div class="flex justify-between text-slate-600">
                            <span>Check-in</span>
                            <span class="font-bold text-slate-900">{{ \Carbon\Carbon::parse($checkin)->format($tipe_reservasi == 'Transit' ? 'd M Y, H:i' : 'd M Y') }}</span>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <span>Check-out</span>
                            <span class="font-bold text-slate-900">{{ \Carbon\Carbon::parse($checkout)->format($tipe_reservasi == 'Transit' ? 'd M Y, H:i' : 'd M Y') }}</span>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <span>Durasi</span>
                            <span class="font-bold text-blue-600">{{ $durasi_teks }}</span>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <span>Jumlah Tamu</span>
                            <span class="font-bold text-slate-900">{{ $guests }} Orang Dewasa</span>
                        </div>
                    </div>
                    
                    <div class="border-t pt-4">
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-slate-700 text-xs">Total Pembayaran</span>
                            <span class="font-extrabold text-xl text-red-600">Rp {{ number_format($total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
