<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat akun admin
        User::create([
            'nama' => 'Administrator',
            'email' => 'admin@homestay.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Buat Daftar Kamar Sesuai Permintaan
        $rooms = [
            ['nama' => 'Kamar 1', 'tipe' => 'Standard', 'kapasitas' => 2, 'fasilitas' => 'AC, TV, Queen Bed', 'harga_dasar' => 150000, 'harga_transit' => 120000, 'foto' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=800&q=80'],
            ['nama' => 'Kamar 2', 'tipe' => 'Standard', 'kapasitas' => 2, 'fasilitas' => 'AC, TV, Queen Bed', 'harga_dasar' => 150000, 'harga_transit' => 120000, 'foto' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=800&q=80'],
            ['nama' => 'Kamar 3', 'tipe' => 'Standard', 'kapasitas' => 2, 'fasilitas' => 'AC, TV, Queen Bed', 'harga_dasar' => 150000, 'harga_transit' => 120000, 'foto' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=800&q=80'],
            ['nama' => 'Kamar 4', 'tipe' => 'Deluxe', 'kapasitas' => 3, 'fasilitas' => 'AC, TV, King Bed, Sofa', 'harga_dasar' => 280000, 'harga_transit' => 200000, 'foto' => 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=800&q=80'],
            ['nama' => 'Kamar 5', 'tipe' => 'Superior', 'kapasitas' => 2, 'fasilitas' => 'AC, TV, Queen Bed, Balkon', 'harga_dasar' => 200000, 'harga_transit' => 150000, 'foto' => 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=800&q=80'],
            ['nama' => 'Kamar 6', 'tipe' => 'Deluxe', 'kapasitas' => 3, 'fasilitas' => 'AC, TV, King Bed, Sofa', 'harga_dasar' => 280000, 'harga_transit' => 200000, 'foto' => 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?auto=format&fit=crop&w=800&q=80'],
            ['nama' => 'Kamar 7', 'tipe' => 'Deluxe', 'kapasitas' => 3, 'fasilitas' => 'AC, TV, King Bed, Sofa', 'harga_dasar' => 280000, 'harga_transit' => 200000, 'foto' => 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?auto=format&fit=crop&w=800&q=80'],
            ['nama' => 'Tera House', 'tipe' => 'Family House', 'kapasitas' => 6, 'fasilitas' => 'AC, TV, 3 Queen Bed, Dapur, Ruang Tamu', 'harga_dasar' => 350000, 'harga_transit' => 250000, 'foto' => 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?auto=format&fit=crop&w=800&q=80'],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}
