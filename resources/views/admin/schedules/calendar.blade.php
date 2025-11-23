@extends('layouts.admin')

@section('title', 'Kalender Jadwal')
@section('page-title', 'Kalender Jadwal Perjalanan')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Kalender Jadwal</h2>
            <p class="text-gray-600 mt-1">Lihat dan kelola jadwal perjalanan dalam tampilan kalender</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.schedules.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition-colors">
                <i class="fas fa-list mr-2"></i>Tampilan List
            </a>
            <button onclick="openModal('addScheduleModal')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                <i class="fas fa-plus mr-2"></i>Tambah Jadwal
            </button>
        </div>
    </div>

    <!-- Calendar Controls -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <button class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <h3 class="text-xl font-bold text-gray-900">November 2025</h3>
                <button class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="fas fa-chevron-right"></i>
                </button>
                <button class="px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors">
                    Hari Ini
                </button>
            </div>
            
            <div class="flex items-center space-x-3">
                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option>Semua Rute</option>
                    <option>Medan - Pematang Siantar</option>
                    <option>Medan - Rantau Prapat</option>
                    <option>Medan - Sibolga</option>
                    <option>Medan - Berastagi</option>
                </select>
                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option>Semua Bus</option>
                    <option>Bus 001 - Executive</option>
                    <option>Bus 002 - VIP</option>
                    <option>Bus 003 - Economy</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Calendar Grid -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Day Headers -->
        <div class="grid grid-cols-7 border-b border-gray-200">
            @foreach(['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $day)
            <div class="px-4 py-3 text-center text-sm font-semibold text-gray-600 border-r border-gray-200 last:border-r-0">
                {{ $day }}
            </div>
            @endforeach
        </div>

        <!-- Calendar Body -->
        <div class="grid grid-cols-7">
            @php
                // Dummy calendar data for November 2025
                $calendarDays = [
                    // Week 1
                    ['date' => '', 'schedules' => []],
                    ['date' => '', 'schedules' => []],
                    ['date' => '', 'schedules' => []],
                    ['date' => '', 'schedules' => []],
                    ['date' => '', 'schedules' => []],
                    ['date' => '', 'schedules' => []],
                    ['date' => '1', 'schedules' => [
                        ['route' => 'MDN-PST', 'time' => '08:00', 'bus' => 'B001', 'seats' => '35/40'],
                        ['route' => 'MDN-RTP', 'time' => '10:00', 'bus' => 'B002', 'seats' => '28/35'],
                    ]],
                    // Week 2
                    ['date' => '2', 'schedules' => [
                        ['route' => 'MDN-PST', 'time' => '08:00', 'bus' => 'B001', 'seats' => '38/40'],
                    ]],
                    ['date' => '3', 'schedules' => [
                        ['route' => 'MDN-BRS', 'time' => '07:00', 'bus' => 'B005', 'seats' => '22/30'],
                        ['route' => 'MDN-SBG', 'time' => '09:00', 'bus' => 'B003', 'seats' => '25/35'],
                    ]],
                    ['date' => '4', 'schedules' => [
                        ['route' => 'MDN-PST', 'time' => '08:00', 'bus' => 'B001', 'seats' => '32/40'],
                    ]],
                    ['date' => '5', 'schedules' => [
                        ['route' => 'MDN-RTP', 'time' => '10:00', 'bus' => 'B002', 'seats' => '30/35'],
                        ['route' => 'MDN-PST', 'time' => '14:00', 'bus' => 'B004', 'seats' => '18/40'],
                    ]],
                    ['date' => '6', 'schedules' => [
                        ['route' => 'MDN-PST', 'time' => '08:00', 'bus' => 'B001', 'seats' => '35/40'],
                    ]],
                    ['date' => '7', 'schedules' => [
                        ['route' => 'MDN-BRS', 'time' => '07:00', 'bus' => 'B005', 'seats' => '28/30'],
                    ]],
                    ['date' => '8', 'schedules' => [
                        ['route' => 'MDN-PST', 'time' => '08:00', 'bus' => 'B001', 'seats' => '32/40'],
                        ['route' => 'MDN-SBG', 'time' => '09:00', 'bus' => 'B003', 'seats' => '20/35'],
                    ]],
                    // Continue with more days...
                    ['date' => '9', 'schedules' => []],
                    ['date' => '10', 'schedules' => []],
                    ['date' => '11', 'schedules' => []],
                    ['date' => '12', 'schedules' => []],
                    ['date' => '13', 'schedules' => []],
                    ['date' => '14', 'schedules' => []],
                    ['date' => '15', 'schedules' => []],
                    ['date' => '16', 'schedules' => []],
                    ['date' => '17', 'schedules' => []],
                    ['date' => '18', 'schedules' => []],
                    ['date' => '19', 'schedules' => []],
                    ['date' => '20', 'schedules' => []],
                    ['date' => '21', 'schedules' => []],
                    ['date' => '22', 'schedules' => []],
                    ['date' => '23', 'schedules' => [
                        ['route' => 'MDN-PST', 'time' => '08:00', 'bus' => 'B001', 'seats' => '40/40', 'full' => true],
                        ['route' => 'MDN-RTP', 'time' => '10:00', 'bus' => 'B002', 'seats' => '28/35'],
                        ['route' => 'MDN-BRS', 'time' => '07:00', 'bus' => 'B005', 'seats' => '25/30'],
                    ]],
                    ['date' => '24', 'schedules' => []],
                    ['date' => '25', 'schedules' => []],
                    ['date' => '26', 'schedules' => []],
                    ['date' => '27', 'schedules' => []],
                    ['date' => '28', 'schedules' => []],
                    ['date' => '29', 'schedules' => []],
                    ['date' => '30', 'schedules' => []],
                ];
            @endphp

            @foreach($calendarDays as $day)
            <div class="min-h-[120px] border-r border-b border-gray-200 last:border-r-0 p-2 {{ $day['date'] == '' ? 'bg-gray-50' : '' }} {{ $day['date'] == '23' ? 'bg-blue-50' : '' }}">
                @if($day['date'] != '')
                    <div class="font-semibold text-gray-900 mb-2">{{ $day['date'] }}</div>
                    
                    @foreach($day['schedules'] as $schedule)
                    <div class="mb-1 p-1.5 rounded text-xs {{ isset($schedule['full']) && $schedule['full'] ? 'bg-red-100 border border-red-300' : 'bg-green-100 border border-green-300' }} cursor-pointer hover:shadow-sm transition-shadow" onclick="viewScheduleDetail('{{ $day['date'] }}', '{{ $schedule['route'] }}')">
                        <div class="font-semibold text-gray-900">{{ $schedule['route'] }}</div>
                        <div class="text-gray-600">{{ $schedule['time'] }} - {{ $schedule['bus'] }}</div>
                        <div class="text-gray-600">{{ $schedule['seats'] }}</div>
                    </div>
                    @endforeach

                    @if(count($day['schedules']) > 3)
                    <button class="text-xs text-blue-600 hover:text-blue-800 mt-1">
                        +{{ count($day['schedules']) - 3 }} lainnya
                    </button>
                    @endif
                @endif
            </div>
            @endforeach
        </div>
    </div>

    <!-- Legend -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-sm font-semibold text-gray-900 mb-3">Keterangan:</h3>
        <div class="flex items-center space-x-6">
            <div class="flex items-center">
                <div class="w-4 h-4 bg-blue-50 border border-blue-300 rounded mr-2"></div>
                <span class="text-sm text-gray-600">Hari Ini</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 bg-green-100 border border-green-300 rounded mr-2"></div>
                <span class="text-sm text-gray-600">Jadwal Tersedia</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 bg-red-100 border border-red-300 rounded mr-2"></div>
                <span class="text-sm text-gray-600">Penuh / Full Booked</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 bg-gray-50 border border-gray-300 rounded mr-2"></div>
                <span class="text-sm text-gray-600">Tidak Ada Jadwal</span>
            </div>
        </div>
    </div>

    <!-- Stats Summary -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Jadwal Bulan Ini</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">342</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Rata-rata Occupancy</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">78%</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Full Booked</p>
                    <p class="text-3xl font-bold text-red-600 mt-2">45</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-red-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Kursi Tersedia</p>
                    <p class="text-3xl font-bold text-purple-600 mt-2">1,234</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chair text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Schedule Modal -->
<div id="addScheduleModal" data-modal="overlay" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0, 0, 0, 0.5); z-index: 9999; padding: 1rem; overflow-y: auto;">
    <div class="bg-white rounded-xl max-w-2xl w-full mx-auto my-8">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900">Tambah Jadwal Baru</h3>
                <button onclick="closeModal('addScheduleModal')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        
        <form class="p-6 space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rute</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option>Pilih Rute</option>
                        <option>Medan - Pematang Siantar</option>
                        <option>Medan - Rantau Prapat</option>
                        <option>Medan - Sibolga</option>
                        <option>Medan - Berastagi</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Bus</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option>Pilih Bus</option>
                        <option>Bus 001 - Executive (40 kursi)</option>
                        <option>Bus 002 - VIP (35 kursi)</option>
                        <option>Bus 003 - Economy (45 kursi)</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                    <input type="date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jam Keberangkatan</label>
                    <input type="time" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Harga Tiket (Rp)</label>
                <input type="number" placeholder="75000" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200">
                <button type="button" onclick="closeModal('addScheduleModal')" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                    <i class="fas fa-save mr-2"></i>Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openModal(id) {
    const modal = document.getElementById(id);
    modal.style.display = 'flex';
    modal.style.alignItems = 'center';
    modal.style.justifyContent = 'center';
}

function closeModal(id) {
    document.getElementById(id).style.display = 'none';
}

function viewScheduleDetail(date, route) {
    alert('Detail jadwal: ' + date + ' November - ' + route);
    // TODO: Implement detail view
}
</script>
@endpush
