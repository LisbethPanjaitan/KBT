@extends('layouts.app')

@section('title', 'Pesanan Saya - KBT')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Pesanan Saya</h1>

        <!-- Filter -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <form method="GET" class="flex items-center space-x-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Filter Status</label>
                    <select name="status" class="input-field" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
            </form>
        </div>

        <!-- Bookings List -->
        @if($bookings->count() > 0)
            <div class="space-y-4">
                @foreach($bookings as $booking)
                <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-1">
                                {{ $booking->schedule->route->origin_city }} → {{ $booking->schedule->route->destination_city }}
                            </h3>
                            <p class="text-sm text-gray-500">Booking Code: <span class="font-mono font-semibold">{{ $booking->booking_code }}</span></p>
                        </div>
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'paid' => 'bg-green-100 text-green-800',
                                'confirmed' => 'bg-blue-100 text-blue-800',
                                'cancelled' => 'bg-red-100 text-red-800',
                                'completed' => 'bg-gray-100 text-gray-800',
                            ];
                        @endphp
                        <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-gray-500">Tanggal Keberangkatan</p>
                            <p class="font-semibold">{{ \Carbon\Carbon::parse($booking->schedule->departure_date)->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Waktu</p>
                            <p class="font-semibold">{{ \Carbon\Carbon::parse($booking->schedule->departure_time)->format('H:i') }} WIB</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Bus</p>
                            <p class="font-semibold">{{ $booking->schedule->bus->bus_type }} - {{ $booking->schedule->bus->plate_number }}</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between border-t pt-4">
                        <div>
                            <p class="text-sm text-gray-500">Total Pembayaran</p>
                            <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('ticket.show', $booking->id) }}" class="btn-primary">
                                <i class="bi bi-eye"></i> Lihat Detail
                            </a>
                            @if($booking->status === 'pending')
                            <button class="bg-red-100 text-red-700 px-4 py-2 rounded-lg font-medium hover:bg-red-200 transition">
                                <i class="bi bi-x-circle"></i> Batalkan
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $bookings->links() }}
            </div>
        @else
            <div class="bg-white rounded-xl shadow-md p-12 text-center">
                <i class="bi bi-ticket-perforated text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Belum Ada Pemesanan</h3>
                <p class="text-gray-600 mb-6">Mulai perjalanan Anda dengan memesan tiket sekarang!</p>
                <a href="{{ route('search') }}" class="btn-primary inline-block">
                    <i class="bi bi-search"></i> Cari Tiket
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
