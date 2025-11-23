@extends('layouts.admin')

@section('title', 'Kelola Pemesanan')
@section('page-title', 'Kelola Pemesanan')

@section('content')
<div class="space-y-6">
    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <p class="text-sm text-gray-600">Total Pemesanan</p>
            <p class="text-2xl font-bold text-gray-900 mt-1">2,458</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <p class="text-sm text-gray-600">Confirmed</p>
            <p class="text-2xl font-bold text-green-600 mt-1">1,892</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <p class="text-sm text-gray-600">Pending</p>
            <p class="text-2xl font-bold text-orange-600 mt-1">342</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <p class="text-sm text-gray-600">Cancelled</p>
            <p class="text-2xl font-bold text-red-600 mt-1">187</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <p class="text-sm text-gray-600">Refunded</p>
            <p class="text-2xl font-bold text-purple-600 mt-1">37</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div class="md:col-span-2">
                <input type="text" placeholder="Cari kode booking, nama, telepon..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option>Semua Status</option>
                    <option>Confirmed</option>
                    <option>Pending Payment</option>
                    <option>Cancelled</option>
                    <option>Refunded</option>
                </select>
            </div>
            <div>
                <input type="date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-search mr-2"></i>Cari
                </button>
            </div>
        </div>
    </div>

    <!-- Bookings Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Kode Booking</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Penumpang</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Rute & Jadwal</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Kursi</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Total</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @php
                        $bookings = [
                            ['code' => 'BK-2025-001234', 'passenger' => 'John Doe', 'phone' => '08123456789', 'route' => 'Medan → Pematang Siantar', 'date' => '23 Nov 2025, 08:00', 'seats' => '12, 13', 'total' => 150000, 'status' => 'confirmed', 'payment' => 'Tunai'],
                            ['code' => 'BK-2025-001235', 'passenger' => 'Jane Smith', 'phone' => '08234567890', 'route' => 'Medan → Rantau Prapat', 'date' => '23 Nov 2025, 10:00', 'seats' => '5', 'total' => 95000, 'status' => 'pending', 'payment' => 'Transfer'],
                            ['code' => 'BK-2025-001236', 'passenger' => 'Robert Johnson', 'phone' => '08345678901', 'route' => 'Pematang Siantar → Medan', 'date' => '24 Nov 2025, 14:00', 'seats' => '8, 9, 10', 'total' => 225000, 'status' => 'confirmed', 'payment' => 'QRIS'],
                            ['code' => 'BK-2025-001237', 'passenger' => 'Sarah Williams', 'phone' => '08456789012', 'route' => 'Medan → Sibolga', 'date' => '25 Nov 2025, 06:00', 'seats' => '1', 'total' => 180000, 'status' => 'cancelled', 'payment' => 'Transfer'],
                        ];
                    @endphp

                    @foreach($bookings as $booking)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.bookings.show', 1) }}" class="font-semibold text-blue-600 hover:text-blue-700">
                                {{ $booking['code'] }}
                            </a>
                            <p class="text-xs text-gray-500 mt-1">{{ $booking['payment'] }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-semibold text-gray-900">{{ $booking['passenger'] }}</p>
                            <p class="text-sm text-gray-500">{{ $booking['phone'] }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-semibold text-gray-900">{{ $booking['route'] }}</p>
                            <p class="text-sm text-gray-500">{{ $booking['date'] }}</p>
                        </td>
                        <td class="px-6 py-4 text-gray-700">
                            {{ $booking['seats'] }}
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-900">
                            Rp {{ number_format($booking['total'], 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($booking['status'] == 'confirmed')
                                <span class="px-3 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">Confirmed</span>
                            @elseif($booking['status'] == 'pending')
                                <span class="px-3 py-1 text-xs font-medium bg-orange-100 text-orange-700 rounded-full">Pending</span>
                            @else
                                <span class="px-3 py-1 text-xs font-medium bg-red-100 text-red-700 rounded-full">Cancelled</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="p-2 text-green-600 hover:bg-green-50 rounded-lg" title="Print">
                                    <i class="fas fa-print"></i>
                                </button>
                                @if($booking['status'] == 'pending')
                                <button class="p-2 text-purple-600 hover:bg-purple-50 rounded-lg" title="Confirm">
                                    <i class="fas fa-check-circle"></i>
                                </button>
                                @endif
                                <button class="p-2 text-red-600 hover:bg-red-50 rounded-lg" title="Cancel">
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
            <p class="text-sm text-gray-600">Menampilkan 1-10 dari 2,458 pemesanan</p>
            <div class="flex items-center space-x-2">
                <button class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">1</button>
                <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">2</button>
                <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">3</button>
                <button class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
