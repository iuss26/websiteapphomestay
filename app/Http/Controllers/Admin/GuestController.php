<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index()
    {
        $guests = Guest::withCount('reservations')->latest()->get();
        return view('admin.guests.index', compact('guests'));
    }
}
