@extends('layouts.admin')

@section('title', 'Daftar Reservasi (Reservations)')

@section('content')
<div class="space-y-6">

    <!-- Page Header & Main FAB -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h3 class="font-display text-[24px] md:text-[28px] font-bold text-[#191c1e]">
                Reservasi & Pemesanan Tamu
            </h3>
            <p class="text-[14px] text-[#45464d] mt-1">
                Kelola jadwal menginap, status verifikasi pembayaran, dan data reservasi manual.
            </p>
        </div>

        <a href="{{ route('admin.reservations.create') }}" class="flex items-center gap-2 px-5 py-2.5 bg-[#2170e4] hover:bg-[#0058be] text-white font-bold rounded-xl shadow-md transition-transform active:scale-95 text-sm">
            <span class="material-symbols-outlined text-[20px]">add_circle</span>
            <span>+ Buat Reservasi Manual</span>
        </a>
    </div>

    <!-- Summary Metric Cards (StayManager Corporate Modern) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @php
            $now = \Carbon\Carbon::now();

            // Active Stays: Tamu yang sedang menginap di kamar hari ini
            $activeStays = $reservations->filter(function($r) use ($now) {
                if (in_array($r->status, ['Cancelled', 'Checked-out'])) return false;
                $in = \Carbon\Carbon::parse($r->check_in);
                $out = \Carbon\Carbon::parse($r->check_out);
                if ($out->format('H:i:s') == '00:00:00') {
                    $out = $out->copy()->setTime(12, 0, 0);
                }
                return $in->lte($now) && $out->gte($now);
            })->count();

            // Upcoming: Tamu yang akan datang di masa depan (Check-in > Sekarang)
            $upcoming = $reservations->filter(function($r) use ($now) {
                if (in_array($r->status, ['Cancelled', 'Checked-out'])) return false;
                $in = \Carbon\Carbon::parse($r->check_in);
                return $in->gt($now);
            })->count();

            // Pending Payment
            $pendingPay = $reservations->filter(fn($r) => $r->status == 'Pending')->count();

            // Check-outs Today
            $todayCheckouts = $reservations->filter(fn($r) => \Carbon\Carbon::parse($r->check_out)->isToday() && $r->status != 'Cancelled')->count();
        @endphp

        <!-- Active Stays -->
        <div class="bg-white border border-[#c6c6cd] rounded-xl p-4 relative overflow-hidden shadow-sm">
            <div class="status-bar bg-green-500"></div>
            <div class="flex justify-between items-center mb-1">
                <span class="text-xs font-mono-custom text-gray-500">Active Stays</span>
                <span class="material-symbols-outlined text-green-600 bg-green-50 p-1.5 rounded-lg text-[20px]">bed</span>
            </div>
            <h3 class="font-display text-2xl font-bold text-[#191c1e]">{{ str_pad($activeStays, 2, '0', STR_PAD_LEFT) }}</h3>
            <p class="text-xs text-gray-500 mt-1">Menginap hari ini</p>
        </div>

        <!-- Upcoming -->
        <div class="bg-white border border-[#c6c6cd] rounded-xl p-4 relative overflow-hidden shadow-sm">
            <div class="status-bar bg-blue-600"></div>
            <div class="flex justify-between items-center mb-1">
                <span class="text-xs font-mono-custom text-gray-500">Upcoming</span>
                <span class="material-symbols-outlined text-blue-600 bg-blue-50 p-1.5 rounded-lg text-[20px]">event_available</span>
            </div>
            <h3 class="font-display text-2xl font-bold text-[#191c1e]">{{ str_pad($upcoming, 2, '0', STR_PAD_LEFT) }}</h3>
            <p class="text-xs text-gray-500 mt-1">Datang terdekat</p>
        </div>

        <!-- Pending Payment -->
        <div class="bg-white border border-[#c6c6cd] rounded-xl p-4 relative overflow-hidden shadow-sm">
            <div class="status-bar bg-amber-500"></div>
            <div class="flex justify-between items-center mb-1">
                <span class="text-xs font-mono-custom text-gray-500">Pending Pay</span>
                <span class="material-symbols-outlined text-amber-600 bg-amber-50 p-1.5 rounded-lg text-[20px]">pending</span>
            </div>
            <h3 class="font-display text-2xl font-bold text-[#191c1e]">{{ str_pad($pendingPay, 2, '0', STR_PAD_LEFT) }}</h3>
            <p class="text-xs text-gray-500 mt-1">Menunggu verifikasi</p>
        </div>

        <!-- Checkouts Today -->
        <div class="bg-white border border-[#c6c6cd] rounded-xl p-4 relative overflow-hidden shadow-sm">
            <div class="status-bar bg-purple-600"></div>
            <div class="flex justify-between items-center mb-1">
                <span class="text-xs font-mono-custom text-gray-500">Check-outs Today</span>
                <span class="material-symbols-outlined text-purple-600 bg-purple-50 p-1.5 rounded-lg text-[20px]">output</span>
            </div>
            <h3 class="font-display text-2xl font-bold text-[#191c1e]">{{ str_pad($todayCheckouts, 2, '0', STR_PAD_LEFT) }}</h3>
            <p class="text-xs text-gray-500 mt-1">Hari ini</p>
        </div>
    </div>

    <!-- Highlight Bento Cards (Peak Season Warning & Payment Summary) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="md:col-span-2 bg-gradient-to-r from-[#131b2e] to-[#2170e4] text-white rounded-2xl p-5 shadow-sm flex flex-col justify-between">
            <div class="flex items-center gap-2 text-amber-300 text-xs font-semibold uppercase tracking-wider mb-2">
                <span class="material-symbols-outlined text-sm">warning</span>
                <span>Peak Season Notice</span>
            </div>
            <h4 class="font-display text-xl font-bold mb-1">Tingkat Okupansi Akhir Pekan Tinggi</h4>
            <p class="text-sm text-blue-100 mb-4">Pastikan ketersediaan kamar dan kelengkapan handuk/fasilitas telah dipersiapkan oleh staf sebelum tamu check-in.</p>
            <div>
                <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white text-[#131b2e] rounded-xl text-xs font-bold hover:bg-gray-100 transition shadow">
                    <span>Lihat Laporan Lengkap</span>
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>
        </div>

        <!-- Payment Summary Bento -->
        <div class="bg-white border border-[#c6c6cd] rounded-2xl p-5 shadow-sm flex flex-col justify-between space-y-3">
            <div class="flex justify-between items-center border-b pb-2">
                <h4 class="font-display text-sm font-bold text-[#191c1e]">Ringkasan Pembayaran</h4>
                <a href="{{ route('admin.reports.export_csv') }}" class="text-xs text-[#2170e4] font-semibold hover:underline flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">download</span>
                    CSV
                </a>
            </div>

            <div class="space-y-2 text-xs">
                <div class="flex justify-between">
                    <span class="text-gray-500">Fully Paid (Lunas)</span>
                    <span class="font-mono-custom font-bold text-green-600">
                        Rp {{ number_format($reservations->where('status', 'Confirmed')->sum('total_harga'), 0, ',', '.') }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Pending / Total</span>
                    <span class="font-mono-custom font-bold text-amber-600">
                        Rp {{ number_format($reservations->sum('total_harga'), 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Reservasi -->
    <div class="bg-white border border-[#c6c6cd] rounded-2xl shadow-sm overflow-hidden">
        <div class="p-4 border-b border-[#c6c6cd] flex flex-col sm:flex-row justify-between gap-3 items-center bg-gray-50/50">
            <h4 class="font-display text-base font-bold text-[#191c1e]">Daftar Semua Reservasi</h4>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100/70 border-b border-[#c6c6cd] text-xs font-mono-custom text-gray-600 uppercase">
                        <th class="py-3.5 px-4">ID Booking</th>
                        <th class="py-3.5 px-4">Tamu</th>
                        <th class="py-3.5 px-4">Kamar</th>
                        <th class="py-3.5 px-4">Check-In / Out</th>
                        <th class="py-3.5 px-4">Total</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($reservations as $res)
                    <tr class="hover:bg-blue-50/30 transition-colors">
                        <td class="py-3.5 px-4 font-mono-custom font-bold text-gray-900">
                            #{{ str_pad($res->id, 5, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="py-3.5 px-4">
                            <div class="font-bold text-[#191c1e]">{{ $res->guest->nama }}</div>
                            <div class="text-xs text-gray-400 font-mono-custom">{{ $res->guest->kontak }}</div>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="px-2.5 py-1 rounded-lg bg-gray-100 text-gray-700 text-xs font-medium">
                                {{ $res->room->nama }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-xs font-mono-custom text-gray-600">
                            <div>{{ \Carbon\Carbon::parse($res->check_in)->format('d M Y') }}</div>
                            <div class="text-gray-400">s/d {{ \Carbon\Carbon::parse($res->check_out)->format('d M Y') }}</div>
                        </td>
                        <td class="py-3.5 px-4 font-bold text-[#2170e4]">
                            Rp {{ number_format($res->total_harga, 0, ',', '.') }}
                        </td>
                        <td class="py-3.5 px-4">
                            @php
                                $in = \Carbon\Carbon::parse($res->check_in);
                                $out = \Carbon\Carbon::parse($res->check_out);
                                $isCheckoutToday = $out->isToday() && !in_array($res->status, ['Cancelled', 'Checked-out']);
                                if ($out->format('H:i:s') == '00:00:00') {
                                    $out = $out->copy()->setTime(12, 0, 0);
                                }
                                $isCurrentlyActive = $in->lte($now) && $out->gte($now) && !in_array($res->status, ['Cancelled', 'Checked-out']);
                                $isUpcoming = $in->gt($now) && !in_array($res->status, ['Cancelled', 'Checked-out']);
                            @endphp

                            @if($isCheckoutToday)
                                <span class="px-2.5 py-1 rounded-full bg-purple-100 text-purple-800 text-xs font-bold flex items-center gap-1 w-fit">
                                    <span class="w-1.5 h-1.5 rounded-full bg-purple-600 animate-pulse"></span>
                                    <span>Check-out Hari Ini</span>
                                </span>
                            @elseif($isCurrentlyActive)
                                <span class="px-2.5 py-1 rounded-full bg-green-100 text-green-800 text-xs font-bold flex items-center gap-1 w-fit">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-600 animate-pulse"></span>
                                    <span>Active Stay</span>
                                </span>
                            @elseif($isUpcoming)
                                <span class="px-2.5 py-1 rounded-full bg-blue-100 text-blue-800 text-xs font-bold flex items-center gap-1 w-fit">
                                    <span>Upcoming ({{ $in->diffInDays($now->startOfDay()) + 1 }} hr lg)</span>
                                </span>
                            @elseif($res->status == 'Confirmed')
                                <span class="px-2.5 py-1 rounded-full bg-green-100 text-green-800 text-xs font-bold">Confirmed</span>
                            @elseif($res->status == 'Checked-out')
                                <span class="px-2.5 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-bold">Checked-out</span>
                            @elseif($res->status == 'Cancelled')
                                <span class="px-2.5 py-1 rounded-full bg-red-100 text-red-800 text-xs font-bold">Ditolak</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full bg-amber-100 text-amber-800 text-xs font-bold">{{ $res->status }}</span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4 font-medium">
                            <div class="flex items-center gap-1.5">
                                <a href="{{ route('admin.reservations.show', $res->id) }}" class="inline-flex items-center gap-1 text-xs text-[#2170e4] font-bold hover:underline bg-blue-50 px-2.5 py-1.5 rounded-lg border border-blue-100" title="Lihat Detail">
                                    <span>Detail</span>
                                </a>

                                @if(!in_array($res->status, ['Checked-out', 'Cancelled']))
                                <form action="{{ route('admin.reservations.checkout_guest', $res->id) }}" method="POST" class="inline" onsubmit="return confirm('Proses Check-out tamu ini sekarang?');">
                                    @csrf
                                    <button type="submit" class="px-2 py-1 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded-lg text-xs font-bold border border-blue-200 transition" title="Proses Check-out Tamu">
                                        Check-out
                                    </button>
                                </form>
                                @endif

                                @if($res->status != 'Cancelled')
                                <form action="{{ route('admin.reservations.reject', $res->id) }}" method="POST" class="inline" onsubmit="return confirm('Tolak pengajuan reservasi ini?');">
                                    @csrf
                                    <button type="submit" class="px-2 py-1 bg-amber-50 text-amber-700 hover:bg-amber-100 rounded-lg text-xs font-bold border border-amber-200 transition" title="Tolak Reservasi">
                                        Tolak
                                    </button>
                                </form>
                                @endif

                                <form action="{{ route('admin.reservations.destroy', $res->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus permanen reservasi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1 text-red-500 hover:bg-red-50 rounded-lg transition" title="Hapus Permanen">
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-gray-500">Belum ada data reservasi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
