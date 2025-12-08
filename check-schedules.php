<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== DATA DI DATABASE ===\n\n";

$routes = App\Models\Route::count();
$buses = App\Models\Bus::count();
$schedules = App\Models\Schedule::count();
$upcomingSchedules = App\Models\Schedule::where('departure_date', '>=', date('Y-m-d'))->count();

echo "Total Rute (Routes): $routes\n";
echo "Total Bus: $buses\n";
echo "Total Jadwal (Schedules): $schedules\n";
echo "Jadwal Aktif/Upcoming: $upcomingSchedules\n\n";

echo "=== 5 JADWAL TERBARU ===\n\n";
$recentSchedules = App\Models\Schedule::with(['route', 'bus'])
    ->where('departure_date', '>=', date('Y-m-d'))
    ->orderBy('departure_date', 'asc')
    ->orderBy('departure_time', 'asc')
    ->take(5)
    ->get();

foreach ($recentSchedules as $schedule) {
    echo "📅 " . \Carbon\Carbon::parse($schedule->departure_date)->format('d M Y') . " " 
        . \Carbon\Carbon::parse($schedule->departure_time)->format('H:i') . "\n";
    echo "🚌 " . $schedule->route->origin_city . " → " . $schedule->route->destination_city . "\n";
    echo "🚍 Bus: " . $schedule->bus->plate_number . " | Harga: Rp " . number_format($schedule->price, 0, ',', '.') . "\n";
    echo "💺 Kursi tersedia: " . $schedule->available_seats . "/" . $schedule->bus->total_seats . "\n";
    echo "---\n";
}

echo "\n";
