@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Operasional')

@section('content')
<div class="space-y-6">
    <!-- Info KBT -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl p-6 text-white shadow-lg">
        <div class="flex items-start justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-2">Koperasi Bintang Tapanuli (KBT)</h2>
                <p class="text-blue-100">Melayani perjalanan antar kota di Sumatera Utara</p>
                <p class="text-sm text-blue-200 mt-1">Medan • Pematang Siantar • Rantau Prapat • Sibolga • Berastagi • dan kota-kota lainnya</p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-lg p-4 backdrop-blur-sm">
                <i class="fas fa-bus text-5xl"></i>
            </div>
        </div>
    </div>
    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <a href="{{ route('admin.loket.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white rounded-xl p-4 flex items-center justify-between transition-all transform hover:scale-105 shadow-lg">
            <div>
                <p class="text-sm opacity-90">Buat Pemesanan</p>
                <p class="text-lg font-bold mt-1">Manual</p>
            </div>
            <i class="fas fa-plus-circle text-3xl opacity-80"></i>
        </a>
        <a href="{{ route('admin.bookings.pending') }}" class="bg-orange-600 hover:bg-orange-700 text-white rounded-xl p-4 flex items-center justify-between transition-all transform hover:scale-105 shadow-lg">
            <div>
                <p class="text-sm opacity-90">Pending</p>
                <p class="text-lg font-bold mt-1">Payment</p>
            </div>
            <i class="fas fa-clock text-3xl opacity-80"></i>
        </a>
        <a href="{{ route('admin.manifest.today') }}" class="bg-green-600 hover:bg-green-700 text-white rounded-xl p-4 flex items-center justify-between transition-all transform hover:scale-105 shadow-lg">
            <div>
                <p class="text-sm opacity-90">Manifest</p>
                <p class="text-lg font-bold mt-1">Hari Ini</p>
            </div>
            <i class="fas fa-users text-3xl opacity-80"></i>
        </a>
        <a href="{{ route('admin.reports.today') }}" class="bg-purple-600 hover:bg-purple-700 text-white rounded-xl p-4 flex items-center justify-between transition-all transform hover:scale-105 shadow-lg">
            <div>
                <p class="text-sm opacity-90">Laporan</p>
                <p class="text-lg font-bold mt-1">Harian</p>
            </div>
            <i class="fas fa-file-chart-line text-3xl opacity-80"></i>
        </a>
    </div>

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Penjualan Hari Ini -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-blue-600 text-xl"></i>
                </div>
                <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded">+12.5%</span>
            </div>
            <p class="text-sm text-gray-600">Penjualan Hari Ini</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">Rp {{ number_format(App\Models\Payment::whereDate('created_at', date('Y-m-d'))->where('status', 'paid')->sum('amount') / 1000, 1) }}K</p>
            <p class="text-xs text-gray-500 mt-2">
                <i class="fas fa-calendar text-gray-400"></i> {{ App\Models\Payment::whereDate('created_at', date('Y-m-d'))->where('status', 'paid')->count() }} transaksi
            </p>
        </div>

        <!-- Tiket Terjual -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-ticket text-green-600 text-xl"></i>
                </div>
                <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded">+8.3%</span>
            </div>
            <p class="text-sm text-gray-600">Booking Hari Ini</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ App\Models\Booking::whereDate('created_at', date('Y-m-d'))->count() }}</p>
            <p class="text-xs text-gray-500 mt-2">
                <i class="fas fa-check-circle text-green-500"></i> {{ App\Models\Booking::whereDate('created_at', date('Y-m-d'))->where('status', 'confirmed')->count() }} confirmed
            </p>
        </div>

        <!-- Jadwal Aktif -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-purple-600 text-xl"></i>
                </div>
                <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded">Active</span>
            </div>
            <p class="text-sm text-gray-600">Jadwal Aktif</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ App\Models\Schedule::where('departure_date', '>=', date('Y-m-d'))->where('status', 'scheduled')->count() }}</p>
            <p class="text-xs text-gray-500 mt-2">
                <i class="fas fa-calendar-check text-blue-500"></i> {{ App\Models\Schedule::whereDate('departure_date', date('Y-m-d'))->count() }} hari ini
            </p>
        </div>

        <!-- Transaksi Pending -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-hourglass-half text-orange-600 text-xl"></i>
                </div>
                <span class="text-xs font-semibold text-red-600 bg-red-50 px-2 py-1 rounded">Urgent</span>
            </div>
            <p class="text-sm text-gray-600">Transaksi Pending</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ App\Models\Payment::where('status', 'pending')->count() }}</p>
            <p class="text-xs text-gray-500 mt-2">
                <i class="fas fa-clock text-orange-500"></i> {{ App\Models\Booking::where('status', 'pending')->count() }} booking pending
            </p>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Revenue Chart -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Revenue Mingguan</h3>
                    <p class="text-sm text-gray-500 mt-1">7 hari terakhir</p>
                </div>
                <div class="flex items-center space-x-2">
                    <button class="px-3 py-1 text-xs bg-blue-50 text-blue-600 rounded-lg font-medium">7D</button>
                    <button class="px-3 py-1 text-xs text-gray-600 hover:bg-gray-50 rounded-lg">30D</button>
                    <button class="px-3 py-1 text-xs text-gray-600 hover:bg-gray-50 rounded-lg">90D</button>
                </div>
            </div>
            <canvas id="revenueChart" height="200"></canvas>
        </div>

        <!-- Bookings per Route -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Top Rute</h3>
                    <p class="text-sm text-gray-500 mt-1">Berdasarkan jumlah pemesanan</p>
                </div>
                <button class="text-sm text-blue-600 hover:text-blue-700 font-medium">Lihat Semua</button>
            </div>
            <div class="space-y-4">
                @php
                    $routes = [
                        ['from' => 'Medan', 'to' => 'Pematang Siantar', 'bookings' => 342, 'revenue' => 'Rp 8.5M', 'percentage' => 85],
                        ['from' => 'Medan', 'to' => 'Berastagi', 'bookings' => 298, 'revenue' => 'Rp 7.2M', 'percentage' => 74],
                        ['from' => 'Medan', 'to' => 'Sibolga', 'bookings' => 256, 'revenue' => 'Rp 6.8M', 'percentage' => 64],
                        ['from' => 'Pematang Siantar', 'to' => 'Medan', 'bookings' => 234, 'revenue' => 'Rp 5.9M', 'percentage' => 58],
                        ['from' => 'Medan', 'to' => 'Rantau Prapat', 'bookings' => 189, 'revenue' => 'Rp 4.7M', 'percentage' => 47],
                    ];
                @endphp

                @foreach($routes as $route)
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-2">
                            <p class="font-semibold text-gray-900">{{ $route['from'] }} → {{ $route['to'] }}</p>
                            <span class="text-sm text-gray-600">{{ $route['bookings'] }} tiket</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex-1 bg-gray-200 rounded-full h-2 mr-4">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $route['percentage'] }}%"></div>
                            </div>
                            <span class="text-sm font-semibold text-blue-600">{{ $route['revenue'] }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Alerts & Schedule Status -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Critical Alerts -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Alert Penting</h3>
                <span class="text-xs bg-red-100 text-red-600 px-2 py-1 rounded font-semibold">3 Alert</span>
            </div>
            <div class="space-y-3">
                <div class="p-3 bg-red-50 border-l-4 border-red-500 rounded">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-triangle text-red-500 mt-1"></i>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-semibold text-red-800">Jadwal Penuh</p>
                            <p class="text-xs text-red-700 mt-1">Medan - Berastagi (14:00) sudah 100% terisi</p>
                            <p class="text-xs text-red-600 mt-1">2 menit yang lalu</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-3 bg-yellow-50 border-l-4 border-yellow-500 rounded">
                    <div class="flex items-start">
                        <i class="fas fa-clock text-yellow-500 mt-1"></i>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-semibold text-yellow-800">Delay Alert</p>
                            <p class="text-xs text-yellow-700 mt-1">Bus #1234 delay 30 menit dari Pematang Siantar</p>
                            <p class="text-xs text-yellow-600 mt-1">5 menit yang lalu</p>
                        </div>
                    </div>
                </div>

                <div class="p-3 bg-orange-50 border-l-4 border-orange-500 rounded">
                    <div class="flex items-start">
                        <i class="fas fa-users text-orange-500 mt-1"></i>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-semibold text-orange-800">Overbooking Risk</p>
                            <p class="text-xs text-orange-700 mt-1">Sibolga - Medan (18:00) mendekati kapasitas</p>
                            <p class="text-xs text-orange-600 mt-1">12 menit yang lalu</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Schedules -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Jadwal Hari Ini</h3>
                <a href="{{ route('admin.schedules.today') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="border-b border-gray-200">
                        <tr class="text-left text-xs font-semibold text-gray-600 uppercase">
                            <th class="pb-3">Waktu</th>
                            <th class="pb-3">Rute</th>
                            <th class="pb-3">Bus</th>
                            <th class="pb-3">Terisi</th>
                            <th class="pb-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @php
                            $schedules = [
                                ['time' => '06:00', 'route' => 'Medan - Pematang Siantar', 'bus' => 'BK-1234-ABC', 'filled' => 45, 'capacity' => 48, 'status' => 'On Time'],
                                ['time' => '08:00', 'route' => 'Medan - Berastagi', 'bus' => 'BK-5678-DEF', 'filled' => 48, 'capacity' => 48, 'status' => 'Penuh'],
                                ['time' => '10:00', 'route' => 'Medan - Sibolga', 'bus' => 'BK-9012-GHI', 'filled' => 32, 'capacity' => 48, 'status' => 'On Time'],
                                ['time' => '12:00', 'route' => 'Pematang Siantar - Medan', 'bus' => 'BK-3456-JKL', 'filled' => 28, 'capacity' => 48, 'status' => 'Delay 15m'],
                                ['time' => '14:00', 'route' => 'Medan - Rantau Prapat', 'bus' => 'BK-7890-MNO', 'filled' => 48, 'capacity' => 48, 'status' => 'Penuh'],
                            ];
                        @endphp

                        @foreach($schedules as $schedule)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 font-semibold text-gray-900">{{ $schedule['time'] }}</td>
                            <td class="py-3 text-gray-700">{{ $schedule['route'] }}</td>
                            <td class="py-3 text-gray-600">{{ $schedule['bus'] }}</td>
                            <td class="py-3">
                                <div class="flex items-center">
                                    <span class="mr-2 {{ $schedule['filled'] == $schedule['capacity'] ? 'text-red-600 font-semibold' : 'text-gray-700' }}">
                                        {{ $schedule['filled'] }}/{{ $schedule['capacity'] }}
                                    </span>
                                    <div class="w-16 bg-gray-200 rounded-full h-1.5">
                                        <div class="h-1.5 rounded-full {{ $schedule['filled'] == $schedule['capacity'] ? 'bg-red-500' : 'bg-blue-600' }}" 
                                             style="width: {{ ($schedule['filled']/$schedule['capacity'])*100 }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3">
                                @if($schedule['status'] == 'Penuh')
                                    <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-700 rounded">{{ $schedule['status'] }}</span>
                                @elseif(str_contains($schedule['status'], 'Delay'))
                                    <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-700 rounded">{{ $schedule['status'] }}</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-700 rounded">{{ $schedule['status'] }}</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-900">Aktivitas Terbaru</h3>
            <a href="{{ route('admin.audit.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Lihat Semua</a>
        </div>
        <div class="space-y-4">
            @php
                $activities = [
                    ['user' => 'John Doe', 'action' => 'membuat pemesanan manual', 'detail' => '#BK-2025-001234', 'time' => '2 menit yang lalu', 'icon' => 'fa-plus-circle', 'color' => 'blue'],
                    ['user' => 'Jane Smith', 'action' => 'mengkonfirmasi pembayaran tunai', 'detail' => '#BK-2025-001233', 'time' => '5 menit yang lalu', 'icon' => 'fa-check-circle', 'color' => 'green'],
                    ['user' => 'Robert Johnson', 'action' => 'membatalkan pemesanan', 'detail' => '#BK-2025-001232', 'time' => '12 menit yang lalu', 'icon' => 'fa-times-circle', 'color' => 'red'],
                    ['user' => 'Sarah Williams', 'action' => 'menambahkan jadwal baru', 'detail' => 'Medan - Kabanjahe', 'time' => '25 menit yang lalu', 'icon' => 'fa-calendar-plus', 'color' => 'purple'],
                ];
            @endphp

            @foreach($activities as $activity)
            <div class="flex items-start pb-4 border-b border-gray-100 last:border-0 last:pb-0">
                <div class="w-10 h-10 bg-{{ $activity['color'] }}-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas {{ $activity['icon'] }} text-{{ $activity['color'] }}-600"></i>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm text-gray-900">
                        <span class="font-semibold">{{ $activity['user'] }}</span> {{ $activity['action'] }}
                        <span class="text-blue-600 font-medium">{{ $activity['detail'] }}</span>
                    </p>
                    <p class="text-xs text-gray-500 mt-1">{{ $activity['time'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// Revenue Chart
const ctx = document.getElementById('revenueChart');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
        datasets: [{
            label: 'Revenue (Juta Rp)',
            data: [35, 42, 38, 48, 45, 52, 45],
            borderColor: 'rgb(37, 99, 235)',
            backgroundColor: 'rgba(37, 99, 235, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + value + 'M';
                    }
                }
            }
        }
    }
});

// Auto-refresh dashboard every 30 seconds
setInterval(() => {
    // Reload data via AJAX
    console.log('Refreshing dashboard data...');
}, 30000);
</script>
@endpush
