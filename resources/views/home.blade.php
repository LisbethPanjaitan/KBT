@extends('layouts.app')

@section('title', 'KBT - Pemesanan Tiket Minibus Online')

@section('content')
<!-- Hero Section -->
<div class="relative bg-gradient-to-r from-blue-600 to-blue-800 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                <i class="bi bi-bus-front"></i> Pesan Tiket Minibus KBT Online
            </h1>
            <p class="text-xl md:text-2xl text-blue-100">
                Mudah, Cepat, dan Terpercaya
            </p>
        </div>
        
        <!-- Search Form -->
        <div class="max-w-4xl mx-auto">
            <form action="{{ route('search') }}" method="GET" class="bg-white rounded-2xl shadow-2xl p-6 md:p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Origin -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="bi bi-geo-alt-fill text-blue-600"></i> Dari
                        </label>
                        <select name="origin" required class="input-field">
                            <option value="">Pilih Kota Asal</option>
                            <option value="Medan">Medan</option>
                            <option value="Berastagi">Berastagi</option>
                            <option value="Kabanjahe">Kabanjahe</option>
                            <option value="Pematang Siantar">Pematang Siantar</option>
                        </select>
                    </div>
                    
                    <!-- Destination -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="bi bi-geo-alt-fill text-red-600"></i> Ke
                        </label>
                        <select name="destination" required class="input-field">
                            <option value="">Pilih Kota Tujuan</option>
                            <option value="Medan">Medan</option>
                            <option value="Berastagi">Berastagi</option>
                            <option value="Kabanjahe">Kabanjahe</option>
                            <option value="Pematang Siantar">Pematang Siantar</option>
                        </select>
                    </div>
                    
                    <!-- Date -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="bi bi-calendar-event text-green-600"></i> Tanggal
                        </label>
                        <input type="date" name="date" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required class="input-field">
                    </div>
                    
                    <!-- Submit -->
                    <div class="flex items-end">
                        <button type="submit" class="w-full btn-primary">
                            <i class="bi bi-search"></i> Cari Tiket
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Wave Shape -->
    <div class="absolute bottom-0 w-full">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 0L60 10C120 20 240 40 360 46.7C480 53 600 47 720 43.3C840 40 960 40 1080 46.7C1200 53 1320 67 1380 73.3L1440 80V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0V0Z" fill="rgb(249, 250, 251)"/>
        </svg>
    </div>
</div>

<!-- Popular Routes Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Rute Populer</h2>
        <p class="text-gray-600">Pilih rute favorit Anda</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($popularRoutes as $route)
        <div class="card p-6 hover:scale-105 transform transition duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-2">
                    <i class="bi bi-bus-front text-2xl text-blue-600"></i>
                    <span class="font-bold text-lg text-gray-800">{{ $route->origin_city }}</span>
                </div>
                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
                <div class="flex items-center space-x-2">
                    <span class="font-bold text-lg text-gray-800">{{ $route->destination_city }}</span>
                    <i class="bi bi-geo-alt-fill text-2xl text-red-600"></i>
                </div>
            </div>
            
            <div class="space-y-2 text-sm text-gray-600">
                <div class="flex items-center">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ $route->estimated_duration_minutes }} menit</span>
                </div>
                <div class="flex items-center">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>{{ $route->distance_km }} km</span>
                </div>
            </div>
            
            <div class="mt-4 pt-4 border-t border-gray-200 flex items-center justify-between">
                <div>
                    <span class="text-sm text-gray-500">Mulai dari</span>
                    <p class="text-2xl font-bold text-blue-600">
                        Rp {{ number_format($route->base_price, 0, ',', '.') }}
                    </p>
                </div>
                <a href="{{ route('search', ['origin' => $route->origin_city, 'destination' => $route->destination_city]) }}" 
                   class="btn-primary text-sm px-4 py-2">
                    Pesan
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-12">
            <p class="text-gray-500">Belum ada rute tersedia. Silakan hubungi admin.</p>
        </div>
        @endforelse
    </div>
</section>

<!-- How It Works Section -->
<section class="bg-gray-100 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Cara Pesan Tiket</h2>
            <p class="text-gray-600">Mudah dan cepat dalam 4 langkah</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Step 1 -->
            <div class="text-center">
                <div class="bg-blue-600 text-white rounded-full h-16 w-16 flex items-center justify-center text-2xl font-bold mx-auto mb-4">
                    1
                </div>
                <h3 class="text-xl font-semibold mb-2">Pilih Rute</h3>
                <p class="text-gray-600">Cari dan pilih rute perjalanan Anda</p>
            </div>
            
            <!-- Step 2 -->
            <div class="text-center">
                <div class="bg-blue-600 text-white rounded-full h-16 w-16 flex items-center justify-center text-2xl font-bold mx-auto mb-4">
                    2
                </div>
                <h3 class="text-xl font-semibold mb-2">Pilih Kursi</h3>
                <p class="text-gray-600">Pilih kursi favorit Anda di seat map</p>
            </div>
            
            <!-- Step 3 -->
            <div class="text-center">
                <div class="bg-blue-600 text-white rounded-full h-16 w-16 flex items-center justify-center text-2xl font-bold mx-auto mb-4">
                    3
                </div>
                <h3 class="text-xl font-semibold mb-2">Bayar</h3>
                <p class="text-gray-600">Pilih metode pembayaran yang Anda inginkan</p>
            </div>
            
            <!-- Step 4 -->
            <div class="text-center">
                <div class="bg-blue-600 text-white rounded-full h-16 w-16 flex items-center justify-center text-2xl font-bold mx-auto mb-4">
                    4
                </div>
                <h3 class="text-xl font-semibold mb-2">E-Ticket</h3>
                <p class="text-gray-600">Dapatkan e-ticket dengan QR code</p>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Mengapa Memilih KBT?</h2>
        <p class="text-gray-600">Keunggulan layanan kami</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="text-center p-6">
            <div class="text-5xl mb-4 text-yellow-500"><i class="bi bi-lightning-charge-fill"></i></div>
            <h3 class="text-xl font-semibold mb-2">Booking Cepat</h3>
            <p class="text-gray-600">Proses pemesanan hanya dalam hitungan menit</p>
        </div>
        
        <div class="text-center p-6">
            <div class="text-5xl mb-4 text-green-600"><i class="bi bi-credit-card-fill"></i></div>
            <h3 class="text-xl font-semibold mb-2">Pembayaran Mudah</h3>
            <p class="text-gray-600">Berbagai metode pembayaran tersedia</p>
        </div>
        
        <div class="text-center p-6">
            <div class="text-5xl mb-4 text-blue-600"><i class="bi bi-check-circle-fill"></i></div>
            <h3 class="text-xl font-semibold mb-2">Terpercaya</h3>
            <p class="text-gray-600">Armada terawat dan sopir berpengalaman</p>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="bg-blue-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Testimoni Pelanggan</h2>
            <p class="text-gray-600">Apa kata mereka tentang KBT</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white rounded-xl p-6 shadow-md">
                <div class="flex items-center mb-4">
                    <div class="text-yellow-400 text-xl">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                </div>
                <p class="text-gray-600 mb-4">"Sangat mudah dan cepat! Tidak perlu antri di loket lagi. Recommended!"</p>
                <div class="flex items-center">
                    <div class="h-10 w-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                        B
                    </div>
                    <div class="ml-3">
                        <p class="font-semibold">Budi Santoso</p>
                        <p class="text-sm text-gray-500">Medan</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-md">
                <div class="flex items-center mb-4">
                    <div class="text-yellow-400 text-xl">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                </div>
                <p class="text-gray-600 mb-4">"Bus nyaman, pelayanan bagus. Website-nya juga user-friendly."</p>
                <div class="flex items-center">
                    <div class="h-10 w-10 bg-pink-600 rounded-full flex items-center justify-center text-white font-bold">
                        S
                    </div>
                    <div class="ml-3">
                        <p class="font-semibold">Siti Aminah</p>
                        <p class="text-sm text-gray-500">Berastagi</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-md">
                <div class="flex items-center mb-4">
                    <div class="text-yellow-400 text-xl">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                </div>
                <p class="text-gray-600 mb-4">"Harga terjangkau, bisa pilih kursi sendiri. Top markotop!"</p>
                <div class="flex items-center">
                    <div class="h-10 w-10 bg-green-600 rounded-full flex items-center justify-center text-white font-bold">
                        A
                    </div>
                    <div class="ml-3">
                        <p class="font-semibold">Andi Wijaya</p>
                        <p class="text-sm text-gray-500">Kabanjahe</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Siap Memulai Perjalanan Anda?</h2>
        <p class="text-xl text-blue-100 mb-8">Pesan tiket sekarang dan nikmati kemudahan booking online</p>
        <a href="{{ route('search') }}" class="inline-block bg-white text-blue-600 font-bold px-8 py-4 rounded-lg hover:bg-blue-50 transition duration-300 shadow-lg">
            Pesan Tiket Sekarang →
        </a>
    </div>
</section>
@endsection
