<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name', 'KBT') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        [x-cloak] { display: none !important; }
        
        .sidebar-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }
        .sidebar-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 2px;
        }
        .sidebar-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }
        
        /* Modal Overlay */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            padding: 1rem;
            overflow-y: auto;
        }
        .modal-overlay[style*="display: flex"],
        .modal-overlay[style*="display:flex"] {
            display: flex !important;
            align-items: center;
            justify-content: center;
        }
    </style>

    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50" x-data="{ sidebarOpen: true, mobileMenuOpen: false }">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside 
            x-show="sidebarOpen || mobileMenuOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            @click.away="mobileMenuOpen = false"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-blue-900 via-blue-800 to-blue-900 text-white transform lg:relative lg:translate-x-0 transition-all duration-200"
            :class="{ 'w-64': sidebarOpen, 'w-20': !sidebarOpen }"
        >
            <!-- Logo -->
            <div class="flex items-center justify-between h-16 px-4 border-b border-blue-700">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                        <i class="fas fa-bus text-blue-600 text-xl"></i>
                    </div>
                    <div x-show="sidebarOpen">
                        <span class="text-xl font-bold block">KBT Admin</span>
                        <span class="text-xs opacity-75">Koperasi Bintang Tapanuli</span>
                    </div>
                </a>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-3 py-4 overflow-y-auto sidebar-scrollbar" style="max-height: calc(100vh - 8rem)">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2.5 mb-1 text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-blue-700' : '' }}">
                    <i class="fas fa-chart-line w-5"></i>
                    <span x-show="sidebarOpen" class="ml-3">Dashboard</span>
                </a>

                <!-- Pemesanan & Loket -->
                <div x-data="{ open: {{ request()->routeIs('admin.bookings.*') || request()->routeIs('admin.loket.*') ? 'true' : 'false' }} }" class="mb-1">
                    <button @click="open = !open" class="flex items-center justify-between w-full px-3 py-2.5 text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        <div class="flex items-center">
                            <i class="fas fa-ticket w-5"></i>
                            <span x-show="sidebarOpen" class="ml-3">Pemesanan & Loket</span>
                        </div>
                        <i x-show="sidebarOpen" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas text-xs"></i>
                    </button>
                    <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
                        <a href="{{ route('admin.loket.create') }}" class="block px-3 py-2 text-sm rounded-lg hover:bg-blue-700 {{ request()->routeIs('admin.loket.create') ? 'bg-blue-700' : '' }}">
                            <i class="fas fa-plus-circle w-4 text-xs mr-2"></i>Pemesanan Manual
                        </a>
                        <a href="{{ route('admin.bookings.index') }}" class="block px-3 py-2 text-sm rounded-lg hover:bg-blue-700 {{ request()->routeIs('admin.bookings.index') ? 'bg-blue-700' : '' }}">
                            <i class="fas fa-list w-4 text-xs mr-2"></i>Kelola Pemesanan
                        </a>
                        <a href="{{ route('admin.bookings.pending') }}" class="block px-3 py-2 text-sm rounded-lg hover:bg-blue-700 {{ request()->routeIs('admin.bookings.pending') ? 'bg-blue-700' : '' }}">
                            <i class="fas fa-clock w-4 text-xs mr-2"></i>Pending Payment
                        </a>
                    </div>
                </div>

                <!-- Jadwal & Rute -->
                <div x-data="{ open: {{ request()->routeIs('admin.schedules.*') || request()->routeIs('admin.routes.*') ? 'true' : 'false' }} }" class="mb-1">
                    <button @click="open = !open" class="flex items-center justify-between w-full px-3 py-2.5 text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        <div class="flex items-center">
                            <i class="fas fa-calendar-alt w-5"></i>
                            <span x-show="sidebarOpen" class="ml-3">Jadwal & Rute</span>
                        </div>
                        <i x-show="sidebarOpen" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas text-xs"></i>
                    </button>
                    <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
                        <a href="{{ route('admin.routes.index') }}" class="block px-3 py-2 text-sm rounded-lg hover:bg-blue-700">
                            <i class="fas fa-route w-4 text-xs mr-2"></i>Kelola Rute
                        </a>
                        <a href="{{ route('admin.schedules.index') }}" class="block px-3 py-2 text-sm rounded-lg hover:bg-blue-700">
                            <i class="fas fa-clock w-4 text-xs mr-2"></i>Kelola Jadwal
                        </a>
                        <a href="{{ route('admin.schedules.calendar') }}" class="block px-3 py-2 text-sm rounded-lg hover:bg-blue-700">
                            <i class="fas fa-calendar w-4 text-xs mr-2"></i>Kalender Jadwal
                        </a>
                    </div>
                </div>

                <!-- Armada -->
                <div x-data="{ open: {{ request()->routeIs('admin.vehicles.*') ? 'true' : 'false' }} }" class="mb-1">
                    <button @click="open = !open" class="flex items-center justify-between w-full px-3 py-2.5 text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        <div class="flex items-center">
                            <i class="fas fa-bus w-5"></i>
                            <span x-show="sidebarOpen" class="ml-3">Armada</span>
                        </div>
                        <i x-show="sidebarOpen" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas text-xs"></i>
                    </button>
                    <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
                        <a href="{{ route('admin.vehicles.index') }}" class="block px-3 py-2 text-sm rounded-lg hover:bg-blue-700">
                            <i class="fas fa-list w-4 text-xs mr-2"></i>Daftar Kendaraan
                        </a>
                        <a href="{{ route('admin.vehicles.seatmap') }}" class="block px-3 py-2 text-sm rounded-lg hover:bg-blue-700">
                            <i class="fas fa-th w-4 text-xs mr-2"></i>Seat Map Editor
                        </a>
                    </div>
                </div>

                <!-- Harga & Promo -->
                <div x-data="{ open: {{ request()->routeIs('admin.pricing.*') || request()->routeIs('admin.promos.*') ? 'true' : 'false' }} }" class="mb-1">
                    <button @click="open = !open" class="flex items-center justify-between w-full px-3 py-2.5 text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        <div class="flex items-center">
                            <i class="fas fa-tags w-5"></i>
                            <span x-show="sidebarOpen" class="ml-3">Harga & Promo</span>
                        </div>
                        <i x-show="sidebarOpen" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas text-xs"></i>
                    </button>
                    <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
                        <a href="{{ route('admin.pricing.index') }}" class="block px-3 py-2 text-sm rounded-lg hover:bg-blue-700">
                            <i class="fas fa-dollar-sign w-4 text-xs mr-2"></i>Atur Harga
                        </a>
                        <a href="{{ route('admin.pricing.dynamic') }}" class="block px-3 py-2 text-sm rounded-lg hover:bg-blue-700">
                            <i class="fas fa-chart-line w-4 text-xs mr-2"></i>Dynamic Pricing
                        </a>
                        <a href="{{ route('admin.promos.index') }}" class="block px-3 py-2 text-sm rounded-lg hover:bg-blue-700">
                            <i class="fas fa-gift w-4 text-xs mr-2"></i>Kelola Promo
                        </a>
                    </div>
                </div>

                <!-- Pembayaran -->
                <div x-data="{ open: {{ request()->routeIs('admin.payments.*') ? 'true' : 'false' }} }" class="mb-1">
                    <button @click="open = !open" class="flex items-center justify-between w-full px-3 py-2.5 text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        <div class="flex items-center">
                            <i class="fas fa-credit-card w-5"></i>
                            <span x-show="sidebarOpen" class="ml-3">Pembayaran</span>
                        </div>
                        <i x-show="sidebarOpen" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas text-xs"></i>
                    </button>
                    <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
                        <a href="{{ route('admin.payments.index') }}" class="block px-3 py-2 text-sm rounded-lg hover:bg-blue-700">
                            <i class="fas fa-list w-4 text-xs mr-2"></i>Transaksi
                        </a>
                        <a href="{{ route('admin.payments.reconciliation') }}" class="block px-3 py-2 text-sm rounded-lg hover:bg-blue-700">
                            <i class="fas fa-balance-scale w-4 text-xs mr-2"></i>Rekonsiliasi
                        </a>
                        <a href="{{ route('admin.payments.refunds') }}" class="block px-3 py-2 text-sm rounded-lg hover:bg-blue-700">
                            <i class="fas fa-undo w-4 text-xs mr-2"></i>Refund
                        </a>
                    </div>
                </div>

                <!-- Laporan -->
                <a href="{{ route('admin.reports.index') }}" class="flex items-center px-3 py-2.5 mb-1 text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-file-chart-line w-5"></i>
                    <span x-show="sidebarOpen" class="ml-3">Laporan</span>
                </a>

                <!-- Manifest -->
                <a href="{{ route('admin.manifest.index') }}" class="flex items-center px-3 py-2.5 mb-1 text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-users w-5"></i>
                    <span x-show="sidebarOpen" class="ml-3">Manifest Penumpang</span>
                </a>

                <!-- Notifikasi -->
                <a href="{{ route('admin.notifications.index') }}" class="flex items-center px-3 py-2.5 mb-1 text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-bell w-5"></i>
                    <span x-show="sidebarOpen" class="ml-3">Notifikasi & Broadcast</span>
                </a>

                <div class="my-3 border-t border-blue-700"></div>

                <!-- Admin & Security -->
                <div x-data="{ open: false }" class="mb-1">
                    <button @click="open = !open" class="flex items-center justify-between w-full px-3 py-2.5 text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        <div class="flex items-center">
                            <i class="fas fa-shield-alt w-5"></i>
                            <span x-show="sidebarOpen" class="ml-3">Admin & Security</span>
                        </div>
                        <i x-show="sidebarOpen" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas text-xs"></i>
                    </button>
                    <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
                        <a href="{{ route('admin.users.index') }}" class="block px-3 py-2 text-sm rounded-lg hover:bg-blue-700">
                            <i class="fas fa-user-shield w-4 text-xs mr-2"></i>Kelola Admin
                        </a>
                        <a href="{{ route('admin.audit.index') }}" class="block px-3 py-2 text-sm rounded-lg hover:bg-blue-700">
                            <i class="fas fa-history w-4 text-xs mr-2"></i>Audit Log
                        </a>
                    </div>
                </div>

                <!-- Integrasi -->
                <a href="{{ route('admin.integrations.index') }}" class="flex items-center px-3 py-2.5 mb-1 text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-plug w-5"></i>
                    <span x-show="sidebarOpen" class="ml-3">Integrasi</span>
                </a>

                <!-- Pengaturan -->
                <a href="{{ route('admin.settings.index') }}" class="flex items-center px-3 py-2.5 mb-1 text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-cog w-5"></i>
                    <span x-show="sidebarOpen" class="ml-3">Pengaturan</span>
                </a>
            </nav>

            <!-- User Info -->
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-blue-700 bg-blue-900">
                <div class="flex items-center">
                    <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name ?? 'Admin' }}&background=3b82f6&color=fff" 
                         class="w-10 h-10 rounded-full" alt="Avatar">
                    <div x-show="sidebarOpen" class="ml-3 flex-1">
                        <p class="text-sm font-medium">{{ auth()->user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-blue-300">{{ auth()->user()->email ?? 'admin@kbt.com' }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white border-b border-gray-200 z-10">
                <div class="flex items-center justify-between h-16 px-6">
                    <div class="flex items-center space-x-4">
                        <button @click="sidebarOpen = !sidebarOpen" class="hidden lg:block text-gray-500 hover:text-gray-700">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden text-gray-500 hover:text-gray-700">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <h1 class="text-xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                    </div>

                    <div class="flex items-center space-x-4">
                        <!-- Search -->
                        <div class="hidden md:block">
                            <div class="relative">
                                <input type="text" placeholder="Cari pemesanan..." 
                                       class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            </div>
                        </div>

                        <!-- Notifications -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="relative p-2 text-gray-500 hover:bg-gray-100 rounded-lg">
                                <i class="fas fa-bell text-xl"></i>
                                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                            </button>
                            <div x-show="open" @click.away="open = false" x-cloak
                                 class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border border-gray-200 py-2">
                                <div class="px-4 py-2 border-b border-gray-200">
                                    <h3 class="font-semibold text-gray-800">Notifikasi</h3>
                                </div>
                                <div class="max-h-96 overflow-y-auto">
                                    <a href="#" class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-100">
                                        <div class="flex items-start">
                                            <i class="fas fa-exclamation-circle text-yellow-500 mt-1"></i>
                                            <div class="ml-3">
                                                <p class="text-sm text-gray-800">Jadwal Medan-Pematang Siantar penuh</p>
                                                <p class="text-xs text-gray-500 mt-1">5 menit yang lalu</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="block px-4 py-3 hover:bg-gray-50">
                                        <div class="flex items-start">
                                            <i class="fas fa-info-circle text-blue-500 mt-1"></i>
                                            <div class="ml-3">
                                                <p class="text-sm text-gray-800">10 pembayaran pending</p>
                                                <p class="text-xs text-gray-500 mt-1">15 menit yang lalu</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- User Menu -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center space-x-2 p-2 hover:bg-gray-100 rounded-lg">
                                <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name ?? 'Admin' }}&background=3b82f6&color=fff" 
                                     class="w-8 h-8 rounded-full" alt="Avatar">
                                <i class="fas fa-chevron-down text-gray-500 text-xs"></i>
                            </button>
                            <div x-show="open" @click.away="open = false" x-cloak
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-200 py-2">
                                <a href="{{ route('admin.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-user w-5"></i>Profil
                                </a>
                                <a href="{{ route('admin.settings.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-cog w-5"></i>Pengaturan
                                </a>
                                <div class="border-t border-gray-200 my-2"></div>
                                <form method="POST" action="{{ route('admin.logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-50">
                                        <i class="fas fa-sign-out-alt w-5"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <p class="ml-3 text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle text-red-500"></i>
                            <p class="ml-3 text-sm text-red-700">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
