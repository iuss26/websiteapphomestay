@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Database Tamu</h2>
</div>

<div class="bg-white shadow rounded-lg overflow-hidden">
    <div class="overflow-x-auto"><table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No Identitas / KTP</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kontak</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asal Kota</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Booking</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($guests as $guest)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">{{ $guest->nama }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $guest->no_identitas }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $guest->kontak }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $guest->alamat }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">{{ $guest->reservations_count }} kali</td>
            </tr>
            @endforeach
        </tbody>
    </table></div>
</div>
@endsection

