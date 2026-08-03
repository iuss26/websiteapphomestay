<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        $today = date('Y-m-d');
        
        foreach ($rooms as $room) {
            $isOccupied = $room->isOccupiedNow();
            $room->status_hari_ini = $isOccupied ? 'Terisi (Tidak Ready)' : 'Tersedia (Ready)';
        }

        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('admin.rooms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'tipe' => 'required',
            'kapasitas' => 'required|integer',
            'harga_dasar' => 'required|numeric',
            'harga_transit' => 'nullable|numeric',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'foto2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'foto3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'foto4' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'foto5' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $data = $request->all();

        $fotos = ['foto', 'foto2', 'foto3', 'foto4', 'foto5'];
        foreach ($fotos as $f) {
            if ($request->hasFile($f)) {
                $image = $request->file($f);
                $imageName = time() . '_' . $f . '_' . $image->getClientOriginalName();
                $image->move(public_path('images/rooms'), $imageName);
                $data[$f] = asset('images/rooms/' . $imageName);
            }
        }

        Room::create($data);
        return redirect()->route('admin.rooms.index')->with('success', 'Kamar berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $room = Room::findOrFail($id);
        return view('admin.rooms.edit', compact('room'));
    }

    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);
        $request->validate([
            'nama' => 'required',
            'tipe' => 'required',
            'kapasitas' => 'required|integer',
            'harga_dasar' => 'required|numeric',
            'harga_transit' => 'nullable|numeric',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'foto2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'foto3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'foto4' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'foto5' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $data = $request->all();

        $fotos = ['foto', 'foto2', 'foto3', 'foto4', 'foto5'];
        foreach ($fotos as $f) {
            if ($request->hasFile($f)) {
                $image = $request->file($f);
                $imageName = time() . '_' . $f . '_' . $image->getClientOriginalName();
                $image->move(public_path('images/rooms'), $imageName);
                $data[$f] = asset('images/rooms/' . $imageName);
            } else {
                unset($data[$f]);
            }
        }

        $room->update($data);
        return redirect()->route('admin.rooms.index')->with('success', 'Kamar berhasil diperbarui.');
    }

    public function show($id)
    {
        $room = Room::findOrFail($id);
        
        // Ambil semua reservasi kamar ini yang akan datang atau sedang berlangsung
        $reservations = $room->reservations()
            ->with('guest')
            ->orderBy('check_in', 'desc')
            ->get();
            
        return view('admin.rooms.show', compact('room', 'reservations'));
    }

    public function destroy($id)
    {
        Room::findOrFail($id)->delete();
        return redirect()->route('admin.rooms.index')->with('success', 'Kamar berhasil dihapus.');
    }
}
