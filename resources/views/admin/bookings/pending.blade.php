@extends('layouts.admin')

@section('title', 'Booking Pending')
@section('page-title', 'Booking Menunggu Konfirmasi')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Booking Pending</h2>
            <p class="text-gray-600 mt-1">Daftar booking yang menunggu konfirmasi pembayaran</p>
        </div>
        <a href="{{ route('admin.bookings.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-lg flex items-center font-medium transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Semua Booking
        </a>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Pending</p>
                    <p class="text-3xl font-bold text-orange-600 mt-2">23</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Akan Expired</p>
                    <p class="text-3xl font-bold text-red-600 mt-2">8</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">< 1 jam lagi</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Nilai</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">Rp 34.5jt</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Hari Ini</p>
                    <p class="text-3xl font-bold text-purple-600 mt-2">15</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-day text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <input type="text" placeholder="Cari kode booking..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div>
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option>Semua Rute</option>
                    <option>Medan - Pematang Siantar</option>
                    <option>Medan - Rantau Prapat</option>
                    <option>Medan - Sibolga</option>
                    <option>Medan - Padang Sidempuan</option>
                </select>
            </div>
            <div>
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option>Semua Waktu</option>
                    <option>Hari Ini</option>
                    <option>Besok</option>
                    <option>Minggu Ini</option>
                </select>
            </div>
            <div>
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option>Semua Status</option>
                    <option>Normal</option>
                    <option>Akan Expired</option>
                </select>
            </div>
            <div>
                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-search mr-2"></i>Cari
                </button>
            </div>
        </div>
    </div>

    <!-- Pending Bookings Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kode Booking</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Penumpang</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Rute</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Expired</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @php
                        $pendingBookings = [
                            ['code' => 'KBT20251123001', 'name' => 'Ahmad Rizki', 'email' => 'ahmad@email.com', 'route' => 'Medan - Pematang Siantar', 'date' => '24 Nov 2025, 08:00', 'total' => 'Rp 250.000', 'seats' => 2, 'expired' => '45 menit', 'urgent' => false],
                            ['code' => 'KBT20251123002', 'name' => 'Siti Nurhaliza', 'email' => 'siti@email.com', 'route' => 'Medan - Rantau Prapat', 'date' => '24 Nov 2025, 10:00', 'total' => 'Rp 180.000', 'seats' => 1, 'expired' => '15 menit', 'urgent' => true],
                            ['code' => 'KBT20251123003', 'name' => 'Budi Santoso', 'email' => 'budi@email.com', 'route' => 'Medan - Sibolga', 'date' => '24 Nov 2025, 14:00', 'total' => 'Rp 420.000', 'seats' => 3, 'expired' => '1 jam 20 menit', 'urgent' => false],
                            ['code' => 'KBT20251123004', 'name' => 'Dewi Lestari', 'email' => 'dewi@email.com', 'route' => 'Medan - Berastagi', 'date' => '25 Nov 2025, 07:00', 'total' => 'Rp 100.000', 'seats' => 1, 'expired' => '30 menit', 'urgent' => true],
                        ];
                    @endphp

                    @foreach($pendingBookings as $booking)
                    <tr class="hover:bg-gray-50 transition-colors {{ $booking['urgent'] ? 'bg-red-50' : '' }}">
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-semibold text-gray-900">{{ $booking['code'] }}</p>
                                <p class="text-xs text-gray-500">{{ $booking['seats'] }} kursi</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-medium text-gray-900">{{ $booking['name'] }}</p>
                                <p class="text-sm text-gray-500">{{ $booking['email'] }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-900">{{ $booking['route'] }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-900">{{ $booking['date'] }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-semibold text-gray-900">{{ $booking['total'] }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-medium rounded-full {{ $booking['urgent'] ? 'bg-red-100 text-red-700' : 'bg-orange-100 text-orange-700' }}">
                                <i class="fas fa-clock mr-1"></i>{{ $booking['expired'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <button onclick="confirmBooking('{{ $booking['code'] }}')" 
                                        class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors" 
                                        title="Konfirmasi Pembayaran">
                                    <i class="fas fa-check-circle"></i>
                                </button>
                                <button onclick="viewBooking('{{ $booking['code'] }}')" 
                                        class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" 
                                        title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button onclick="cancelBooking('{{ $booking['code'] }}')" 
                                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" 
                                        title="Batalkan">
                                    <i class="fas fa-times-circle"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
            <p class="text-sm text-gray-600">Menampilkan 1-4 dari 23 booking pending</p>
            <div class="flex items-center space-x-2">
                <button class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">1</button>
                <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">2</button>
                <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">3</button>
                <button class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmBooking(code) {
    if(confirm('Konfirmasi pembayaran untuk booking ' + code + '?')) {
        alert('Pembayaran berhasil dikonfirmasi!');
        // TODO: Implement actual confirmation logic
    }
}

function viewBooking(code) {
    window.location.href = '/admin/bookings/' + code;
}

function cancelBooking(code) {
    if(confirm('Yakin ingin membatalkan booking ' + code + '?')) {
        alert('Booking berhasil dibatalkan!');
        // TODO: Implement actual cancellation logic
    }
}

// Auto refresh every 30 seconds to update expired time
setInterval(function() {
    location.reload();
}, 30000);
</script>
@endpush
