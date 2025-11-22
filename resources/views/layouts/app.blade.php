<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'KBT - Pemesanan Tiket Minibus Online')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @stack('styles')
</head>
<body class="font-sans antialiased">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                        </svg>
                        <span class="ml-2 text-2xl font-bold text-blue-600">KBT</span>
                    </a>
                </div>
                
                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 font-medium transition">Beranda</a>
                    <a href="{{ route('search') }}" class="text-gray-700 hover:text-blue-600 font-medium transition">Cari Tiket</a>
                    <a href="{{ route('ticket.check') }}" class="text-gray-700 hover:text-blue-600 font-medium transition">Cek Pesanan</a>
                    <a href="{{ route('help') }}" class="text-gray-700 hover:text-blue-600 font-medium transition">Bantuan</a>
                </div>
                
                <!-- Auth Buttons -->
                <div class="flex items-center space-x-4">
                    @auth
                        <div class="relative" x-data="{ open: false }" x-init="console.log('Dropdown initialized')">
                            <button 
                                @click="open = !open; console.log('Dropdown clicked, open:', open)" 
                                type="button"
                                class="flex items-center space-x-2 text-gray-700 hover:text-blue-600 font-medium focus:outline-none">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="h-4 w-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div 
                                x-show="open" 
                                @click.away="open = false"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-2 z-50 border border-gray-200"
                                style="display: none;">
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition">
                                        <i class="bi bi-speedometer2 mr-2"></i>Admin Dashboard
                                    </a>
                                @endif
                                <a href="{{ route('profile.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition">
                                    <i class="bi bi-house-door mr-2"></i>Dashboard
                                </a>
                                <a href="{{ route('profile.bookings') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition">
                                    <i class="bi bi-ticket-perforated mr-2"></i>Pesanan Saya
                                </a>
                                <a href="{{ route('profile.settings') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition">
                                    <i class="bi bi-gear mr-2"></i>Pengaturan
                                </a>
                                <hr class="my-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100 transition">
                                        <i class="bi bi-box-arrow-right mr-2"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 font-medium">Masuk</a>
                        <a href="{{ route('register') }}" class="btn-primary">Daftar</a>
                    @endauth
                </div>
                
                <!-- Mobile menu button -->
                <div class="flex items-center md:hidden">
                    <button type="button" class="text-gray-700 hover:text-blue-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- About -->
                <div>
                    <h3 class="text-xl font-bold mb-4">KBT</h3>
                    <p class="text-gray-400">Platform pemesanan tiket minibus online yang mudah, cepat, dan terpercaya.</p>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Link Cepat</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition">Beranda</a></li>
                        <li><a href="{{ route('search') }}" class="text-gray-400 hover:text-white transition">Cari Tiket</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Tentang Kami</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
                
                <!-- Support -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Bantuan</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">FAQ</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Hubungi Kami</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Cara Pesan</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Kebijakan Pembatalan</a></li>
                    </ul>
                </div>
                
                <!-- Contact -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><i class="bi bi-telephone-fill"></i> +62 812-3456-7890</li>
                        <li><i class="bi bi-envelope-fill"></i> info@kbt.co.id</li>
                        <li><i class="bi bi-geo-alt-fill"></i> Medan, Sumatera Utara</li>
                    </ul>
                    <div class="flex space-x-4 mt-4">
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.162-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.401.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.354-.629-2.758-1.379l-.749 2.848c-.269 1.045-1.004 2.352-1.498 3.146 1.123.345 2.306.535 3.55.535 6.607 0 11.985-5.365 11.985-11.987C23.97 5.39 18.592.026 11.985.026L12.017 0z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} KBT. All rights reserved.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
