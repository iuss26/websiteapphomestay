@extends('layouts.admin')

@section('content')
<div class="bg-white p-6 shadow rounded-lg max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Tambah Kamar Baru</h2>

    @if ($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Nama Kamar</label>
            <input type="text" name="nama" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Tipe</label>
            <input type="text" name="tipe" class="w-full border rounded px-3 py-2" placeholder="Standard, Deluxe..." required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Kapasitas (Orang)</label>
            <input type="number" name="kapasitas" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Fasilitas</label>
            <textarea name="fasilitas" class="w-full border rounded px-3 py-2" rows="3" placeholder="AC, TV, Wifi..."></textarea>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Harga Dasar Per Malam (Rp)</label>
            <input type="number" name="harga_dasar" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Harga Transit 6 Jam (Rp) - Opsional</label>
            <input type="number" name="harga_transit" class="w-full border rounded px-3 py-2">
        </div>
        <div class="mb-6">
            <h3 class="text-lg font-bold text-gray-800 mb-3 border-b pb-2">Galeri Foto (Maksimal 5)</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="p-4 border rounded bg-gray-50">
                    <label class="block text-gray-700 font-bold mb-2">Foto Utama *</label>
                    <input type="file" name="foto" accept="image/*" class="w-full text-sm" required>
                </div>
                <div class="p-4 border rounded bg-gray-50">
                    <label class="block text-gray-700 font-bold mb-2">Foto 2 (Opsional)</label>
                    <input type="file" name="foto2" accept="image/*" class="w-full text-sm">
                </div>
                <div class="p-4 border rounded bg-gray-50">
                    <label class="block text-gray-700 font-bold mb-2">Foto 3 (Opsional)</label>
                    <input type="file" name="foto3" accept="image/*" class="w-full text-sm">
                </div>
                <div class="p-4 border rounded bg-gray-50">
                    <label class="block text-gray-700 font-bold mb-2">Foto 4 (Opsional)</label>
                    <input type="file" name="foto4" accept="image/*" class="w-full text-sm">
                </div>
                <div class="p-4 border rounded bg-gray-50">
                    <label class="block text-gray-700 font-bold mb-2">Foto 5 (Opsional)</label>
                    <input type="file" name="foto5" accept="image/*" class="w-full text-sm">
                </div>
            </div>
        </div>
        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.rooms.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Batal</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
        </div>
    </form>
</div>
@endsection

