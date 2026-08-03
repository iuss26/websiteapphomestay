@extends('layouts.admin')

@section('title', 'Financial Overview & Pengeluaran')

@section('content')
<div class="space-y-6" x-data="{ modalOpen: false }">

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h3 class="font-display text-[24px] md:text-[28px] font-bold text-[#191c1e]">
                Keuangan & Catatan Pengeluaran
            </h3>
            <p class="text-[14px] text-[#45464d] mt-1">
                Pantau total pemasukan, catat biaya operasional, dan hitung laba bersih homestay.
            </p>
        </div>

        <button @click="modalOpen = true" class="flex items-center gap-2 px-5 py-2.5 bg-[#131b2e] hover:bg-black text-white font-bold rounded-xl shadow-md transition-transform active:scale-95 text-sm">
            <span class="material-symbols-outlined text-[20px]">add</span>
            <span>Tambah Pengeluaran</span>
        </button>
    </div>

    <!-- Summary Cards Grid (StayManager Corporate Modern) -->
    @php
        $totalPemasukan = \App\Models\Reservation::where('status', '!=', 'Cancelled')->sum('total_harga');
        $totalPengeluaran = $expenses->sum('jumlah');
        $netProfit = $totalPemasukan - $totalPengeluaran;
    @endphp
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <!-- Total Pemasukan -->
        <div class="bg-white border border-[#c6c6cd] rounded-xl p-5 relative overflow-hidden shadow-sm">
            <div class="status-bar bg-green-500"></div>
            <div class="flex justify-between items-start mb-2">
                <span class="material-symbols-outlined text-green-600 bg-green-50 p-2 rounded-lg">payments</span>
                <span class="text-xs font-mono-custom font-bold text-green-600 bg-green-50 px-2 py-0.5 rounded">Pemasukan</span>
            </div>
            <p class="text-xs text-gray-500 font-mono-custom">Total Pemasukan</p>
            <h2 class="font-display text-2xl lg:text-3xl font-bold text-[#191c1e] mt-1">
                Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
            </h2>
        </div>

        <!-- Total Pengeluaran -->
        <div class="bg-white border border-[#c6c6cd] rounded-xl p-5 relative overflow-hidden shadow-sm">
            <div class="status-bar bg-red-500"></div>
            <div class="flex justify-between items-start mb-2">
                <span class="material-symbols-outlined text-red-600 bg-red-50 p-2 rounded-lg">receipt_long</span>
                <span class="text-xs font-mono-custom font-bold text-red-600 bg-red-50 px-2 py-0.5 rounded">Pengeluaran</span>
            </div>
            <p class="text-xs text-gray-500 font-mono-custom">Total Biaya Operasional</p>
            <h2 class="font-display text-2xl lg:text-3xl font-bold text-[#191c1e] mt-1">
                Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
            </h2>
        </div>

        <!-- Net Profit -->
        <div class="bg-white border border-[#c6c6cd] rounded-xl p-5 relative overflow-hidden shadow-sm">
            <div class="status-bar bg-blue-600"></div>
            <div class="flex justify-between items-start mb-2">
                <span class="material-symbols-outlined text-blue-600 bg-blue-50 p-2 rounded-lg">account_balance_wallet</span>
                <span class="text-xs font-mono-custom font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded">Net Profit</span>
            </div>
            <p class="text-xs text-gray-500 font-mono-custom">Laba Bersih</p>
            <h2 class="font-display text-2xl lg:text-3xl font-bold text-[#2170e4] mt-1">
                Rp {{ number_format($netProfit, 0, ',', '.') }}
            </h2>
        </div>
    </div>

    <!-- Tabel Pengeluaran Terbaru -->
    <div class="bg-white border border-[#c6c6cd] rounded-2xl shadow-sm overflow-hidden">
        <div class="p-4 border-b border-[#c6c6cd] flex justify-between items-center bg-gray-50/50">
            <h4 class="font-display text-base font-bold text-[#191c1e]">Riwayat Catatan Biaya</h4>
            <a href="{{ route('admin.reports.export_csv') }}" class="text-xs text-[#2170e4] font-semibold hover:underline flex items-center gap-1">
                <span class="material-symbols-outlined text-sm">download</span>
                Ekspor Laporan
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100/70 border-b border-[#c6c6cd] text-xs font-mono-custom text-gray-600 uppercase">
                        <th class="py-3.5 px-4">Tanggal</th>
                        <th class="py-3.5 px-4">Kategori</th>
                        <th class="py-3.5 px-4">Catatan / Detail</th>
                        <th class="py-3.5 px-4">Jumlah (Rupiah)</th>
                        <th class="py-3.5 px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($expenses as $exp)
                    <tr class="hover:bg-red-50/20 transition-colors">
                        <td class="py-3.5 px-4 font-mono-custom text-xs text-gray-600">
                            {{ \Carbon\Carbon::parse($exp->tanggal)->format('d M Y') }}
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="px-2.5 py-1 rounded-lg bg-gray-100 text-gray-700 text-xs font-bold">
                                {{ $exp->kategori }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-gray-700">
                            {{ $exp->catatan ?: '-' }}
                        </td>
                        <td class="py-3.5 px-4 font-bold text-red-600 font-mono-custom">
                            Rp {{ number_format($exp->jumlah, 0, ',', '.') }}
                        </td>
                        <td class="py-3.5 px-4">
                            <form action="{{ route('admin.expenses.destroy', $exp->id) }}" method="POST" onsubmit="return confirm('Hapus catatan pengeluaran ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-red-500 hover:text-red-700 font-bold hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-gray-500">Belum ada catatan pengeluaran.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Catat Pengeluaran Baru -->
    <div x-show="modalOpen" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" x-cloak>
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4 border border-[#c6c6cd]" @click.away="modalOpen = false">
            <div class="flex justify-between items-center border-b pb-3">
                <h3 class="font-display text-xl font-bold text-[#191c1e]">Tambah Pengeluaran Baru</h3>
                <button @click="modalOpen = false" class="text-gray-400 hover:text-black">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <form action="{{ route('admin.expenses.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Tanggal *</label>
                    <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Kategori *</label>
                    <select name="kategori" required class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="Utilities">Utilities (Listrik / Air / Wifi)</option>
                        <option value="Maintenance">Maintenance & Perawatan</option>
                        <option value="Operational">Operasional Homestay</option>
                        <option value="Repair">Perbaikan & Service</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Jumlah (Rp) *</label>
                    <input type="number" name="jumlah" required class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="150000">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Catatan / Rincian</label>
                    <textarea name="catatan" rows="2" class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Opsional..."></textarea>
                </div>
                <div class="flex justify-end gap-2 pt-3 border-t">
                    <button type="button" @click="modalOpen = false" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-semibold">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-[#131b2e] hover:bg-black text-white rounded-xl text-sm font-bold shadow">Simpan Biaya</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
