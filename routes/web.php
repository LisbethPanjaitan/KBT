<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BusController;
use App\Http\Controllers\Admin\RouteController as AdminRouteController;
use App\Http\Controllers\Admin\ScheduleController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');

// Public Routes (User)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/cek-pesanan', [TicketController::class, 'check'])->name('ticket.check');
Route::post('/cek-pesanan', [TicketController::class, 'search'])->name('ticket.search');
Route::get('/bantuan', function () {
    return view('help');
})->name('help');

// Booking Routes
Route::prefix('booking')->name('booking.')->group(function () {
    Route::get('/seats/{schedule}', [BookingController::class, 'selectSeats'])->name('seats');
    Route::post('/hold-seats', [BookingController::class, 'holdSeats'])->name('hold-seats');
    Route::get('/checkout', [BookingController::class, 'checkout'])->name('checkout');
    Route::post('/store', [BookingController::class, 'store'])->name('store');
    Route::get('/confirmation/{booking}', [BookingController::class, 'confirmation'])->name('confirmation');
});

// Payment Routes
Route::prefix('payment')->name('payment.')->group(function () {
    Route::post('/process', [PaymentController::class, 'process'])->name('process');
    Route::get('/success/{booking}', [PaymentController::class, 'success'])->name('success');
    Route::get('/failed/{booking}', [PaymentController::class, 'failed'])->name('failed');
});

// Ticket Routes
Route::prefix('ticket')->name('ticket.')->group(function () {
    Route::get('/{booking}', [TicketController::class, 'show'])->name('show');
    Route::get('/{booking}/download', [TicketController::class, 'download'])->name('download');
    Route::post('/{booking}/checkin', [TicketController::class, 'checkin'])->name('checkin');
});

// User Dashboard (Protected)
Route::middleware(['auth'])->group(function () {
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/dashboard', [ProfileController::class, 'dashboard'])->name('dashboard');
        Route::get('/bookings', [ProfileController::class, 'bookings'])->name('bookings');
        Route::get('/settings', [ProfileController::class, 'settings'])->name('settings');
        Route::put('/update', [ProfileController::class, 'updateProfile'])->name('update');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password');
    });
});

// Admin Routes (Protected)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Resource Routes
    Route::resource('buses', BusController::class);
    Route::resource('routes', AdminRouteController::class);
    Route::resource('schedules', ScheduleController::class);
});
