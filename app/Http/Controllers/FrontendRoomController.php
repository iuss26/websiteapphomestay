<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class FrontendRoomController extends Controller
{
    public function index(Request $request)
    {
        // Simple filter placeholder
        $rooms = Room::all();
        return view('rooms.index', compact('rooms'));
    }

    public function show($id)
    {
        $room = Room::findOrFail($id);
        return view('rooms.show', compact('room'));
    }
}
