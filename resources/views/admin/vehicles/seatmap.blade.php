@extends('layouts.admin')

@section('title', 'Editor Seat Map')
@section('page-title', 'Editor Peta Kursi Bus')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Editor Seat Map</h2>
            <p class="text-gray-600 mt-1">Atur dan kelola tata letak kursi untuk setiap tipe bus</p>
        </div>
        <a href="{{ route('admin.vehicles.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-lg flex items-center font-medium transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Daftar Bus
        </a>
    </div>

    <!-- Bus Selector -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Bus</label>
                <select id="busSelector" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option>Bus 001 - Executive (40 kursi)</option>
                    <option>Bus 002 - VIP (35 kursi)</option>
                    <option>Bus 003 - Economy (45 kursi)</option>
                    <option>Bus 004 - Sleeper (28 kursi)</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Konfigurasi</label>
                <select id="layoutType" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option>2-2 (4 kursi per baris)</option>
                    <option>2-1 (3 kursi per baris)</option>
                    <option>2-3 (5 kursi per baris)</option>
                    <option>Sleeper 1-1</option>
                </select>
            </div>
            <div class="flex items-end">
                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-sync-alt mr-2"></i>Load Seat Map
                </button>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Seat Map Editor -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-900">Tata Letak Kursi</h3>
                    <div class="flex items-center space-x-2">
                        <button class="px-3 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors text-sm">
                            <i class="fas fa-plus mr-1"></i>Tambah Baris
                        </button>
                        <button class="px-3 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors text-sm">
                            <i class="fas fa-minus mr-1"></i>Hapus Baris
                        </button>
                    </div>
                </div>

                <!-- Bus Outline -->
                <div class="border-2 border-gray-300 rounded-2xl p-6 bg-gray-50">
                    <!-- Driver Section -->
                    <div class="mb-6 pb-4 border-b-2 border-gray-300">
                        <div class="flex items-center justify-between">
                            <div class="w-16 h-16 bg-blue-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-steering-wheel text-white text-2xl"></i>
                            </div>
                            <div class="text-sm text-gray-600 font-medium">Area Supir</div>
                            <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                <i class="fas fa-door-open text-gray-600 text-2xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Seat Rows -->
                    <div class="space-y-3">
                        @php
                            $rows = 10;
                            $seatsPerRow = 4; // 2-2 configuration
                        @endphp

                        @for($row = 1; $row <= $rows; $row++)
                        <div class="flex items-center justify-between">
                            <!-- Left Side (2 seats) -->
                            <div class="flex space-x-2">
                                @for($seat = 1; $seat <= 2; $seat++)
                                    @php
                                        $seatNumber = (($row - 1) * 4) + $seat;
                                        $isReserved = in_array($seatNumber, [1, 5, 13, 21]); // Some seats reserved
                                    @endphp
                                    <button class="w-12 h-12 rounded-lg flex items-center justify-center font-semibold text-sm transition-all {{ $isReserved ? 'bg-red-100 text-red-700 border-2 border-red-300' : 'bg-green-100 text-green-700 border-2 border-green-300 hover:bg-green-200' }}" 
                                            onclick="toggleSeat({{ $seatNumber }})">
                                        {{ $seatNumber }}
                                    </button>
                                @endfor
                            </div>

                            <!-- Aisle -->
                            <div class="text-gray-400 text-xs font-medium px-2">{{ $row }}</div>

                            <!-- Right Side (2 seats) -->
                            <div class="flex space-x-2">
                                @for($seat = 3; $seat <= 4; $seat++)
                                    @php
                                        $seatNumber = (($row - 1) * 4) + $seat;
                                        $isReserved = in_array($seatNumber, [7, 11, 19, 27]);
                                    @endphp
                                    <button class="w-12 h-12 rounded-lg flex items-center justify-center font-semibold text-sm transition-all {{ $isReserved ? 'bg-red-100 text-red-700 border-2 border-red-300' : 'bg-green-100 text-green-700 border-2 border-green-300 hover:bg-green-200' }}" 
                                            onclick="toggleSeat({{ $seatNumber }})">
                                        {{ $seatNumber }}
                                    </button>
                                @endfor
                            </div>
                        </div>
                        @endfor
                    </div>

                    <!-- Back Section -->
                    <div class="mt-6 pt-4 border-t-2 border-gray-300 text-center">
                        <div class="text-sm text-gray-600 font-medium">Area Belakang</div>
                        <div class="mt-2 flex justify-center space-x-2">
                            <div class="w-16 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                <i class="fas fa-toilet text-gray-600"></i>
                            </div>
                            <div class="w-16 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                <i class="fas fa-door-closed text-gray-600"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="mt-6 flex justify-end space-x-3">
                    <button class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        Reset
                    </button>
                    <button class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                        <i class="fas fa-save mr-2"></i>Simpan Konfigurasi
                    </button>
                </div>
            </div>
        </div>

        <!-- Side Panel -->
        <div class="space-y-6">
            <!-- Legend -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Keterangan</h3>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-green-100 border-2 border-green-300 rounded-lg mr-3"></div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Tersedia</p>
                            <p class="text-xs text-gray-500">Kursi dapat dipesan</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-red-100 border-2 border-red-300 rounded-lg mr-3"></div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Tidak Tersedia</p>
                            <p class="text-xs text-gray-500">Kursi rusak/reserved</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gray-200 border-2 border-gray-300 rounded-lg mr-3"></div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Kosong</p>
                            <p class="text-xs text-gray-500">Tidak ada kursi</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Statistik Kursi</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Total Kursi</span>
                        <span class="text-lg font-bold text-gray-900">40</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Tersedia</span>
                        <span class="text-lg font-bold text-green-600">32</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Tidak Tersedia</span>
                        <span class="text-lg font-bold text-red-600">8</span>
                    </div>
                    <div class="pt-3 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Occupancy Rate</span>
                            <span class="text-lg font-bold text-blue-600">80%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Seat Properties -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Properti Kursi</h3>
                <p class="text-sm text-gray-500 mb-4">Klik kursi untuk mengatur properti</p>
                
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Kursi</label>
                        <input type="text" value="-" disabled class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option>Tersedia</option>
                            <option>Tidak Tersedia</option>
                            <option>Reserved</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipe</label>
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option>Standard</option>
                            <option>VIP</option>
                            <option>Premium</option>
                        </select>
                    </div>
                    <div>
                        <label class="flex items-center mt-3">
                            <input type="checkbox" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Window Seat</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Template Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Template</h3>
                <div class="space-y-2">
                    <button class="w-full px-4 py-2 bg-purple-100 text-purple-700 rounded-lg hover:bg-purple-200 transition-colors text-sm">
                        <i class="fas fa-save mr-2"></i>Simpan sebagai Template
                    </button>
                    <button class="w-full px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors text-sm">
                        <i class="fas fa-download mr-2"></i>Load dari Template
                    </button>
                    <button class="w-full px-4 py-2 bg-orange-100 text-orange-700 rounded-lg hover:bg-orange-200 transition-colors text-sm">
                        <i class="fas fa-copy mr-2"></i>Duplikat Layout
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let selectedSeat = null;

function toggleSeat(seatNumber) {
    selectedSeat = seatNumber;
    console.log('Selected seat:', seatNumber);
    
    // Update the seat properties panel
    document.querySelector('input[type="text"][disabled]').value = seatNumber;
    
    // Toggle seat availability (this would normally update via backend)
    const seatBtn = event.target;
    if (seatBtn.classList.contains('bg-green-100')) {
        seatBtn.classList.remove('bg-green-100', 'text-green-700', 'border-green-300');
        seatBtn.classList.add('bg-red-100', 'text-red-700', 'border-red-300');
    } else {
        seatBtn.classList.remove('bg-red-100', 'text-red-700', 'border-red-300');
        seatBtn.classList.add('bg-green-100', 'text-green-700', 'border-green-300');
    }
    
    updateStatistics();
}

function updateStatistics() {
    // Count available and unavailable seats
    const availableSeats = document.querySelectorAll('.bg-green-100').length;
    const unavailableSeats = document.querySelectorAll('.bg-red-100').length;
    const totalSeats = availableSeats + unavailableSeats;
    
    // Update the statistics display
    // This would normally be done more elegantly with proper selectors
    console.log(`Available: ${availableSeats}, Unavailable: ${unavailableSeats}, Total: ${totalSeats}`);
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    updateStatistics();
});
</script>
@endpush
