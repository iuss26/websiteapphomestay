@extends('layouts.admin')

@section('title', 'Dashboard & Laporan Utama')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h3 class="font-display text-[24px] md:text-[28px] font-bold text-[#191c1e]">
                StayManager Dashboard & Reports
            </h3>
            <p class="text-[14px] text-[#45464d] mt-1">
                Ikhtisar performa bisnis, okupansi kamar, dan laporan pendapatan bulanan.
            </p>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('admin.reports.export_csv', ['month' => $month, 'year' => $year]) }}" class="flex items-center gap-1.5 px-4 py-2 bg-white border border-[#c6c6cd] hover:bg-gray-50 text-gray-800 rounded-xl text-xs font-bold shadow-sm">
                <span class="material-symbols-outlined text-sm">download</span>
                <span>Unduh CSV</span>
            </a>
            <a href="{{ route('admin.reports.print', ['month' => $month, 'year' => $year]) }}" target="_blank" class="flex items-center gap-1.5 px-4 py-2 bg-[#131b2e] hover:bg-black text-white rounded-xl text-xs font-bold shadow">
                <span class="material-symbols-outlined text-sm">print</span>
                <span>Cetak Laporan</span>
            </a>
        </div>
    </div>

    <!-- Summary Metric Cards (StayManager Design) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <!-- Total Pendapatan Card -->
        <div class="bg-white border border-[#c6c6cd] rounded-2xl p-5 relative overflow-hidden shadow-sm group hover:shadow-md transition-shadow">
            <div class="status-bar bg-[#0058be]"></div>
            <div class="flex justify-between items-start mb-2">
                <span class="material-symbols-outlined text-[#0058be] bg-[#d8e2ff] p-2 rounded-xl">
                    payments
                </span>
                <span class="text-[#009668] bg-[#4edea3]/20 px-2 py-0.5 rounded font-mono-custom text-[12px] font-bold">
                    +12.5%
                </span>
            </div>
            <p class="text-[14px] text-[#45464d] font-medium">
                Total Pendapatan Bulan Ini
            </p>
            <h2 class="font-display text-3xl font-bold leading-tight text-[#191c1e] mt-1">
                Rp {{ number_format($total_income, 0, ',', '.') }}
            </h2>
            <div class="mt-3 flex items-center gap-1 text-[#76777d] font-mono-custom text-[12px]">
                <span class="material-symbols-outlined text-sm">schedule</span>
                Updated real-time
            </div>
        </div>

        <!-- Okupansi Card -->
        <div class="bg-white border border-[#c6c6cd] rounded-2xl p-5 relative overflow-hidden shadow-sm group hover:shadow-md transition-shadow">
            <div class="status-bar bg-[#4edea3]"></div>
            <div class="flex justify-between items-start mb-2">
                <span class="material-symbols-outlined text-[#002113] bg-[#002113]/10 p-2 rounded-xl">
                    bed
                </span>
                <span class="text-[#191c1e] font-mono-custom text-[12px] font-bold">
                    Okupansi
                </span>
            </div>
            <p class="text-[14px] text-[#45464d] font-medium">
                Total Kamar Dipesan
            </p>
            <h2 class="font-display text-3xl font-bold leading-tight text-[#191c1e] mt-1">
                {{ $total_guests }} Booking
            </h2>
            <div class="mt-3 w-full bg-[#eceef0] rounded-full h-2 overflow-hidden">
                <div class="bg-[#4edea3] h-full transition-all duration-500" style="width: 71%"></div>
            </div>
        </div>

        <!-- Laba Bersih Card -->
        <div class="bg-white border border-[#c6c6cd] rounded-2xl p-5 relative overflow-hidden shadow-sm group hover:shadow-md transition-shadow">
            <div class="status-bar bg-black"></div>
            <div class="flex justify-between items-start mb-2">
                <span class="material-symbols-outlined text-black bg-[#dae2fd] p-2 rounded-xl">
                    account_balance_wallet
                </span>
                <span class="text-xs font-mono-custom font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded">Net Profit</span>
            </div>
            <p class="text-[14px] text-[#45464d] font-medium">
                Laba Bersih (Net Profit)
            </p>
            <h2 class="font-display text-3xl font-bold leading-tight text-[#2170e4] mt-1">
                Rp {{ number_format($net_profit, 0, ',', '.') }}
            </h2>
            <div class="mt-3 text-xs text-gray-500 font-mono-custom">
                Pengeluaran: Rp {{ number_format($total_expense, 0, ',', '.') }}
            </div>
        </div>
    </div>

    <!-- Main Dashboard Grid: Revenue Trends Chart & Room Quick View -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Weekly Revenue Trends Chart Section -->
        <div class="lg:col-span-2 bg-white border border-[#c6c6cd] rounded-2xl p-6 shadow-sm space-y-4">
            <div class="flex justify-between items-center flex-wrap gap-2">
                <div>
                    <h4 class="font-display text-[18px] font-bold text-[#191c1e]">
                        Weekly Revenue Trends
                    </h4>
                    <p class="text-xs text-gray-500">
                        Analisis performa grafik mingguan (Senin - Minggu)
                    </p>
                </div>
            </div>

            <!-- Simulated Bar Chart SVG/CSS -->
            <div class="h-48 flex items-end justify-between gap-2 pt-6 px-2 border-b border-gray-100">
                @php
                    $chartBars = [
                        ['day' => 'Sen', 'h' => '45%', 'color' => 'bg-blue-200'],
                        ['day' => 'Sel', 'h' => '60%', 'color' => 'bg-blue-300'],
                        ['day' => 'Rab', 'h' => '55%', 'color' => 'bg-blue-300'],
                        ['day' => 'Kam', 'h' => '85%', 'color' => 'bg-blue-500'],
                        ['day' => 'Jum', 'h' => '40%', 'color' => 'bg-blue-200'],
                        ['day' => 'Sab', 'h' => '95%', 'color' => 'bg-[#2170e4]'],
                        ['day' => 'Min', 'h' => '70%', 'color' => 'bg-blue-400'],
                    ];
                @endphp

                @foreach($chartBars as $bar)
                <div class="flex-1 flex flex-col items-center gap-2 group h-full justify-end">
                    <div class="w-full {{ $bar['color'] }} rounded-t-lg transition-all group-hover:bg-[#0058be]" style="height: {{ $bar['h'] }}"></div>
                    <span class="font-mono-custom text-[11px] text-gray-500">{{ $bar['day'] }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Room Status Quick View -->
        <div class="bg-white border border-[#c6c6cd] rounded-2xl p-6 shadow-sm space-y-4">
            <div class="flex justify-between items-center border-b pb-3">
                <h4 class="font-display text-[18px] font-bold text-[#191c1e]">
                    Status Kamar Hari Ini
                </h4>
                <a href="{{ route('admin.rooms.index') }}" class="text-xs text-[#2170e4] font-bold hover:underline">Kelola</a>
            </div>

            <div class="space-y-2.5">
                @php
                    $allRooms = \App\Models\Room::all();
                    $today = date('Y-m-d');
                @endphp

                @foreach($allRooms as $r)
                @php
                    $isOccupied = $r->isOccupiedNow();
                @endphp
                <div class="flex justify-between items-center p-2.5 rounded-xl border border-gray-100 bg-gray-50/60 hover:bg-gray-100 transition-colors">
                    <div class="flex items-center gap-2.5">
                        <span class="w-2.5 h-2.5 rounded-full {{ $isOccupied ? 'bg-blue-600' : 'bg-green-500' }}"></span>
                        <span class="font-bold text-xs text-gray-800">{{ $r->nama }}</span>
                    </div>
                    <span class="text-[11px] font-mono-custom px-2 py-0.5 rounded-full font-bold {{ $isOccupied ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                        {{ $isOccupied ? 'Terisi' : 'Ready' }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Laporan Performa & Okupansi Kamar Terlaris -->
    <div class="bg-white border border-[#c6c6cd] rounded-2xl shadow-sm overflow-hidden">
        <div class="p-5 border-b border-[#c6c6cd] flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 bg-gray-50/60">
            <div>
                <h4 class="font-display text-lg font-bold text-[#191c1e] flex items-center gap-2">
                    <span class="material-symbols-outlined text-amber-500">military_tech</span>
                    <span>Analisis Kamar Terlaris & Pendapatan per Kamar</span>
                </h4>
                <p class="text-xs text-gray-500 mt-0.5">Peringkat kamar paling banyak dipesan dan pendapatan yang dihasilkan pada periode ini.</p>
            </div>
            <span class="text-xs font-mono-custom font-bold text-[#2170e4] bg-blue-50 px-3 py-1 rounded-full border border-blue-100">
                Periode: {{ $month }}/{{ $year }}
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100/70 border-b border-[#c6c6cd] text-xs font-mono-custom text-gray-600 uppercase">
                        <th class="py-3.5 px-4 text-center w-16">Rank</th>
                        <th class="py-3.5 px-4">Nama Kamar</th>
                        <th class="py-3.5 px-4 text-center">Jumlah Terjual (Dipesan)</th>
                        <th class="py-3.5 px-4">Pendapatan Kamar</th>
                        <th class="py-3.5 px-4 w-48">Kontribusi Pendapatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($roomStats as $index => $stat)
                    @php
                        $percentage = $total_income > 0 ? min(100, round(($stat->total_pendapatan / $total_income) * 100, 1)) : 0;
                    @endphp
                    <tr class="hover:bg-amber-50/20 transition-colors">
                        <td class="py-3.5 px-4 text-center font-bold">
                            @if($index == 0)
                                <span class="w-7 h-7 rounded-full bg-amber-100 text-amber-800 border border-amber-300 inline-flex items-center justify-center font-bold text-xs shadow-sm">🥇 #1</span>
                            @elseif($index == 1)
                                <span class="w-7 h-7 rounded-full bg-slate-100 text-slate-700 border border-slate-300 inline-flex items-center justify-center font-bold text-xs shadow-sm">🥈 #2</span>
                            @elseif($index == 2)
                                <span class="w-7 h-7 rounded-full bg-orange-100 text-orange-800 border border-orange-300 inline-flex items-center justify-center font-bold text-xs shadow-sm">🥉 #3</span>
                            @else
                                <span class="text-gray-500 font-mono-custom">#{{ $index + 1 }}</span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4">
                            <div class="font-bold text-[#191c1e]">{{ $stat->nama }}</div>
                            <div class="text-xs text-gray-400 font-mono-custom">{{ $stat->tipe }}</div>
                        </td>
                        <td class="py-3.5 px-4 text-center font-bold text-gray-800">
                            <span class="px-3 py-1 bg-gray-100 rounded-xl text-xs font-mono-custom">
                                {{ $stat->total_terjual }} Kali Terjual
                            </span>
                        </td>
                        <td class="py-3.5 px-4 font-bold text-green-600 font-mono-custom">
                            Rp {{ number_format($stat->total_pendapatan, 0, ',', '.') }}
                        </td>
                        <td class="py-3.5 px-4">
                            <div class="flex items-center gap-2">
                                <div class="flex-1 bg-gray-100 rounded-full h-2 overflow-hidden">
                                    <div class="bg-[#2170e4] h-full rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                                </div>
                                <span class="text-xs font-mono-custom font-bold text-gray-600 w-10 text-right">{{ $percentage }}%</span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-gray-500">Belum ada data penjualan kamar pada periode ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
