<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Expense;
use App\Models\Guest;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->month ?? date('m');
        $year = $request->year ?? date('Y');

        $reservations = Reservation::whereMonth('check_in', $month)
                            ->whereYear('check_in', $year)
                            ->where('status', '!=', 'Cancelled')
                            ->with('room', 'guest')
                            ->get();

        $expenses = Expense::whereMonth('tanggal', $month)
                            ->whereYear('tanggal', $year)
                            ->get();

        $total_income = $reservations->sum('total_harga');
        $total_expense = $expenses->sum('jumlah');
        $net_profit = $total_income - $total_expense;

        $total_guests = $reservations->count(); // 1 reservation = 1 room booking

        // Hitung statistik kamar paling banyak terjual & total pendapatannya
        $roomStats = \App\Models\Room::all()->map(function($room) use ($reservations) {
            $roomReservations = $reservations->where('room_id', $room->id);
            $room->total_terjual = $roomReservations->count();
            $room->total_pendapatan = $roomReservations->sum('total_harga');
            return $room;
        })->sortByDesc('total_terjual')->values();

        return view('admin.reports.index', compact(
            'month', 'year', 'reservations', 'expenses', 
            'total_income', 'total_expense', 'net_profit', 'total_guests', 'roomStats'
        ));
    }

    public function print(Request $request)
    {
        $month = $request->month ?? date('m');
        $year = $request->year ?? date('Y');

        $reservations = Reservation::whereMonth('check_in', $month)->whereYear('check_in', $year)->where('status', '!=', 'Cancelled')->with('room', 'guest')->get();
        $expenses = Expense::whereMonth('tanggal', $month)->whereYear('tanggal', $year)->get();

        $total_income = $reservations->sum('total_harga');
        $total_expense = $expenses->sum('jumlah');
        $net_profit = $total_income - $total_expense;

        return view('admin.reports.print', compact(
            'month', 'year', 'reservations', 'expenses', 
            'total_income', 'total_expense', 'net_profit'
        ));
    }

    public function exportCsv(Request $request)
    {
        $month = $request->month ?? date('m');
        $year = $request->year ?? date('Y');

        $reservations = Reservation::whereMonth('check_in', $month)->whereYear('check_in', $year)->where('status', '!=', 'Cancelled')->with('room', 'guest')->get();
        $expenses = Expense::whereMonth('tanggal', $month)->whereYear('tanggal', $year)->get();

        $total_income = $reservations->sum('total_harga');
        $total_expense = $expenses->sum('jumlah');
        $net_profit = $total_income - $total_expense;

        $filename = "Laporan_Keuangan_Homestay_{$year}_{$month}.csv";

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($reservations, $expenses, $total_income, $total_expense, $net_profit) {
            $file = fopen('php://output', 'w');
            
            // Header
            fputcsv($file, ['LAPORAN KEUANGAN BULANAN HOMESTAY']);
            fputcsv($file, []);

            // Pemasukan
            fputcsv($file, ['PEMASUKAN (RESERVASI)']);
            fputcsv($file, ['ID', 'Tamu', 'Kamar', 'Check-In', 'Check-Out', 'Total Harga']);
            foreach($reservations as $res) {
                fputcsv($file, [
                    $res->id,
                    $res->guest->nama,
                    $res->room->nama,
                    $res->check_in,
                    $res->check_out,
                    $res->total_harga
                ]);
            }
            fputcsv($file, ['Total Pemasukan', '', '', '', '', $total_income]);
            fputcsv($file, []);

            // Pengeluaran
            fputcsv($file, ['PENGELUARAN']);
            fputcsv($file, ['ID', 'Tanggal', 'Kategori', 'Catatan', 'Jumlah']);
            foreach($expenses as $exp) {
                fputcsv($file, [
                    $exp->id,
                    $exp->tanggal,
                    $exp->kategori,
                    $exp->catatan,
                    $exp->jumlah
                ]);
            }
            fputcsv($file, ['Total Pengeluaran', '', '', '', $total_expense]);
            fputcsv($file, []);

            // Profit
            fputcsv($file, ['RINGKASAN']);
            fputcsv($file, ['Laba Bersih (Net Profit)', '', '', '', '', $net_profit]);
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
