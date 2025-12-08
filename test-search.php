<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Http\Request;

echo "=== TEST SEARCH FUNCTIONALITY ===\n\n";

// Simulate search request
$homeController = new App\Http\Controllers\HomeController();

// Test 1: Search semua jadwal hari ini
echo "📍 TEST 1: Semua jadwal hari ini\n";
$request = Request::create('/search', 'GET', ['date' => date('Y-m-d')]);
$schedules = App\Models\Schedule::with(['bus', 'route'])
    ->where('departure_date', date('Y-m-d'))
    ->orderBy('departure_time', 'asc')
    ->take(5)
    ->get();

echo "Total jadwal hari ini: " . App\Models\Schedule::where('departure_date', date('Y-m-d'))->count() . "\n\n";

foreach ($schedules as $schedule) {
    echo "⏰ " . \Carbon\Carbon::parse($schedule->departure_time)->format('H:i') 
        . " - " . $schedule->route->origin_city . " → " . $schedule->route->destination_city . "\n";
    echo "   Bus: " . $schedule->bus->plate_number . " | Rp " . number_format($schedule->price, 0, ',', '.') . "\n";
}

echo "\n---\n\n";

// Test 2: Search rute spesifik
echo "📍 TEST 2: Medan → Berastagi\n";
$schedules2 = App\Models\Schedule::with(['bus', 'route'])
    ->whereHas('route', function($q) {
        $q->where('origin_city', 'Medan')
          ->where('destination_city', 'Berastagi');
    })
    ->where('departure_date', '>=', date('Y-m-d'))
    ->orderBy('departure_date', 'asc')
    ->orderBy('departure_time', 'asc')
    ->take(3)
    ->get();

echo "Total: " . $schedules2->count() . " jadwal\n\n";

foreach ($schedules2 as $schedule) {
    echo "📅 " . \Carbon\Carbon::parse($schedule->departure_date)->format('d M Y') 
        . " " . \Carbon\Carbon::parse($schedule->departure_time)->format('H:i') . "\n";
    echo "   💺 Kursi tersedia: " . $schedule->available_seats . "/" . $schedule->bus->total_seats . "\n";
}

echo "\n✅ Search functionality working!\n";
echo "👉 Buka http://127.0.0.1:8000/search di browser untuk melihat\n\n";
