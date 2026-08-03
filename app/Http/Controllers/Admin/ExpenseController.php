<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::orderBy('tanggal', 'desc')->get();
        return view('admin.expenses.index', compact('expenses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'kategori' => 'required|string',
            'jumlah' => 'required|numeric|min:0',
            'catatan' => 'nullable|string',
        ]);

        Expense::create($request->all());

        return back()->with('success', 'Pengeluaran berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        Expense::findOrFail($id)->delete();
        return back()->with('success', 'Pengeluaran berhasil dihapus.');
    }
}
