@extends('layouts.admin')

@section('title', 'Laporan')
@section('page-title', 'Laporan & Analitik')

@section('content')
<div class="space-y-6">
    <!-- Report Type Selection -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <button onclick="showReport('sales')" class="bg-white hover:bg-blue-50 border-2 border-blue-600 rounded-xl p-6 text-left transition-all">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-line text-blue-600 text-xl"></i>
                </div>
            </div>
            <h3 class="font-bold text-gray-900 text-lg">Laporan Penjualan</h3>
            <p class="text-sm text-gray-600 mt-2">Revenue, tiket terjual, trend penjualan</p>
        </button>

        <button onclick="showReport('passengers')" class="bg-white hover:bg-blue-50 border border-gray-300 rounded-xl p-6 text-left transition-all">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-green-600 text-xl"></i>
                </div>
            </div>
            <h3 class="font-bold text-gray-900 text-lg">Laporan Penumpang</h3>
            <p class="text-sm text-gray-600 mt-2">Statistik penumpang, demografi</p>
        </button>

        <button onclick="showReport('routes')" class="bg-white hover:bg-blue-50 border border-gray-300 rounded-xl p-6 text-left transition-all">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-route text-purple-600 text-xl"></i>
                </div>
            </div>
            <h3 class="font-bold text-gray-900 text-lg">Laporan Rute</h3>
            <p class="text-sm text-gray-600 mt-2">Performance per rute, occupancy</p>
        </button>

        <button onclick="showReport('financial')" class="bg-white hover:bg-blue-50 border border-gray-300 rounded-xl p-6 text-left transition-all">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-orange-600 text-xl"></i>
                </div>
            </div>
            <h3 class="font-bold text-gray-900 text-lg">Laporan Keuangan</h3>
            <p class="text-sm text-gray-600 mt-2">Cash flow, refund, reconciliation</p>
        </button>
    </div>

    <!-- Report Generator -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-6">Generate Laporan</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Laporan</label>
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option>Laporan Harian</option>
                    <option>Laporan Mingguan</option>
                    <option>Laporan Bulanan</option>
                    <option>Custom Range</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
                <input type="date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Sampai Tanggal</label>
                <input type="date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Format</label>
                <div class="flex space-x-2">
                    <button class="flex-1 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm">
                        <i class="fas fa-file-excel mr-1"></i>Excel
                    </button>
                    <button class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm">
                        <i class="fas fa-file-pdf mr-1"></i>PDF
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl shadow-lg p-6 text-white">
            <p class="text-sm opacity-90">Total Revenue (Bulan Ini)</p>
            <p class="text-3xl font-bold mt-2">Rp 1.2B</p>
            <p class="text-xs mt-3 opacity-75">
                <i class="fas fa-arrow-up mr-1"></i>+15.3% dari bulan lalu
            </p>
        </div>

        <div class="bg-gradient-to-br from-green-600 to-green-700 rounded-xl shadow-lg p-6 text-white">
            <p class="text-sm opacity-90">Tiket Terjual</p>
            <p class="text-3xl font-bold mt-2">8,542</p>
            <p class="text-xs mt-3 opacity-75">
                <i class="fas fa-arrow-up mr-1"></i>+12.8% dari bulan lalu
            </p>
        </div>

        <div class="bg-gradient-to-br from-purple-600 to-purple-700 rounded-xl shadow-lg p-6 text-white">
            <p class="text-sm opacity-90">Avg Occupancy Rate</p>
            <p class="text-3xl font-bold mt-2">78.5%</p>
            <p class="text-xs mt-3 opacity-75">
                <i class="fas fa-arrow-down mr-1"></i>-2.1% dari bulan lalu
            </p>
        </div>

        <div class="bg-gradient-to-br from-orange-600 to-orange-700 rounded-xl shadow-lg p-6 text-white">
            <p class="text-sm opacity-90">Total Refund</p>
            <p class="text-3xl font-bold mt-2">Rp 45M</p>
            <p class="text-xs mt-3 opacity-75">
                <i class="fas fa-arrow-up mr-1"></i>+5.2% dari bulan lalu
            </p>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Revenue Trend -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Trend Revenue (30 Hari)</h3>
            <canvas id="revenueTrendChart" height="250"></canvas>
        </div>

        <!-- Top Routes -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Top 5 Rute Terlaris</h3>
            <canvas id="topRoutesChart" height="250"></canvas>
        </div>
    </div>

    <!-- Detailed Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-900">Laporan Detail Transaksi</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Tiket</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Revenue</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Refund</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Net</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Occupancy</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @php
                        $data = [
                            ['date' => '22 Nov 2025', 'tickets' => 342, 'revenue' => 45200000, 'refund' => 1500000, 'occupancy' => 82],
                            ['date' => '21 Nov 2025', 'tickets' => 328, 'revenue' => 43800000, 'refund' => 2100000, 'occupancy' => 79],
                            ['date' => '20 Nov 2025', 'tickets' => 356, 'revenue' => 47300000, 'refund' => 1200000, 'occupancy' => 85],
                            ['date' => '19 Nov 2025', 'tickets' => 298, 'revenue' => 39500000, 'refund' => 800000, 'occupancy' => 72],
                            ['date' => '18 Nov 2025', 'tickets' => 312, 'revenue' => 41600000, 'refund' => 1800000, 'occupancy' => 75],
                        ];
                    @endphp

                    @foreach($data as $row)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-semibold text-gray-900">{{ $row['date'] }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ number_format($row['tickets']) }}</td>
                        <td class="px-6 py-4 font-semibold text-green-600">Rp {{ number_format($row['revenue'], 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-red-600">Rp {{ number_format($row['refund'], 0, ',', '.') }}</td>
                        <td class="px-6 py-4 font-bold text-blue-600">Rp {{ number_format($row['revenue'] - $row['refund'], 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <span class="mr-2 font-semibold text-gray-900">{{ $row['occupancy'] }}%</span>
                                <div class="w-20 bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $row['occupancy'] }}%"></div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Scheduled Reports -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-900">Jadwal Laporan Otomatis</h3>
            <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm">
                <i class="fas fa-plus mr-2"></i>Tambah Jadwal
            </button>
        </div>
        <div class="space-y-3">
            @php
                $schedules = [
                    ['name' => 'Laporan Harian Penjualan', 'frequency' => 'Setiap hari @ 23:59', 'recipient' => 'manager@kbt.com', 'status' => 'active'],
                    ['name' => 'Laporan Mingguan Lengkap', 'frequency' => 'Setiap Senin @ 08:00', 'recipient' => 'director@kbt.com', 'status' => 'active'],
                    ['name' => 'Laporan Bulanan Financial', 'frequency' => 'Tanggal 1 setiap bulan', 'recipient' => 'finance@kbt.com', 'status' => 'active'],
                ];
            @endphp

            @foreach($schedules as $schedule)
            <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                <div class="flex items-center">
                    <i class="fas fa-calendar-check text-blue-600 text-xl mr-4"></i>
                    <div>
                        <p class="font-semibold text-gray-900">{{ $schedule['name'] }}</p>
                        <p class="text-sm text-gray-600">{{ $schedule['frequency'] }} → {{ $schedule['recipient'] }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="px-3 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">{{ $schedule['status'] }}</span>
                    <button class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="p-2 text-red-600 hover:bg-red-50 rounded-lg">
                        <i class="fas fa-trash"></i>
                    </button>
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
// Revenue Trend Chart
const revenueTrend = document.getElementById('revenueTrendChart');
new Chart(revenueTrend, {
    type: 'line',
    data: {
        labels: Array.from({length: 30}, (_, i) => `${i+1} Nov`),
        datasets: [{
            label: 'Revenue (Juta Rp)',
            data: [38, 42, 35, 45, 48, 43, 47, 52, 49, 46, 44, 50, 48, 51, 47, 45, 49, 52, 48, 50, 46, 44, 47, 49, 45, 43, 46, 48, 44, 45],
            borderColor: 'rgb(37, 99, 235)',
            backgroundColor: 'rgba(37, 99, 235, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } }
    }
});

// Top Routes Chart
const topRoutes = document.getElementById('topRoutesChart');
new Chart(topRoutes, {
    type: 'bar',
    data: {
        labels: ['Medan-Pematang Siantar', 'Medan-Rantau Prapat', 'Medan-Sibolga', 'Medan-Berastagi', 'Medan-Padang Sidempuan'],
        datasets: [{
            label: 'Revenue (Juta Rp)',
            data: [152, 132, 118, 105, 84],
            backgroundColor: ['#3b82f6', '#10b981', '#8b5cf6', '#f59e0b', '#ef4444']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } }
    }
});
</script>
@endpush
