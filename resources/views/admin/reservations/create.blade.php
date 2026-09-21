@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-800">Buat Reservasi Manual</h2>
    <a href="{{ route('admin.reservations.index') }}" class="text-blue-600 hover:underline">&larr; Kembali ke Daftar Reservasi</a>
</div>

@if(session('error'))
    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative max-w-4xl shadow-sm">
        <strong class="font-bold">Gagal: </strong>
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
@endif

<div class="bg-white shadow rounded-lg overflow-hidden max-w-4xl">

    <form action="{{ route('admin.reservations.store') }}" method="POST" class="p-6">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Data Tamu -->
            <div class="space-y-4">
                <h3 class="text-lg font-bold text-gray-700 border-b pb-2">1. Data Tamu</h3>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap *</label>
                    <input type="text" name="nama" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Contoh: Budi Santoso">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Kontak (WA/HP) *</label>
                    <input type="text" name="kontak" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Contoh: 08123456789">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Asal</label>
                    <textarea name="alamat" rows="2" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Opsional"></textarea>
                </div>
            </div>

            <!-- Detail Reservasi -->
            <div class="space-y-4">
                <h3 class="text-lg font-bold text-gray-700 border-b pb-2">2. Detail Kamar & Waktu</h3>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Kamar *</label>
                    <select name="room_id" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Pilih Kamar --</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}">{{ $room->nama }} (Rp {{ number_format($room->harga_dasar, 0, ',', '.') }})</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Reservasi *</label>
                    <select name="tipe_reservasi" id="tipe_reservasi" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="Menginap">Menginap (Harian)</option>
                        <option value="Transit">Transit (6 Jam)</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal & Jam Check-In *</label>
                    <input type="datetime-local" name="check_in" id="check_in_admin" required
                        value="{{ date('Y-m-d') }}T14:00"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <p class="text-xs text-gray-400 mt-1">Default: 14:00. Untuk Transit, pilih jam mulai sewa.</p>
                </div>

                <div id="checkout_wrapper">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Check-Out *</label>
                    <input type="date" name="check_out" id="check_out" value="{{ date('Y-m-d', strtotime('+1 day')) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <p class="text-xs text-gray-400 mt-1">Jam check-out otomatis 12:00 siang.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga Kesepakatan / Kustom (Rp)</label>
                    <input type="number" name="total_harga_custom" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Kosongkan untuk harga otomatis">
                    <p class="text-xs text-gray-500 mt-1">* Isi jika harga disepakati di bawah/berbeda dari harga standar.</p>
                </div>
            </div>
            
        </div>
        
        <!-- Status Pembayaran -->
        <div class="mt-8 pt-6 border-t border-gray-200">
            <h3 class="text-lg font-bold text-gray-700 mb-4">3. Status Pembayaran</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status Pembayaran Saat Ini *</label>
                    <select name="status_pembayaran" id="status_pembayaran" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="Lunas">Lunas (Bayar Penuh)</option>
                        <option value="DP">Bayar DP (Uang Muka)</option>
                        <option value="Belum Bayar">Belum Bayar sama sekali</option>
                    </select>
                </div>
                <div id="dp_wrapper" style="display: none;">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nominal DP (Rp) *</label>
                    <input type="number" name="jumlah_dp" value="50000" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            <p class="text-sm text-gray-500 mt-2">
                * Memilih <b>Lunas</b> atau <b>DP</b> akan otomatis mencatat uang masuk (Payment) di sistem yang langsung terverifikasi. Reservasi ini akan berstatus <b>Confirmed</b>.
            </p>
        </div>

        <div class="mt-8 flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg transition-transform transform hover:scale-105">
                Simpan & Konfirmasi Reservasi
            </button>
        </div>
    </form>
</div>

<script>
    // Logika menampilkan/menyembunyikan input Check-Out jika tipe = Transit
    document.getElementById('tipe_reservasi').addEventListener('change', function() {
        var co = document.getElementById('checkout_wrapper');
        var coInput = document.getElementById('check_out');
        if(this.value === 'Transit') {
            co.style.display = 'none';
            coInput.removeAttribute('required');
        } else {
            co.style.display = 'block';
            coInput.setAttribute('required', 'required');
        }
    });

    // Logika menampilkan/menyembunyikan input DP
    document.getElementById('status_pembayaran').addEventListener('change', function() {
        var dp = document.getElementById('dp_wrapper');
        if(this.value === 'DP') {
            dp.style.display = 'block';
        } else {
            dp.style.display = 'none';
        }
    });
</script>
@endsection
