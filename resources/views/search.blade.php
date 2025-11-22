@extends('layouts.app')

@section('title', 'Cari Jadwal - KBT')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Search Header -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <form action="{{ route('search') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dari</label>
                    <select name="origin" class="input-field">
                        <option value="">Semua</option>
                        @foreach($cities as $city)
                            <option value="{{ $city }}" {{ request('origin') == $city ? 'selected' : '' }}>
                                {{ $city }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ke</label>
                    <select name="destination" class="input-field">
                        <option value="">Semua</option>
                        @foreach($cities as $city)
                            <option value="{{ $city }}" {{ request('destination') == $city ? 'selected' : '' }}>
                                {{ $city }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                    <input type="date" name="date" value="{{ request('date', date('Y-m-d')) }}" class="input-field">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                    <select name="sort" class="input-field">
                        <option value="">Default</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Termurah</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Termahal</option>
                        <option value="time" {{ request('sort') == 'time' ? 'selected' : '' }}>Waktu Keberangkatan</option>
                    </select>
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="w-full btn-primary">
                        <i class="bi bi-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Results -->
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900">
                Ditemukan {{ $schedules->total() }} jadwal
            </h2>
        </div>
        
        @forelse($schedules as $schedule)
        <div class="bg-white rounded-xl shadow-md p-6 mb-4 hover:shadow-lg transition duration-300">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center">
                <!-- Bus Info -->
                <div class="md:col-span-3">
                    <div class="flex items-center space-x-3">
                        <div class="bg-blue-100 rounded-lg p-3">
                            <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900">{{ $schedule->bus->bus_type }}</p>
                            <p class="text-sm text-gray-500">{{ $schedule->bus->plate_number }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Route & Time -->
                <div class="md:col-span-5">
                    <div class="flex items-center justify-between">
                        <div class="text-center">
                            <p class="text-2xl font-bold text-gray-900">
                                {{ \Carbon\Carbon::parse($schedule->departure_time)->format('H:i') }}
                            </p>
                            <p class="text-sm text-gray-600">{{ $schedule->route->origin_city }}</p>
                            <p class="text-xs text-gray-500">{{ $schedule->route->origin_terminal }}</p>
                        </div>
                        
                        <div class="flex-1 px-4">
                            <div class="relative">
                                <div class="border-t-2 border-gray-300"></div>
                                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white px-2">
                                    <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 text-center mt-1">
                                {{ $schedule->route->estimated_duration_minutes }} menit
                            </p>
                        </div>
                        
                        <div class="text-center">
                            <p class="text-2xl font-bold text-gray-900">
                                {{ \Carbon\Carbon::parse($schedule->estimated_arrival_time)->format('H:i') }}
                            </p>
                            <p class="text-sm text-gray-600">{{ $schedule->route->destination_city }}</p>
                            <p class="text-xs text-gray-500">{{ $schedule->route->destination_terminal }}</p>
                        </div>
                    </div>
                    
                    <!-- Facilities -->
                    <div class="flex items-center space-x-4 mt-3 text-xs text-gray-600">
                        <span><i class="bi bi-snow"></i> AC</span>
                        <span><i class="bi bi-wifi"></i> WiFi</span>
                        <span><i class="bi bi-usb-symbol"></i> USB Port</span>
                    </div>
                </div>
                
                <!-- Price & Seats -->
                <div class="md:col-span-4 text-center md:text-right">
                    <div class="mb-2">
                        <span class="text-sm text-gray-500">Kursi Tersedia</span>
                        <p class="text-lg font-semibold text-green-600">
                            {{ $schedule->available_seats }} / {{ $schedule->bus->total_seats }}
                        </p>
                    </div>
                    
                    <div class="mb-3">
                        <span class="text-sm text-gray-500">Harga/kursi</span>
                        <p class="text-3xl font-bold text-blue-600">
                            Rp {{ number_format($schedule->price, 0, ',', '.') }}
                        </p>
                    </div>
                    
                    @if($schedule->available_seats > 0)
                        <a href="{{ route('booking.seats', $schedule->id) }}" 
                           class="inline-block w-full btn-primary">
                            Pilih Kursi →
                        </a>
                    @else
                        <button disabled class="w-full px-6 py-3 bg-gray-300 text-gray-500 font-semibold rounded-lg cursor-not-allowed">
                            Penuh
                        </button>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-xl shadow-md p-12 text-center">
            <div class="text-6xl mb-4 text-gray-400"><i class="bi bi-calendar-x"></i></div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Tidak Ada Jadwal Tersedia</h3>
            <p class="text-gray-600 mb-6">Maaf, tidak ada jadwal yang sesuai dengan pencarian Anda.</p>
            <a href="{{ route('home') }}" class="btn-primary inline-block">
                ← Kembali ke Beranda
            </a>
        </div>
        @endforelse
        
        <!-- Pagination -->
        @if($schedules->hasPages())
        <div class="mt-8">
            {{ $schedules->links() }}
        </div>
        @endif
        
    </div>
</div>
@endsection
