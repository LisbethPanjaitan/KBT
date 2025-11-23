<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Skip user creation if already exists
        if (!\App\Models\User::where('email', 'admin@kbt.com')->exists()) {
            \App\Models\User::create([
                'name' => 'Admin KBT',
                'email' => 'admin@kbt.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'phone' => '081234567890',
            ]);
        }

        if (!\App\Models\User::where('email', 'budi@example.com')->exists()) {
            \App\Models\User::create([
                'name' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'password' => bcrypt('password'),
                'role' => 'user',
                'phone' => '082345678901',
            ]);
        }

        // Create Buses
        $buses = [
            [
                'plate_number' => 'B 1234 XYZ',
                'bus_type' => 'Minibus Toyota Hiace',
                'total_seats' => 15,
                'rows' => 5,
                'seats_per_row' => 3,
                'status' => 'active',
                'facilities' => 'AC, WiFi, USB Port, Reclining Seats',
                'manufacture_year' => 2022,
            ],
            [
                'plate_number' => 'B 5678 ABC',
                'bus_type' => 'Minibus Isuzu Elf',
                'total_seats' => 15,
                'rows' => 5,
                'seats_per_row' => 3,
                'status' => 'active',
                'facilities' => 'AC, WiFi, USB Port, Snack Box',
                'manufacture_year' => 2023,
            ],
            [
                'plate_number' => 'B 9012 DEF',
                'bus_type' => 'Microbus Mercedes',
                'total_seats' => 12,
                'rows' => 4,
                'seats_per_row' => 3,
                'status' => 'active',
                'facilities' => 'AC, WiFi, USB Port, Premium Seats',
                'manufacture_year' => 2023,
            ],
        ];

        foreach ($buses as $busData) {
            \App\Models\Bus::create($busData);
        }

        // Create Routes
        $routes = [
            [
                'origin_city' => 'Medan',
                'origin_terminal' => 'Terminal Amplas',
                'destination_city' => 'Berastagi',
                'destination_terminal' => 'Terminal Berastagi',
                'distance_km' => 70,
                'estimated_duration_minutes' => 150,
                'base_price' => 45000,
                'status' => 'active',
            ],
            [
                'origin_city' => 'Berastagi',
                'origin_terminal' => 'Terminal Berastagi',
                'destination_city' => 'Medan',
                'destination_terminal' => 'Terminal Amplas',
                'distance_km' => 70,
                'estimated_duration_minutes' => 150,
                'base_price' => 45000,
                'status' => 'active',
            ],
            [
                'origin_city' => 'Medan',
                'origin_terminal' => 'Terminal Amplas',
                'destination_city' => 'Kabanjahe',
                'destination_terminal' => 'Terminal Kabanjahe',
                'distance_km' => 80,
                'estimated_duration_minutes' => 180,
                'base_price' => 50000,
                'status' => 'active',
            ],
            [
                'origin_city' => 'Kabanjahe',
                'origin_terminal' => 'Terminal Kabanjahe',
                'destination_city' => 'Medan',
                'destination_terminal' => 'Terminal Amplas',
                'distance_km' => 80,
                'estimated_duration_minutes' => 180,
                'base_price' => 50000,
                'status' => 'active',
            ],
            [
                'origin_city' => 'Berastagi',
                'origin_terminal' => 'Terminal Berastagi',
                'destination_city' => 'Kabanjahe',
                'destination_terminal' => 'Terminal Kabanjahe',
                'distance_km' => 15,
                'estimated_duration_minutes' => 30,
                'base_price' => 15000,
                'status' => 'active',
            ],
            [
                'origin_city' => 'Medan',
                'origin_terminal' => 'Terminal Amplas',
                'destination_city' => 'Pematang Siantar',
                'destination_terminal' => 'Terminal Pematang Siantar',
                'distance_km' => 130,
                'estimated_duration_minutes' => 240,
                'base_price' => 60000,
                'status' => 'active',
            ],
        ];

        foreach ($routes as $routeData) {
            \App\Models\Route::create($routeData);
        }

        // Create Schedules for next 7 days
        $buses = \App\Models\Bus::all();
        $routes = \App\Models\Route::all();

        $times = ['06:00:00', '08:00:00', '10:00:00', '12:00:00', '14:00:00', '16:00:00'];

        for ($day = 0; $day < 7; $day++) {
            $date = now()->addDays($day)->format('Y-m-d');

            foreach ($routes as $route) {
                foreach ($times as $time) {
                    $bus = $buses->random();
                    
                    $arrivalTime = \Carbon\Carbon::parse($time)
                        ->addMinutes($route->estimated_duration_minutes)
                        ->format('H:i:s');

                    $schedule = \App\Models\Schedule::create([
                        'bus_id' => $bus->id,
                        'route_id' => $route->id,
                        'departure_date' => $date,
                        'departure_time' => $time,
                        'estimated_arrival_time' => $arrivalTime,
                        'price' => $route->base_price,
                        'available_seats' => $bus->total_seats,
                        'status' => 'scheduled',
                    ]);

                    // Create seats for this schedule
                    for ($i = 1; $i <= $bus->total_seats; $i++) {
                        $row = ceil($i / $bus->seats_per_row);
                        $col = (($i - 1) % $bus->seats_per_row) + 1;
                        $seatNumber = chr(64 + $row) . $col; // A1, A2, B1, B2, etc

                        \App\Models\Seat::create([
                            'schedule_id' => $schedule->id,
                            'seat_number' => $seatNumber,
                            'row_number' => $row,
                            'column_number' => $col,
                            'status' => 'available',
                            'seat_type' => 'standard',
                            'extra_price' => 0,
                        ]);
                    }
                }
            }
        }

        // Create Add-ons
        $addons = [
            [
                'name' => 'Bagasi Ekstra (10kg)',
                'description' => 'Tambahan kapasitas bagasi 10kg',
                'type' => 'baggage',
                'price' => 10000,
                'status' => 'active',
            ],
            [
                'name' => 'Asuransi Perjalanan',
                'description' => 'Perlindungan asuransi selama perjalanan',
                'type' => 'insurance',
                'price' => 5000,
                'status' => 'active',
            ],
            [
                'name' => 'Snack Box',
                'description' => 'Paket snack untuk perjalanan',
                'type' => 'meal',
                'price' => 15000,
                'status' => 'active',
            ],
            [
                'name' => 'Antar Jemput',
                'description' => 'Layanan antar jemput dari/ke alamat',
                'type' => 'shuttle',
                'price' => 25000,
                'status' => 'active',
            ],
        ];

        foreach ($addons as $addonData) {
            \App\Models\Addon::create($addonData);
        }

        echo "✅ Demo data seeded successfully!\n";
        echo "📧 Admin Login: admin@kbt.com / password\n";
        echo "📧 User Login: budi@example.com / password\n";
    }
}
