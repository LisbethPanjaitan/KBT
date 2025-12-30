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
use App\Http\Controllers\GoogleAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Google OAuth Routes
Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('google.callback');
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

// Ticket Routes (User Side)
Route::prefix('ticket')->name('ticket.')->group(function () {
    Route::get('/{booking}', [TicketController::class, 'show'])->name('show');
    Route::get('/{booking}/download', [TicketController::class, 'download'])->name('download');
    Route::post('/{booking}/checkin', [TicketController::class, 'checkin'])->name('checkin');
    
    // ✅ FITUR: User Upload Bukti Pembayaran
    Route::get('/{code}/payment', [TicketController::class, 'paymentForm'])->name('payment');
    Route::post('/{code}/payment', [TicketController::class, 'uploadPayment'])->name('payment.upload');
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

// Admin Login Routes (Public)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', function () { return view('admin.auth.login'); })->name('login');
    Route::post('/login', [AuthController::class, 'adminLogin'])->name('login.post');
    Route::get('/logout', [AuthController::class, 'adminLogout'])->name('logout.get');
});

// Admin Routes (Protected)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('dashboard');
    
    // Authentication & Users
    Route::post('/logout', [AuthController::class, 'adminLogout'])->name('logout');
    Route::get('/profile', function () { return view('admin.profile'); })->name('profile');
    
    // Admin Users Management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', function () { return view('admin.users.index'); })->name('index');
        Route::get('/create', function () { return view('admin.users.create'); })->name('create');
        Route::get('/{id}', function () { return view('admin.users.show'); })->name('show');
        Route::get('/{id}/edit', function () { return view('admin.users.edit'); })->name('edit');
    });
    
    // Loket & Manual Booking
    Route::prefix('loket')->name('loket.')->group(function () {
        Route::get('/create', [BookingController::class, 'manualCreate'])->name('create');
        Route::get('/schedules/{id}/seats', [BookingController::class, 'getSeats'])->name('seats');
        Route::post('/store', [BookingController::class, 'manualStore'])->name('store');
    });
    
    // Bookings Management (FIXED)
    Route::prefix('bookings')->name('bookings.')->group(function () {
        Route::get('/', [BookingController::class, 'index'])->name('index');
        Route::get('/pending', [BookingController::class, 'pending'])->name('pending');
        
        // ✅ TAMBAHAN: Update Status Pembayaran Admin
        Route::put('/{id}/status', [BookingController::class, 'updateStatus'])->name('updateStatus');

        Route::get('/{booking}', [BookingController::class, 'show'])->name('show');
        Route::post('/{booking}/confirm', [BookingController::class, 'confirmPayment'])->name('confirm');
        Route::post('/{booking}/cancel', [BookingController::class, 'cancel'])->name('cancel');
        Route::post('/{booking}/refund', [BookingController::class, 'refund'])->name('refund');
        Route::post('/{booking}/reschedule', [BookingController::class, 'reschedule'])->name('reschedule');
    });

    // Routes Management
    Route::prefix('routes')->name('routes.')->group(function () {
        Route::get('/', [AdminRouteController::class, 'index'])->name('index');
        Route::get('/create', [AdminRouteController::class, 'create'])->name('create');
        Route::post('/', [AdminRouteController::class, 'store'])->name('store');
        Route::get('/{id}', [AdminRouteController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [AdminRouteController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AdminRouteController::class, 'update'])->name('update');
        Route::delete('/{id}', [AdminRouteController::class, 'destroy'])->name('destroy');
    });
    
    // Schedules Management (FIXED ORDER)
    Route::prefix('schedules')->name('schedules.')->group(function () {
        Route::get('/', [ScheduleController::class, 'index'])->name('index');
        
        // 🔥 PENTING: Calendar diletakkan SEBELUM rute dengan parameter {id}
        Route::get('/calendar', [ScheduleController::class, 'calendar'])->name('calendar');
        
        // ✅ TAMBAHAN: Update Status Operasional (Dropdown di tabel)
        Route::put('/{id}/status', [ScheduleController::class, 'updateStatus'])->name('updateStatus');

        Route::get('/today', function () { return view('admin.schedules.today'); })->name('today');
        Route::get('/create', [ScheduleController::class, 'create'])->name('create');
        Route::post('/', [ScheduleController::class, 'store'])->name('store');
        Route::get('/{id}', [ScheduleController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [ScheduleController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ScheduleController::class, 'update'])->name('update');
        Route::delete('/{id}', [ScheduleController::class, 'destroy'])->name('destroy');
    });
    
    // Vehicles Management
    Route::prefix('vehicles')->name('vehicles.')->group(function () {
        Route::get('/', [BusController::class, 'index'])->name('index');
        Route::get('/seatmap', function () { return view('admin.vehicles.seatmap'); })->name('seatmap');
        Route::get('/create', [BusController::class, 'create'])->name('create');
        Route::post('/', [BusController::class, 'store'])->name('store');
        Route::get('/{id}', [BusController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [BusController::class, 'edit'])->name('edit');
        Route::put('/{id}', [BusController::class, 'update'])->name('update');
        Route::delete('/{id}', [BusController::class, 'destroy'])->name('destroy');
    });
    
    // Pricing & Promo
    Route::prefix('pricing')->name('pricing.')->group(function () {
        Route::get('/', function () { return view('admin.pricing.index'); })->name('index');
        Route::get('/dynamic', function () { return view('admin.pricing.dynamic'); })->name('dynamic');
    });
    
    Route::prefix('promos')->name('promos.')->group(function () {
        Route::get('/', function () { return view('admin.promos.index'); })->name('index');
        Route::get('/create', function () { return view('admin.promos.create'); })->name('create');
    });
    
    // Payments & Reconciliation
    Route::prefix('payments')->name('payments.')->group(function () {
        Route::get('/', function () { return view('admin.payments.index'); })->name('index');
        Route::get('/reconciliation', function () { return view('admin.payments.reconciliation'); })->name('reconciliation');
        Route::get('/refunds', function () { return view('admin.payments.refunds'); })->name('refunds');
    });
    
    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', function () { return view('admin.reports.index'); })->name('index');
        Route::get('/today', function () { return view('admin.reports.today'); })->name('today');
        Route::get('/export', [DashboardController::class, 'exportReport'])->name('export');
    });
    
    // Manifest
    Route::prefix('manifest')->name('manifest.')->group(function () {
        Route::get('/', function () { return view('admin.manifest.index'); })->name('index');
        Route::get('/today', function () { return view('admin.manifest.today'); })->name('today');
        Route::get('/{id}', function () { return view('admin.manifest.show'); })->name('show');
        Route::get('/{id}/print', function () { return view('admin.manifest.print'); })->name('print');
    });
    
    // Notifications & Broadcast
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', function () { return view('admin.notifications.index'); })->name('index');
        Route::post('/send', [DashboardController::class, 'sendBroadcast'])->name('send');
    });
    
    // Audit Log
    Route::prefix('audit')->name('audit.')->group(function () {
        Route::get('/', function () { return view('admin.audit.index'); })->name('index');
        Route::get('/export', [DashboardController::class, 'exportAudit'])->name('export');
    });
    
    // Integrations
    Route::prefix('integrations')->name('integrations.')->group(function () {
        Route::get('/', function () { return view('admin.integrations.index'); })->name('index');
        Route::post('/connect', [DashboardController::class, 'connectIntegration'])->name('connect');
        Route::post('/disconnect', [DashboardController::class, 'disconnectIntegration'])->name('disconnect');
    });
    
    // Settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', function () { return view('admin.settings.index'); })->name('index');
        Route::post('/update', [DashboardController::class, 'updateSettings'])->name('update');
    });
    
    // Password Reset
    Route::get('/password/request', function () { return view('admin.auth.forgot-password'); })->name('password.request');
});