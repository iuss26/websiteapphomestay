<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Keuangan</title>
    <!-- Gunakan Tailwind untuk styling print -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { font-size: 12pt; }
            .no-print { display: none; }
            .page-break { page-break-after: always; }
        }
    </style>
</head>
<body class="bg-white text-gray-800 p-8 max-w-5xl mx-auto">
    <div class="no-print mb-6 text-right">
        <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Print / Simpan PDF
        </button>
    </div>

    <!-- Header -->
    <div class="text-center mb-8 border-b-2 border-gray-800 pb-4">
        <h1 class="text-3xl font-bold uppercase">Laporan Keuangan Bulanan</h1>
        <h2 class="text-xl font-semibold mt-2">Teras Abah Homestay</h2>
        <p class="text-gray-600 mt-1">Periode: {{ date('F', mktime(0, 0, 0, $month, 10)) }} {{ $year }}</p>
    </div>

    <!-- Ringkasan (P&L) -->
    <div class="mb-8">
        <h3 class="text-xl font-bold mb-4 border-b pb-2">Ringkasan Laba / Rugi (P&L)</h3>
        <div class="overflow-x-auto"><table class="w-full text-left text-lg">
            <tr class="border-b border-gray-200">
                <td class="py-2 font-semibold">Total Pemasukan (Reservasi)</td>
                <td class="py-2 text-right">Rp {{ number_format($total_income, 0, ',', '.') }}</td>
            </tr>
            <tr class="border-b border-gray-200">
                <td class="py-2 font-semibold">Total Pengeluaran Operasional</td>
                <td class="py-2 text-right text-red-600">(Rp {{ number_format($total_expense, 0, ',', '.') }})</td>
            </tr>
            <tr class="border-b-4 border-gray-800 bg-gray-100">
                <td class="py-3 px-2 font-bold uppercase">Laba Bersih (Net Profit)</td>
                <td class="py-3 px-2 text-right font-bold {{ $net_profit >= 0 ? 'text-green-600' : 'text-red-600' }}">
                    Rp {{ number_format($net_profit, 0, ',', '.') }}
                </td>
            </tr>
        </table></div>
    </div>

    <!-- Rincian Pemasukan -->
    <div class="mb-8 page-break">
        <h3 class="text-lg font-bold mb-4">Rincian Pemasukan</h3>
        <div class="overflow-x-auto"><table class="w-full text-left border-collapse border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-gray-300 py-2 px-3 text-sm">ID</th>
                    <th class="border border-gray-300 py-2 px-3 text-sm">Tamu</th>
                    <th class="border border-gray-300 py-2 px-3 text-sm">Kamar</th>
                    <th class="border border-gray-300 py-2 px-3 text-sm">Check-in</th>
                    <th class="border border-gray-300 py-2 px-3 text-sm text-right">Total (Rp)</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($reservations as $res)
                <tr>
                    <td class="border border-gray-300 py-2 px-3">#{{ str_pad($res->id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td class="border border-gray-300 py-2 px-3">{{ $res->guest->nama }}</td>
                    <td class="border border-gray-300 py-2 px-3">{{ $res->room->nama }}</td>
                    <td class="border border-gray-300 py-2 px-3">{{ \Carbon\Carbon::parse($res->check_in)->format('d/m/Y') }}</td>
                    <td class="border border-gray-300 py-2 px-3 text-right">{{ number_format($res->total_harga, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="border border-gray-300 py-4 text-center text-gray-500">Tidak ada pemasukan</td></tr>
                @endforelse
            </tbody>
        </table></div>
    </div>

    <!-- Rincian Pengeluaran -->
    <div class="mb-8">
        <h3 class="text-lg font-bold mb-4">Rincian Pengeluaran</h3>
        <div class="overflow-x-auto"><table class="w-full text-left border-collapse border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-gray-300 py-2 px-3 text-sm">Tgl</th>
                    <th class="border border-gray-300 py-2 px-3 text-sm">Kategori</th>
                    <th class="border border-gray-300 py-2 px-3 text-sm">Catatan</th>
                    <th class="border border-gray-300 py-2 px-3 text-sm text-right">Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($expenses as $exp)
                <tr>
                    <td class="border border-gray-300 py-2 px-3">{{ \Carbon\Carbon::parse($exp->tanggal)->format('d/m/Y') }}</td>
                    <td class="border border-gray-300 py-2 px-3">{{ $exp->kategori }}</td>
                    <td class="border border-gray-300 py-2 px-3">{{ $exp->catatan }}</td>
                    <td class="border border-gray-300 py-2 px-3 text-right">{{ number_format($exp->jumlah, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="border border-gray-300 py-4 text-center text-gray-500">Tidak ada pengeluaran</td></tr>
                @endforelse
            </tbody>
        </table></div>
    </div>
    
    <!-- Tanda Tangan -->
    <div class="mt-16 flex justify-end">
        <div class="text-center">
            <p class="mb-16">Anyer, {{ date('d F Y') }}</p>
            <p class="font-bold underline">Admin / Pemilik</p>
        </div>
    </div>
</body>
</html>


