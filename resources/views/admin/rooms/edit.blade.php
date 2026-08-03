@extends('layouts.admin')

@section('content')
<div class="bg-white p-6 shadow rounded-lg max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Kamar</h2>

    @if ($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Nama Kamar</label>
            <input type="text" name="nama" value="{{ $room->nama }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Tipe</label>
            <input type="text" name="tipe" value="{{ $room->tipe }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Kapasitas (Orang)</label>
            <input type="number" name="kapasitas" value="{{ $room->kapasitas }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Fasilitas</label>
            <textarea name="fasilitas" class="w-full border rounded px-3 py-2" rows="3">{{ $room->fasilitas }}</textarea>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Harga Dasar Per Malam (Rp)</label>
            <input type="number" name="harga_dasar" value="{{ $room->harga_dasar }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Harga Transit 6 Jam (Rp) - Opsional</label>
            <input type="number" name="harga_transit" value="{{ $room->harga_transit }}" class="w-full border rounded px-3 py-2">
        </div>
        <div class="mb-6">
            <h3 class="text-lg font-bold text-gray-800 mb-3 border-b pb-2">Galeri Foto (Biarkan kosong jika tidak ingin mengganti)</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="p-4 border rounded bg-gray-50 flex flex-col items-center">
                    <label class="block text-gray-700 font-bold mb-2 self-start">Foto Utama</label>
                    @if($room->foto)
                        <img src="{{ $room->foto }}" class="mb-3 h-24 w-full object-cover rounded shadow-sm">
                    @endif
                    <input type="file" name="foto" accept="image/*" class="w-full text-sm">
                </div>
                <div class="p-4 border rounded bg-gray-50 flex flex-col items-center">
                    <label class="block text-gray-700 font-bold mb-2 self-start">Foto 2</label>
                    @if($room->foto2)
                        <img src="{{ $room->foto2 }}" class="mb-3 h-24 w-full object-cover rounded shadow-sm">
                    @endif
                    <input type="file" name="foto2" accept="image/*" class="w-full text-sm">
                </div>
                <div class="p-4 border rounded bg-gray-50 flex flex-col items-center">
                    <label class="block text-gray-700 font-bold mb-2 self-start">Foto 3</label>
                    @if($room->foto3)
                        <img src="{{ $room->foto3 }}" class="mb-3 h-24 w-full object-cover rounded shadow-sm">
                    @endif
                    <input type="file" name="foto3" accept="image/*" class="w-full text-sm">
                </div>
                <div class="p-4 border rounded bg-gray-50 flex flex-col items-center">
                    <label class="block text-gray-700 font-bold mb-2 self-start">Foto 4</label>
                    @if($room->foto4)
                        <img src="{{ $room->foto4 }}" class="mb-3 h-24 w-full object-cover rounded shadow-sm">
                    @endif
                    <input type="file" name="foto4" accept="image/*" class="w-full text-sm">
                </div>
                <div class="p-4 border rounded bg-gray-50 flex flex-col items-center">
                    <label class="block text-gray-700 font-bold mb-2 self-start">Foto 5</label>
                    @if($room->foto5)
                        <img src="{{ $room->foto5 }}" class="mb-3 h-24 w-full object-cover rounded shadow-sm">
                    @endif
                    <input type="file" name="foto5" accept="image/*" class="w-full text-sm">
                </div>
            </div>
        </div>
        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.rooms.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Batal</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update</button>
        </div>
    </form>
</div>
@endsection

