@extends('layouts.admin')

@section('title', 'Manifest Penumpang')
@section('page-title', 'Manifest Penumpang')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Manifest Penumpang</h2>
            <p class="text-gray-600 mt-1">Daftar penumpang per jadwal keberangkatan</p>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Tanggal</label>
                <input type="date" value="2025-11-23" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Rute</label>
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option>Semua Rute</option>
                    <option>Medan - Pematang Siantar</option>
                    <option>Medan - Rantau Prapat</option>
                    <option>Medan - Sibolga</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Jam Keberangkatan</label>
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option>Semua Jam</option>
                    <option>06:00</option>
                    <option>08:00</option>
                    <option>10:00</option>
                    <option>12:00</option>
                    <option>14:00</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">&nbsp;</label>
                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-search mr-2"></i>Cari
                </button>
            </div>
        </div>
    </div>

    <!-- Schedule Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @php
            $schedules = [
                [
                    'id' => 1,
                    'route' => 'Medan → Pematang Siantar',
                    'time' => '08:00',
                    'bus' => 'B-1234-ABC',
                    'capacity' => 48,
                    'booked' => 45,
                    'checked_in' => 42,
                    'status' => 'ready'
                ],
                [
                    'id' => 2,
                    'route' => 'Medan → Rantau Prapat',
                    'time' => '10:00',
                    'bus' => 'B-5678-DEF',
                    'capacity' => 48,
                    'booked' => 48,
                    'checked_in' => 45,
                    'status' => 'boarding'
                ],
                [
                    'id' => 3,
                    'route' => 'Medan → Sibolga',
                    'time' => '12:00',
                    'bus' => 'B-9012-GHI',
                    'capacity' => 48,
                    'booked' => 32,
                    'checked_in' => 28,
                    'status' => 'ready'
                ],
                [
                    'id' => 4,
                    'route' => 'Pematang Siantar → Medan',
                    'time' => '14:00',
                    'bus' => 'B-3456-JKL',
                    'capacity' => 48,
                    'booked' => 28,
                    'checked_in' => 0,
                    'status' => 'waiting'
                ],
            ];
        @endphp

        @foreach($schedules as $schedule)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold">{{ $schedule['route'] }}</h3>
                        <p class="text-sm opacity-90 mt-1">
                            <i class="fas fa-clock mr-1"></i>{{ $schedule['time'] }}
                            <span class="mx-2">•</span>
                            <i class="fas fa-bus mr-1"></i>{{ $schedule['bus'] }}
                        </p>
                    </div>
                    @if($schedule['status'] == 'boarding')
                        <span class="px-3 py-1 bg-white text-blue-700 text-xs font-bold rounded-full">BOARDING</span>
                    @elseif($schedule['status'] == 'ready')
                        <span class="px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-full">READY</span>
                    @else
                        <span class="px-3 py-1 bg-white/30 text-white text-xs font-bold rounded-full">WAITING</span>
                    @endif
                </div>
            </div>

            <!-- Stats -->
            <div class="p-6">
                <div class="grid grid-cols-3 gap-4 mb-6">
                    <div class="text-center">
                        <p class="text-sm text-gray-600">Kapasitas</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $schedule['capacity'] }}</p>
                    </div>
                    <div class="text-center border-x border-gray-200">
                        <p class="text-sm text-gray-600">Terbooking</p>
                        <p class="text-2xl font-bold text-blue-600 mt-1">{{ $schedule['booked'] }}</p>
                    </div>
                    <div class="text-center">
                        <p class="text-sm text-gray-600">Check-in</p>
                        <p class="text-2xl font-bold text-green-600 mt-1">{{ $schedule['checked_in'] }}</p>
                    </div>
                </div>

                <!-- Progress -->
                <div class="mb-6">
                    <div class="flex items-center justify-between text-sm mb-2">
                        <span class="text-gray-600">Occupancy</span>
                        <span class="font-semibold text-gray-900">{{ round(($schedule['booked']/$schedule['capacity'])*100) }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ ($schedule['booked']/$schedule['capacity'])*100 }}%"></div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex space-x-2">
                    <a href="{{ route('admin.manifest.show', $schedule['id']) }}" 
                       class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-center font-medium transition-colors">
                        <i class="fas fa-eye mr-2"></i>Lihat Manifest
                    </a>
                    <button onclick="printManifest({{ $schedule['id'] }})" 
                            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors">
                        <i class="fas fa-print"></i>
                    </button>
                    <button class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors">
                        <i class="fas fa-download"></i>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Detail Manifest (Example) -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-gray-900">Manifest: Medan → Pematang Siantar • 08:00</h3>
                <p class="text-sm text-gray-600 mt-1">Bus B-1234-ABC • 23 November 2025</p>
            </div>
            <div class="flex items-center space-x-2">
                <button class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm">
                    <i class="fas fa-print mr-2"></i>Print
                </button>
                <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm">
                    <i class="fas fa-file-excel mr-2"></i>Export Excel
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">No</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Kursi</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Nama Penumpang</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">No. Identitas</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Telepon</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Kode Booking</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @php
                        $passengers = [
                            ['seat' => '1A', 'name' => 'John Doe', 'id' => '3201xxxxx', 'phone' => '08123456789', 'booking' => 'BK-001234', 'checked' => true],
                            ['seat' => '1B', 'name' => 'Jane Smith', 'id' => '3202xxxxx', 'phone' => '08234567890', 'booking' => 'BK-001235', 'checked' => true],
                            ['seat' => '2A', 'name' => 'Robert Johnson', 'id' => '3203xxxxx', 'phone' => '08345678901', 'booking' => 'BK-001236', 'checked' => true],
                            ['seat' => '2B', 'name' => 'Sarah Williams', 'id' => '3204xxxxx', 'phone' => '08456789012', 'booking' => 'BK-001237', 'checked' => false],
                            ['seat' => '3A', 'name' => 'Michael Brown', 'id' => '3205xxxxx', 'phone' => '08567890123', 'booking' => 'BK-001238', 'checked' => true],
                        ];
                    @endphp

                    @foreach($passengers as $index => $passenger)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-gray-700">{{ $index + 1 }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 font-semibold rounded">{{ $passenger['seat'] }}</span>
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-900">{{ $passenger['name'] }}</td>
                        <td class="px-6 py-4 text-gray-700 font-mono text-sm">{{ $passenger['id'] }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $passenger['phone'] }}</td>
                        <td class="px-6 py-4 text-blue-600 font-medium">{{ $passenger['booking'] }}</td>
                        <td class="px-6 py-4">
                            @if($passenger['checked'])
                                <span class="px-3 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">
                                    <i class="fas fa-check-circle mr-1"></i>Checked-in
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs font-medium bg-orange-100 text-orange-700 rounded-full">
                                    <i class="fas fa-clock mr-1"></i>Belum Check-in
                                </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Signature Section (for print) -->
        <div class="p-6 bg-gray-50 border-t border-gray-200 print-only hidden">
            <div class="grid grid-cols-3 gap-8 mt-8">
                <div class="text-center">
                    <p class="text-sm text-gray-600 mb-16">Petugas Loket</p>
                    <div class="border-t border-gray-800 pt-2">
                        <p class="text-sm font-semibold">(__________________)</p>
                    </div>
                </div>
                <div class="text-center">
                    <p class="text-sm text-gray-600 mb-16">Sopir</p>
                    <div class="border-t border-gray-800 pt-2">
                        <p class="text-sm font-semibold">(__________________)</p>
                    </div>
                </div>
                <div class="text-center">
                    <p class="text-sm text-gray-600 mb-16">Supervisor</p>
                    <div class="border-t border-gray-800 pt-2">
                        <p class="text-sm font-semibold">(__________________)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
@media print {
    .print-only {
        display: block !important;
    }
    body * {
        visibility: hidden;
    }
    #manifest-print, #manifest-print * {
        visibility: visible;
    }
    #manifest-print {
        position: absolute;
        left: 0;
        top: 0;
    }
}
</style>
@endpush

@push('scripts')
<script>
function printManifest(id) {
    window.print();
}
</script>
@endpush
