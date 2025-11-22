@extends('layouts.app')

@section('title', 'Dashboard - KBT')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Welcome Header -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl shadow-lg p-8 mb-8 text-white">
            <h1 class="text-3xl font-bold mb-2">Selamat Datang, {{ $user->name }}!</h1>
            <p class="text-blue-100">Kelola perjalanan dan pemesanan Anda dengan mudah</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Bookings -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                        <i class="bi bi-ticket-perforated text-3xl text-blue-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Total Pemesanan</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $totalBookings }}</p>
                    </div>
                </div>
            </div>

            <!-- Upcoming Trips -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                        <i class="bi bi-calendar-check text-3xl text-green-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Perjalanan Mendatang</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $upcomingTrips }}</p>
                    </div>
                </div>
            </div>

            <!-- Completed Trips -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-purple-100 rounded-lg p-3">
                        <i class="bi bi-check-circle text-3xl text-purple-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Perjalanan Selesai</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $completedTrips }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <a href="{{ route('search') }}" class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-600 rounded-lg p-4">
                        <i class="bi bi-search text-2xl text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">Pesan Tiket Baru</h3>
                        <p class="text-sm text-gray-500">Cari dan pesan tiket perjalanan Anda</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('ticket.check') }}" class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-600 rounded-lg p-4">
                        <i class="bi bi-qr-code text-2xl text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">Cek E-Ticket</h3>
                        <p class="text-sm text-gray-500">Lihat detail pemesanan Anda</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Recent Bookings -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Pemesanan Terbaru</h2>
                <a href="{{ route('profile.bookings') }}" class="text-blue-600 hover:text-blue-700 font-medium">
                    Lihat Semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            @if($recentBookings->count() > 0)
                <div class="space-y-4">
                    @foreach($recentBookings as $booking)
                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-2 mb-2">
                                    <span class="font-bold text-lg text-gray-900">
                                        {{ $booking->schedule->route->origin_city }} → {{ $booking->schedule->route->destination_city }}
                                    </span>
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'paid' => 'bg-green-100 text-green-800',
                                            'confirmed' => 'bg-blue-100 text-blue-800',
                                            'cancelled' => 'bg-red-100 text-red-800',
                                            'completed' => 'bg-gray-100 text-gray-800',
                                        ];
                                    @endphp
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </div>
                                <div class="flex items-center space-x-4 text-sm text-gray-600">
                                    <span><i class="bi bi-calendar3"></i> {{ \Carbon\Carbon::parse($booking->schedule->departure_date)->format('d M Y') }}</span>
                                    <span><i class="bi bi-clock"></i> {{ \Carbon\Carbon::parse($booking->schedule->departure_time)->format('H:i') }}</span>
                                    <span><i class="bi bi-bus-front"></i> {{ $booking->schedule->bus->bus_type }}</span>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">
                                    Booking Code: <span class="font-mono font-semibold">{{ $booking->booking_code }}</span>
                                </p>
                            </div>
                            <div class="text-right ml-4">
                                <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                                <a href="{{ route('ticket.show', $booking->id) }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium mt-2 inline-block">
                                    Lihat Detail <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <i class="bi bi-ticket-perforated text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Pemesanan</h3>
                    <p class="text-gray-600 mb-6">Mulai perjalanan Anda dengan memesan tiket sekarang!</p>
                    <a href="{{ route('search') }}" class="btn-primary inline-block">
                        <i class="bi bi-search"></i> Cari Tiket
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
