@extends('layouts.admin')

@section('title', 'Detail & Laporan Penghasilan Kamar')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.rooms.index') }}" class="text-[#2170e4] hover:underline font-bold text-sm flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">arrow_back</span>
                    <span>Daftar Kamar</span>
                </a>
                <span class="text-gray-400">/</span>
                <span class="text-xs text-gray-500 font-mono-custom font-semibold">ID Kamar #{{ $room->id }}</span>
            </div>
            <h3 class="font-display text-[24px] md:text-[28px] font-bold text-[#191c1e] mt-1">
                {{ $room->nama }}
            </h3>
        </div>

        <a href="{{ route('admin.rooms.edit', $room->id) }}" class="flex items-center gap-2 px-4 py-2 bg-white border border-[#c6c6cd] hover:bg-gray-50 text-gray-800 font-bold rounded-xl shadow-sm text-xs transition">
            <span class="material-symbols-outlined text-sm">edit</span>
            <span>Edit rincian Kamar</span>
        </a>
    </div>

    <!-- Ringkasan Laporan Penghasilan Kamar (Room Income Summary Cards) -->
    @php
        $now = \Carbon\Carbon::now();
        $validReservations = $reservations->where('status', '!=', 'Cancelled');
        $totalPenghasilanSemua = $validReservations->sum('total_harga');
        $penghasilanBulanIni = $validReservations->filter(function($r) use ($now) {
            return \Carbon\Carbon::parse($r->check_in)->isCurrentMonth();
        })->sum('total_harga');
        $totalKaliTerjual = $validReservations->count();
        $isOccupiedNow = $room->isOccupiedNow();
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Pendapatan Bulan Ini -->
        <div class="bg-white border border-[#c6c6cd] rounded-xl p-4 relative overflow-hidden shadow-sm">
            <div class="status-bar bg-[#2170e4]"></div>
            <div class="flex justify-between items-center mb-1">
                <span class="text-xs font-mono-custom text-gray-500">Pendapatan Bulan Ini</span>
                <span class="material-symbols-outlined text-[#2170e4] bg-blue-50 p-1.5 rounded-lg text-[20px]">payments</span>
            </div>
            <h3 class="font-display text-2xl font-bold text-[#191c1e] mt-1">
                Rp {{ number_format($penghasilanBulanIni, 0, ',', '.') }}
            </h3>
            <p class="text-xs text-gray-500 mt-1 font-mono-custom">Bulan {{ $now->translatedFormat('F Y') }}</p>
        </div>

        <!-- Total Pendapatan Akumulasi (All Time) -->
        <div class="bg-white border border-[#c6c6cd] rounded-xl p-4 relative overflow-hidden shadow-sm">
            <div class="status-bar bg-green-500"></div>
            <div class="flex justify-between items-center mb-1">
                <span class="text-xs font-mono-custom text-gray-500">Total Penghasilan (All-Time)</span>
                <span class="material-symbols-outlined text-green-600 bg-green-50 p-1.5 rounded-lg text-[20px]">account_balance_wallet</span>
            </div>
            <h3 class="font-display text-2xl font-bold text-[#191c1e] mt-1">
                Rp {{ number_format($totalPenghasilanSemua, 0, ',', '.') }}
            </h3>
            <p class="text-xs text-gray-500 mt-1 font-mono-custom">Akumulasi penjualan</p>
        </div>

        <!-- Total Kali Dipesan / Terjual -->
        <div class="bg-white border border-[#c6c6cd] rounded-xl p-4 relative overflow-hidden shadow-sm">
            <div class="status-bar bg-amber-500"></div>
            <div class="flex justify-between items-center mb-1">
                <span class="text-xs font-mono-custom text-gray-500">Total Terjual</span>
                <span class="material-symbols-outlined text-amber-600 bg-amber-50 p-1.5 rounded-lg text-[20px]">confirmation_number</span>
            </div>
            <h3 class="font-display text-2xl font-bold text-[#191c1e] mt-1">
                {{ $totalKaliTerjual }} Kali
            </h3>
            <p class="text-xs text-gray-500 mt-1 font-mono-custom">Reservasi sukses</p>
        </div>

        <!-- Status Real-Time Hari Ini -->
        <div class="bg-white border border-[#c6c6cd] rounded-xl p-4 relative overflow-hidden shadow-sm">
            <div class="status-bar {{ $isOccupiedNow ? 'bg-blue-600' : 'bg-green-500' }}"></div>
            <div class="flex justify-between items-center mb-1">
                <span class="text-xs font-mono-custom text-gray-500">Status Hari Ini</span>
                <span class="material-symbols-outlined {{ $isOccupiedNow ? 'text-blue-600 bg-blue-50' : 'text-green-600 bg-green-50' }} p-1.5 rounded-lg text-[20px]">door_open</span>
            </div>
            <h3 class="font-display text-lg font-bold text-[#191c1e] mt-1">
                {{ $isOccupiedNow ? 'Terisi (Tidak Ready)' : 'Tersedia (Ready)' }}
            </h3>
            <p class="text-xs text-gray-500 mt-1 font-mono-custom">Real-time check-out 12:00</p>
        </div>
    </div>

    <!-- Info Detail Kamar & Galeri Foto -->
    <div class="bg-white border border-[#c6c6cd] rounded-2xl shadow-sm overflow-hidden p-6">
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Galeri Foto Kamar -->
            <div class="w-full md:w-1/3 space-y-3">
                <div class="aspect-video w-full rounded-xl overflow-hidden bg-gray-100 border border-gray-200 shadow-sm">
                    <img src="{{ $room->foto }}" alt="{{ $room->nama }}" class="w-full h-full object-cover">
                </div>
                <div class="grid grid-cols-4 gap-2">
                    @if($room->foto2) <img src="{{ $room->foto2 }}" class="aspect-video w-full object-cover rounded-lg border"> @endif
                    @if($room->foto3) <img src="{{ $room->foto3 }}" class="aspect-video w-full object-cover rounded-lg border"> @endif
                    @if($room->foto4) <img src="{{ $room->foto4 }}" class="aspect-video w-full object-cover rounded-lg border"> @endif
                    @if($room->foto5) <img src="{{ $room->foto5 }}" class="aspect-video w-full object-cover rounded-lg border"> @endif
                </div>
            </div>

            <!-- Informasi Spesifikasi -->
            <div class="w-full md:w-2/3 space-y-3">
                <div class="flex justify-between items-start">
                    <div>
                        <h4 class="font-display text-xl font-bold text-[#191c1e]">{{ $room->nama }}</h4>
                        <span class="inline-block px-3 py-1 bg-blue-50 text-[#2170e4] rounded-lg text-xs font-bold mt-1">Tipe: {{ $room->tipe }}</span>
                    </div>
                    <div class="text-right">
                        <span class="text-xs text-gray-500 block">Harga Dasar (Per Malam)</span>
                        <span class="font-display text-2xl font-bold text-[#2170e4]">Rp {{ number_format($room->harga_dasar, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 border-t pt-3 text-xs">
                    <div>
                        <span class="text-gray-500 block">Kapasitas Tamu</span>
                        <span class="font-bold text-gray-900">{{ $room->kapasitas }} Dewasa</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block">Harga Transit (6 Jam)</span>
                        <span class="font-bold text-gray-900">{{ $room->harga_transit ? 'Rp ' . number_format($room->harga_transit, 0, ',', '.') : 'Tidak Tersedia' }}</span>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 text-xs text-gray-700 space-y-1">
                    <strong class="block text-gray-900 font-bold uppercase tracking-wider text-[11px]">Fasilitas Kamar:</strong>
                    <p class="leading-relaxed">{{ $room->fasilitas ?: 'Tidak ada rincian fasilitas.' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Riwayat Transaksi & Jadwal Booking Kamar Ini -->
    <div class="bg-white border border-[#c6c6cd] rounded-2xl shadow-sm overflow-hidden">
        <div class="p-4 border-b border-[#c6c6cd] flex justify-between items-center bg-gray-50/50">
            <h4 class="font-display text-base font-bold text-[#191c1e]">Riwayat Pemesanan & Income Kamar Ini</h4>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100/70 border-b border-[#c6c6cd] text-xs font-mono-custom text-gray-600 uppercase">
                        <th class="py-3.5 px-4">Nama Tamu</th>
                        <th class="py-3.5 px-4">Check-In</th>
                        <th class="py-3.5 px-4">Check-Out</th>
                        <th class="py-3.5 px-4">Pendapatan Dihasilkan</th>
                        <th class="py-3.5 px-4">Status Booking</th>
                        <th class="py-3.5 px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($reservations as $res)
                    <tr class="hover:bg-blue-50/30 transition-colors">
                        <td class="py-3.5 px-4 font-bold text-[#191c1e]">
                            {{ $res->guest->nama }}
                            <div class="text-xs font-normal text-gray-400 font-mono-custom">{{ $res->guest->kontak }}</div>
                        </td>
                        <td class="py-3.5 px-4 font-mono-custom text-xs text-gray-600">
                            {{ \Carbon\Carbon::parse($res->check_in)->format('d M Y, H:i') }}
                        </td>
                        <td class="py-3.5 px-4 font-mono-custom text-xs text-gray-600">
                            {{ \Carbon\Carbon::parse($res->check_out)->format('d M Y, H:i') }}
                        </td>
                        <td class="py-3.5 px-4 font-bold text-green-600 font-mono-custom">
                            Rp {{ number_format($res->total_harga, 0, ',', '.') }}
                        </td>
                        <td class="py-3.5 px-4">
                            @if($res->status == 'Confirmed')
                                <span class="px-2.5 py-1 rounded-full bg-green-100 text-green-800 text-xs font-bold">Confirmed</span>
                            @elseif($res->status == 'Checked-in')
                                <span class="px-2.5 py-1 rounded-full bg-blue-100 text-blue-800 text-xs font-bold">Checked-in</span>
                            @elseif($res->status == 'Checked-out')
                                <span class="px-2.5 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-bold">Checked-out</span>
                            @elseif($res->status == 'Cancelled')
                                <span class="px-2.5 py-1 rounded-full bg-red-100 text-red-800 text-xs font-bold">Ditolak</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full bg-amber-100 text-amber-800 text-xs font-bold">{{ $res->status }}</span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4">
                            <a href="{{ route('admin.reservations.show', $res->id) }}" class="inline-flex items-center gap-1 text-xs text-[#2170e4] font-bold hover:underline bg-blue-50 px-2.5 py-1.5 rounded-lg border border-blue-100">
                                <span>Detail</span>
                                <span class="material-symbols-outlined text-xs">arrow_forward</span>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-gray-500">Belum ada riwayat pemesanan untuk kamar ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
