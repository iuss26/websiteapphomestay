@extends('layouts.app')

@section('content')
<div class="bg-gray-100 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-8">Hasil Pencarian Kamar</h2>
        
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Filter Sidebar -->
            <div class="w-full lg:w-1/4">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-4 border-b pb-2">Filter</h3>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Rentang Harga</label>
                        <input type="range" min="300000" max="1000000" class="w-full">
                        <div class="flex justify-between text-sm text-gray-500 mt-1">
                            <span>Rp 300k</span>
                            <span>Rp 1M</span>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Tipe Kamar</label>
                        <div class="space-y-2">
                            <label class="flex items-center"><input type="checkbox" class="mr-2"> Standard</label>
                            <label class="flex items-center"><input type="checkbox" class="mr-2"> Deluxe</label>
                            <label class="flex items-center"><input type="checkbox" class="mr-2"> Family</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Room List -->
            <div class="w-full lg:w-3/4 space-y-6">
                @foreach($rooms as $room)
                <div class="bg-white rounded-lg shadow flex flex-col md:flex-row overflow-hidden hover:shadow-lg transition">
                    <img src="{{ $room->foto }}" alt="{{ $room->nama }}" class="w-full md:w-1/3 h-48 md:h-auto object-cover">
                    <div class="p-6 flex flex-col justify-between flex-1">
                        <div>
                            <div class="flex justify-between items-start">
                                <h3 class="text-2xl font-bold text-gray-800">{{ $room->nama }}</h3>
                                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">{{ $room->tipe }}</span>
                            </div>
                            <p class="text-gray-600 text-sm mt-2">Kapasitas: {{ $room->kapasitas }} Orang</p>
                            <p class="text-gray-500 text-sm mt-2">{{ $room->fasilitas }}</p>
                        </div>
                        <div class="flex justify-between items-end mt-4 pt-4 border-t border-gray-100">
                            <div>
                                <p class="text-xs text-gray-500">Harga per malam</p>
                                <p class="text-2xl font-bold text-red-600">Rp {{ number_format($room->harga_dasar, 0, ',', '.') }}</p>
                            </div>
                            <a href="{{ route('rooms.show', $room->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">Lihat Detail</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
