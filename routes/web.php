<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FrontendRoomController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\Admin\GuestController as AdminGuestController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\ExpenseController as AdminExpenseController;

// ==========================================
// RUTE PENGUNJUNG (FRONTEND)
// ==========================================
// Halaman utama (Beranda)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/rooms', [FrontendRoomController::class, 'index'])->name('rooms.index');
Route::get('/rooms/{id}', [FrontendRoomController::class, 'show'])->name('rooms.show');

// ==========================================
// RUTE RESERVASI & PEMBAYARAN TAMU
// ==========================================
// Proses tamu memesan kamar hingga mengunggah bukti pembayaran
Route::get('/checkout/{room_id}', [ReservationController::class, 'checkout'])->name('checkout');
Route::post('/checkout/{room_id}', [ReservationController::class, 'store'])->name('checkout.store');
Route::get('/payment/{reservation_id}', [ReservationController::class, 'payment'])->name('payment');
Route::post('/payment/{reservation_id}', [ReservationController::class, 'uploadPayment'])->name('payment.upload');
Route::get('/booking/success', [ReservationController::class, 'success'])->name('booking.success');

// ==========================================
// RUTE AUTENTIKASI (LOGIN ADMIN)
// ==========================================
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==========================================
// RUTE DASBOR ADMIN (PRIVATE)
// ==========================================
// Semua rute di dalam grup ini dilindungi oleh middleware 'auth'.
// Artinya, hanya admin yang sudah login yang bisa mengaksesnya.
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    // Rooms
    Route::resource('rooms', AdminRoomController::class);
    
    // Reservations
    Route::get('/reservations', [AdminReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/create', [AdminReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [AdminReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservations/{id}', [AdminReservationController::class, 'show'])->name('reservations.show');
    Route::post('/reservations/{id}/verify', [AdminReservationController::class, 'verifyPayment'])->name('reservations.verify');
    Route::post('/reservations/{id}/reject', [AdminReservationController::class, 'reject'])->name('reservations.reject');
    Route::post('/reservations/{id}/checkout-guest', [AdminReservationController::class, 'checkoutGuest'])->name('reservations.checkout_guest');
    Route::delete('/reservations/{id}', [AdminReservationController::class, 'destroy'])->name('reservations.destroy');
    
    // Guests
    Route::get('/guests', [AdminGuestController::class, 'index'])->name('guests.index');
    
    // Expenses
    Route::get('/expenses', [AdminExpenseController::class, 'index'])->name('expenses.index');
    Route::post('/expenses', [AdminExpenseController::class, 'store'])->name('expenses.store');
    Route::delete('/expenses/{id}', [AdminExpenseController::class, 'destroy'])->name('expenses.destroy');
    
    // Reports
    Route::get('reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::get('reports/print', [AdminReportController::class, 'print'])->name('reports.print');
    Route::get('reports/export-csv', [AdminReportController::class, 'exportCsv'])->name('reports.export_csv');
});
