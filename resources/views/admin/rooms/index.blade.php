@extends('layouts.admin')

@section('title', 'Manajemen Kamar (Rooms)')

@section('content')
<div class="space-y-6" x-data="{ addModalOpen: false, editModalOpen: false, editRoom: {} }">
    
    <!-- Page Header & Counters -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h3 class="font-display text-[24px] md:text-[28px] font-bold text-[#191c1e]">
                Inventory Kamar & Okupansi
            </h3>
            <p class="text-[14px] text-[#45464d] mt-1">
                Kelola data kamar, status ketersediaan, dan galeri foto homestay secara real-time.
            </p>
        </div>

        <!-- Status Counters & Filters -->
        <div class="flex flex-wrap gap-3 items-center">
            @php
                $tersediaCount = $rooms->filter(fn($r) => str_contains($r->status_hari_ini, 'Tersedia'))->count();
                $terisiCount = $rooms->filter(fn($r) => str_contains($r->status_hari_ini, 'Terisi'))->count();
            @endphp
            
            <div class="bg-white border border-[#c6c6cd] px-3.5 py-2 rounded-xl flex items-center gap-2 shadow-sm">
                <span class="w-2.5 h-2.5 rounded-full bg-green-500 animate-pulse"></span>
                <span class="font-mono-custom text-[12px] font-semibold text-[#191c1e]">
                    {{ $tersediaCount }} Kamar Tersedia
                </span>
            </div>

            <div class="bg-white border border-[#c6c6cd] px-3.5 py-2 rounded-xl flex items-center gap-2 shadow-sm">
                <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                <span class="font-mono-custom text-[12px] font-semibold text-[#191c1e]">
                    {{ $terisiCount }} Kamar Terisi
                </span>
            </div>

            <button @click="addModalOpen = true" class="flex items-center gap-1.5 px-4 py-2 bg-[#131b2e] hover:bg-black text-white rounded-xl text-sm font-semibold shadow transition-transform active:scale-95">
                <span class="material-symbols-outlined text-[20px]">add</span>
                <span>Tambah Kamar</span>
            </button>
        </div>
    </div>

    <!-- Grid Kartu Kamar (StayManager Corporate Modern Design) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($rooms as $room)
        @php
            $isTersedia = str_contains($room->status_hari_ini, 'Tersedia');
            $barColor = $isTersedia ? 'bg-green-500' : 'bg-blue-600';
            $badgeColor = $isTersedia ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800';
            $statusLabel = $isTersedia ? 'Tersedia (Ready)' : 'Terisi (Occupied)';
        @endphp
        <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden border border-[#c6c6cd] flex flex-col relative group">
            <!-- Status Bar 4px di atas kartu -->
            <div class="status-bar {{ $barColor }}"></div>

            <!-- Gambar Kamar (Rasio 16:9 Presisi Mobile) -->
            <div class="relative aspect-video w-full overflow-hidden bg-gray-100">
                <img src="{{ $room->foto }}" alt="{{ $room->nama }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                
                <!-- Badge Status Melayang -->
                <div class="absolute top-3 right-3">
                    <span class="px-3 py-1 text-xs font-bold rounded-full shadow-sm {{ $badgeColor }} backdrop-blur-md bg-opacity-90">
                        {{ $statusLabel }}
                    </span>
                </div>
            </div>
            
            <!-- Detail Kamar -->
            <div class="p-5 flex-grow flex flex-col">
                <div class="flex justify-between items-start mb-1">
                    <h4 class="font-display text-[18px] font-bold text-[#191c1e] line-clamp-1 group-hover:text-[#2170e4] transition-colors">
                        {{ $room->nama }}
                    </h4>
                    <span class="text-xs bg-gray-100 px-2 py-0.5 rounded font-mono-custom text-gray-600">
                        {{ $room->tipe }}
                    </span>
                </div>

                <div class="flex items-center text-xs text-gray-500 gap-3 mt-1">
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">group</span>
                        {{ $room->kapasitas }} Tamu Max
                    </span>
                </div>
                
                <!-- Format Harga Rupiah -->
                <div class="mt-4 mb-4 pt-3 border-t border-gray-100">
                    <span class="text-xs text-gray-400 block font-mono-custom">Harga per Malam</span>
                    <div class="flex items-baseline text-[#2170e4]">
                        <span class="text-xs font-semibold mr-1">Rp</span>
                        <span class="font-display text-2xl font-bold tracking-tight">{{ number_format($room->harga_dasar, 0, ',', '.') }}</span>
                    </div>
                </div>
                
                <!-- Tombol Aksi -->
                <div class="mt-auto space-y-2">
                    <a href="{{ route('admin.rooms.show', $room->id) }}" class="flex items-center justify-center gap-2 w-full text-center px-4 py-2.5 bg-[#2170e4] hover:bg-[#0058be] text-white rounded-xl text-xs font-bold transition shadow-sm">
                        <span class="material-symbols-outlined text-[16px]">calendar_month</span>
                        <span>Jadwal & Detail</span>
                    </a>
                    
                    <div class="grid grid-cols-2 gap-2">
                        <button type="button" @click="editRoom = {{ json_encode($room) }}; editModalOpen = true" class="flex items-center justify-center gap-1 px-3 py-2 bg-gray-50 hover:bg-gray-100 text-gray-700 rounded-xl text-xs font-semibold transition border border-gray-200">
                            <span class="material-symbols-outlined text-[14px]">edit</span>
                            <span>Edit</span>
                        </button>
                        
                        <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" onsubmit="return confirm('Hapus kamar ini secara permanen?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="flex items-center justify-center gap-1 w-full px-3 py-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl text-xs font-semibold transition border border-red-100">
                                <span class="material-symbols-outlined text-[14px]">delete</span>
                                <span>Hapus</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Modal Tambah Kamar Baru -->
    <div x-show="addModalOpen" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" x-cloak>
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl space-y-4 border border-[#c6c6cd]" @click.away="addModalOpen = false">
            <div class="flex justify-between items-center border-b pb-3">
                <h3 class="font-display text-xl font-bold text-[#191c1e]">Tambah Kamar Baru</h3>
                <button @click="addModalOpen = false" class="text-gray-400 hover:text-black">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Kamar *</label>
                    <input type="text" name="nama" required class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Contoh: Room 01 - Deluxe King">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Tipe Kamar *</label>
                    <select name="tipe" required class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="Deluxe King">Deluxe King</option>
                        <option value="Standard Twin">Standard Twin</option>
                        <option value="Superior Queen">Superior Queen</option>
                        <option value="Suite King">Suite King</option>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Kapasitas (Tamu) *</label>
                        <input type="number" name="kapasitas" value="2" required class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Harga Dasar (Rp) *</label>
                        <input type="number" name="harga_dasar" required class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="450000">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Upload Foto Utama *</label>
                    <input type="file" name="foto" accept="image/*" required class="w-full border border-gray-300 rounded-xl p-2 text-xs bg-gray-50">
                </div>
                <div class="flex justify-end gap-2 pt-3 border-t">
                    <button type="button" @click="addModalOpen = false" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-semibold">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-[#2170e4] hover:bg-[#0058be] text-white rounded-xl text-sm font-bold shadow">Simpan Kamar</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
