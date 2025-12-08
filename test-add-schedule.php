<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Schedule;
use App\Models\Route;
use App\Models\Bus;
use App\Models\Seat;

echo "🧪 Test Tambah Jadwal Baru\n";
echo "==========================\n\n";

// Get first route and bus
$route = Route::first();
$bus = Bus::first();

echo "📍 Rute: {$route->origin_city} → {$route->destination_city}\n";
echo "🚌 Bus: {$bus->plate_number} ({$bus->total_seats} kursi)\n\n";

// Create new schedule for tomorrow
$tomorrow = date('Y-m-d', strtotime('+1 day'));
$departureTime = '07:00:00';
$arrivalTime = '10:00:00';

$schedule = Schedule::create([
    'route_id' => $route->id,
    'bus_id' => $bus->id,
    'departure_date' => $tomorrow,
    'departure_time' => $departureTime,
    'estimated_arrival_time' => $arrivalTime,
    'price' => $route->base_price,
    'available_seats' => $bus->total_seats,
    'status' => 'scheduled',
]);

echo "✅ Schedule created: ID #{$schedule->id}\n";
echo "   Tanggal: {$schedule->departure_date}\n";
echo "   Waktu: {$schedule->departure_time}\n";
echo "   Harga: Rp " . number_format($schedule->price, 0, ',', '.') . "\n";
echo "   Available Seats: {$schedule->available_seats}\n";
echo "   Status: {$schedule->status}\n\n";

// Create seats
$totalSeats = $bus->total_seats;
$seatsPerRow = $bus->seats_per_row;

echo "🪑 Membuat seats...\n";
for ($i = 1; $i <= $totalSeats; $i++) {
    $row = ceil($i / $seatsPerRow);
    $col = (($i - 1) % $seatsPerRow) + 1;
    $seatNumber = chr(64 + $row) . $col;

    Seat::create([
        'schedule_id' => $schedule->id,
        'seat_number' => $seatNumber,
        'row_number' => $row,
        'column_number' => $col,
        'status' => 'available',
        'seat_type' => 'standard',
        'extra_price' => 0,
    ]);
}

$seatsCount = Seat::where('schedule_id', $schedule->id)->count();
echo "✅ {$seatsCount} seats berhasil dibuat\n\n";

// Test query untuk user search
echo "🔍 Test Query User Search:\n";
$userSchedules = Schedule::with(['bus', 'route'])
    ->where('departure_date', '>=', date('Y-m-d'))
    ->where('status', 'scheduled')
    ->where('available_seats', '>', 0)
    ->whereHas('route', function($q) use ($route) {
        $q->where('origin_city', $route->origin_city)
          ->where('destination_city', $route->destination_city);
    })
    ->get();

echo "   Found: {$userSchedules->count()} schedules\n";
foreach ($userSchedules as $sch) {
    echo "   - #{$sch->id}: {$sch->departure_date} {$sch->departure_time} | {$sch->available_seats} seats | Rp " . number_format($sch->price, 0, ',', '.') . "\n";
}

echo "\n✨ Test selesai! Jadwal baru seharusnya muncul di user search.\n";
