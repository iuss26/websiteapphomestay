@extends('layouts.app')

@section('content')
<!-- Hero Section (Clean Ocean Blue) -->
<div class="relative bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-950 text-white py-24 sm:py-32 overflow-hidden">
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/hero-bg.jpg') }}" alt="Teras Abah Homestay" class="w-full h-full object-cover opacity-25">
    </div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-4 text-center">
        <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-blue-500/20 backdrop-blur-md text-blue-200 text-xs font-bold uppercase tracking-wider mb-6 border border-blue-400/30">
            <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
            Dekat Pantai Anyer (Hanya 5 Menit)
        </span>
        <h1 class="text-4xl sm:text-6xl font-extrabold mb-4 leading-tight tracking-tight text-white">
            Nikmati Liburan Nyaman di Teras Abah Homestay
        </h1>
        <p class="text-lg sm:text-xl mb-12 text-blue-100 max-w-2xl mx-auto font-normal leading-relaxed">
            Penginapan bersih, tenang, dan harga terjangkau untuk keluarga dan rombongan di Pantai Anyer.
        </p>
        
        <!-- Search Box (Clean White Card) -->
        <div class="bg-white rounded-2xl shadow-2xl p-6 sm:p-8 max-w-4xl mx-auto text-slate-800 border border-slate-100">
            <form action="{{ route('rooms.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-4 gap-4 items-end">
                <div class="text-left">
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Tanggal Check-In</label>
                    <input type="text" id="checkin-date" name="checkin" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3.5 text-sm font-semibold focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none" placeholder="Pilih Check-in">
                </div>

                <div class="text-left">
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Tanggal Check-Out</label>
                    <input type="text" id="checkout-date" name="checkout" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3.5 text-sm font-semibold focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none" placeholder="Pilih Check-out">
                </div>

                <div class="text-left">
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Jumlah Tamu</label>
                    <select name="guests" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3.5 text-sm font-semibold focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none">
                        <option value="1">1 Orang Dewasa</option>
                        <option value="2">2 Orang Dewasa</option>
                        <option value="3">3 Orang Dewasa</option>
                        <option value="4">4+ Orang / Rombongan</option>
                    </select>
                </div>

                <div>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-6 rounded-xl text-sm shadow-lg transition-transform active:scale-95 flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-xl">search</span>
                        <span>Cari Kamar</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- About Us Section -->
<div id="about" class="py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto text-center space-y-6">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900">
                Teras Abah Homestay Anyer
            </h2>
            <div class="w-16 h-1 bg-blue-600 mx-auto rounded-full"></div>
            
            <p class="text-base sm:text-lg text-slate-600 leading-relaxed">
                Teras Abah Homestay adalah pilihan tempat menginap tepat di kawasan Pantai Anyer. Hanya 5 menit jalan menuju pantai utama, kamar bersih, AC sejuk, dan suasana privat yang tenang untuk menginap bersama keluarga.
            </p>
        </div>
    </div>
</div>

<!-- Feature Cards -->
<div class="py-16 bg-white border-y border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-slate-50 p-8 rounded-2xl border border-slate-200 hover:border-blue-500 transition-colors group">
                <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined text-3xl">waves</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Dekat Pantai Anyer</h3>
                <p class="text-sm text-slate-600 leading-relaxed">Kurang dari 5 menit untuk menikmati pantai dan matahari terbenam.</p>
            </div>

            <div class="bg-slate-50 p-8 rounded-2xl border border-slate-200 hover:border-blue-500 transition-colors group">
                <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined text-3xl">king_bed</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Fasilitas Lengkap</h3>
                <p class="text-sm text-slate-600 leading-relaxed">Kamar mandi bersih, AC sejuk, TV, dan kebersihan yang terjaga.</p>
            </div>

            <div class="bg-slate-50 p-8 rounded-2xl border border-slate-200 hover:border-blue-500 transition-colors group">
                <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined text-3xl">payments</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Sewa Harian & Transit</h3>
                <p class="text-sm text-slate-600 leading-relaxed">Tersedia sewa harian (per malam) atau transit 6 jam dengan harga transparan.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    flatpickr("#checkin-date", {
        minDate: "today",
        dateFormat: "Y-m-d",
        onChange: function(selectedDates, dateStr, instance) {
            checkoutPicker.set('minDate', dateStr);
        }
    });
    const checkoutPicker = flatpickr("#checkout-date", {
        minDate: "today",
        dateFormat: "Y-m-d",
    });
</script>
@endpush
