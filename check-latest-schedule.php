<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Schedule;

echo "🔍 Check Latest Schedules\n";
echo "=========================\n\n";

// Get 10 latest schedules
$latestSchedules = Schedule::with(['route', 'bus'])
    ->orderBy('id', 'desc')
    ->limit(10)
    ->get();

echo "📋 10 Jadwal Terakhir:\n\n";
foreach ($latestSchedules as $schedule) {
    echo "ID: #{$schedule->id}\n";
    echo "  Rute: {$schedule->route->origin_city} → {$schedule->route->destination_city}\n";
    echo "  Bus: {$schedule->bus->plate_number}\n";
    echo "  Tanggal: {$schedule->departure_date}\n";
    echo "  Waktu: {$schedule->departure_time}\n";
    echo "  Harga: Rp " . number_format($schedule->price, 0, ',', '.') . "\n";
    echo "  Available Seats: {$schedule->available_seats}\n";
    echo "  Status: {$schedule->status}\n";
    echo "  Created: {$schedule->created_at}\n";
    echo "\n";
}

// Check for Medan → Pematang Siantar on 2025-11-30
echo "🔎 Cari: Medan → Pematang Siantar pada 2025-11-30\n";
echo "================================================\n\n";

$searched = Schedule::with(['route', 'bus'])
    ->whereHas('route', function($q) {
        $q->where('origin_city', 'Medan')
          ->where('destination_city', 'Pematang Siantar');
    })
    ->whereDate('departure_date', '2025-11-30')
    ->get();

if ($searched->count() > 0) {
    echo "✅ Ditemukan {$searched->count()} jadwal:\n\n";
    foreach ($searched as $sch) {
        echo "  #{$sch->id}: {$sch->departure_time} | {$sch->bus->plate_number} | Rp " . number_format($sch->price, 0, ',', '.') . " | {$sch->available_seats} kursi | Status: {$sch->status}\n";
    }
} else {
    echo "❌ TIDAK ADA jadwal ditemukan!\n";
    echo "   Kemungkinan:\n";
    echo "   1. Form tidak ter-submit (tidak ada action/method)\n";
    echo "   2. Validasi gagal\n";
    echo "   3. Error saat save\n";
}
