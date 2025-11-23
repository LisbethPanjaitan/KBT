@extends('layouts.admin')

@section('title', 'Audit Log')
@section('page-title', 'Audit Log & Activity')

@section('content')
<div class="space-y-6">
    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Activities</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">12,847</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-history text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Hari Ini</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">342</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Admin Aktif</p>
                    <p class="text-3xl font-bold text-purple-600 mt-2">8</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Failed Actions</p>
                    <p class="text-3xl font-bold text-red-600 mt-2">12</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <input type="text" placeholder="Cari aktivitas..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option>Semua Admin</option>
                    <option>John Doe</option>
                    <option>Jane Smith</option>
                    <option>Robert Johnson</option>
                </select>
            </div>
            <div>
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option>Semua Tipe</option>
                    <option>CREATE</option>
                    <option>UPDATE</option>
                    <option>DELETE</option>
                    <option>LOGIN</option>
                    <option>LOGOUT</option>
                </select>
            </div>
            <div>
                <input type="date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-search mr-2"></i>Filter
                </button>
            </div>
        </div>
    </div>

    <!-- Audit Log Timeline -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-6">Activity Timeline</h3>
        
        <div class="space-y-6">
            @php
                $logs = [
                    ['user' => 'John Doe', 'action' => 'CREATE', 'module' => 'Booking', 'detail' => 'Membuat pemesanan manual #BK-2025-001234', 'ip' => '192.168.1.100', 'time' => '2 menit yang lalu', 'status' => 'success'],
                    ['user' => 'Jane Smith', 'action' => 'UPDATE', 'module' => 'Payment', 'detail' => 'Mengkonfirmasi pembayaran tunai #BK-2025-001233', 'ip' => '192.168.1.101', 'time' => '5 menit yang lalu', 'status' => 'success'],
                    ['user' => 'Robert Johnson', 'action' => 'DELETE', 'module' => 'Booking', 'detail' => 'Membatalkan pemesanan #BK-2025-001232', 'ip' => '192.168.1.102', 'time' => '12 menit yang lalu', 'status' => 'success'],
                    ['user' => 'Sarah Williams', 'action' => 'CREATE', 'module' => 'Schedule', 'detail' => 'Menambahkan jadwal baru Medan - Pematang Siantar 08:00', 'ip' => '192.168.1.103', 'time' => '25 menit yang lalu', 'status' => 'success'],
                    ['user' => 'John Doe', 'action' => 'UPDATE', 'module' => 'Vehicle', 'detail' => 'Mengubah status kendaraan B-1234-ABC ke maintenance', 'ip' => '192.168.1.100', 'time' => '45 menit yang lalu', 'status' => 'success'],
                    ['user' => 'Admin System', 'action' => 'DELETE', 'module' => 'Booking', 'detail' => 'Auto-cancel booking expired #BK-2025-001200', 'ip' => 'SYSTEM', 'time' => '1 jam yang lalu', 'status' => 'success'],
                    ['user' => 'Jane Smith', 'action' => 'LOGIN', 'module' => 'Auth', 'detail' => 'Login ke sistem admin', 'ip' => '192.168.1.101', 'time' => '2 jam yang lalu', 'status' => 'success'],
                    ['user' => 'Unknown', 'action' => 'LOGIN', 'module' => 'Auth', 'detail' => 'Percobaan login gagal (invalid password)', 'ip' => '103.xxx.xxx.xxx', 'time' => '3 jam yang lalu', 'status' => 'failed'],
                ];
            @endphp

            @foreach($logs as $log)
            <div class="flex items-start space-x-4 pb-6 border-b border-gray-200 last:border-0 last:pb-0">
                <!-- Timeline Dot -->
                <div class="flex-shrink-0 mt-1">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center
                        {{ $log['action'] == 'CREATE' ? 'bg-green-100' : '' }}
                        {{ $log['action'] == 'UPDATE' ? 'bg-blue-100' : '' }}
                        {{ $log['action'] == 'DELETE' ? 'bg-red-100' : '' }}
                        {{ $log['action'] == 'LOGIN' ? 'bg-purple-100' : '' }}
                        {{ $log['action'] == 'LOGOUT' ? 'bg-gray-100' : '' }}">
                        @if($log['action'] == 'CREATE')
                            <i class="fas fa-plus text-green-600"></i>
                        @elseif($log['action'] == 'UPDATE')
                            <i class="fas fa-edit text-blue-600"></i>
                        @elseif($log['action'] == 'DELETE')
                            <i class="fas fa-trash text-red-600"></i>
                        @elseif($log['action'] == 'LOGIN')
                            <i class="fas fa-sign-in-alt text-purple-600"></i>
                        @else
                            <i class="fas fa-sign-out-alt text-gray-600"></i>
                        @endif
                    </div>
                </div>

                <!-- Content -->
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-2">
                                <span class="px-2 py-1 text-xs font-bold rounded
                                    {{ $log['action'] == 'CREATE' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $log['action'] == 'UPDATE' ? 'bg-blue-100 text-blue-700' : '' }}
                                    {{ $log['action'] == 'DELETE' ? 'bg-red-100 text-red-700' : '' }}
                                    {{ $log['action'] == 'LOGIN' ? 'bg-purple-100 text-purple-700' : '' }}
                                    {{ $log['action'] == 'LOGOUT' ? 'bg-gray-100 text-gray-700' : '' }}">
                                    {{ $log['action'] }}
                                </span>
                                <span class="text-xs text-gray-500">{{ $log['module'] }}</span>
                            </div>

                            <p class="text-sm text-gray-900 mb-2">
                                <span class="font-semibold">{{ $log['user'] }}</span> {{ $log['detail'] }}
                            </p>

                            <div class="flex items-center space-x-4 text-xs text-gray-500">
                                <span>
                                    <i class="fas fa-clock mr-1"></i>{{ $log['time'] }}
                                </span>
                                <span>
                                    <i class="fas fa-network-wired mr-1"></i>{{ $log['ip'] }}
                                </span>
                                @if($log['status'] == 'success')
                                    <span class="text-green-600">
                                        <i class="fas fa-check-circle mr-1"></i>Success
                                    </span>
                                @else
                                    <span class="text-red-600">
                                        <i class="fas fa-times-circle mr-1"></i>Failed
                                    </span>
                                @endif
                            </div>
                        </div>

                        <button class="ml-4 p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                            <i class="fas fa-info-circle"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6 pt-6 border-t border-gray-200 flex items-center justify-between">
            <p class="text-sm text-gray-600">Menampilkan 1-20 dari 12,847 aktivitas</p>
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

    <!-- Export Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Export Audit Log</h3>
        <div class="flex items-center space-x-4">
            <div class="flex-1">
                <p class="text-sm text-gray-600">Export log aktivitas untuk keperluan audit dan compliance</p>
            </div>
            <button class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg flex items-center">
                <i class="fas fa-file-excel mr-2"></i>Export to Excel
            </button>
            <button class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg flex items-center">
                <i class="fas fa-file-pdf mr-2"></i>Export to PDF
            </button>
        </div>
    </div>
</div>
@endsection
