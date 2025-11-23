@extends('layouts.admin')

@section('title', 'Dynamic Pricing')
@section('page-title', 'Dynamic Pricing Rules')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Dynamic Pricing</h2>
            <p class="text-gray-600 mt-1">Atur aturan harga dinamis berdasarkan demand, waktu, dan kondisi</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.pricing.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
            <button onclick="openModal('addRuleModal')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                <i class="fas fa-plus mr-2"></i>Tambah Rule
            </button>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Active Rules</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">12</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Avg. Price Increase</p>
                    <p class="text-3xl font-bold text-orange-600 mt-2">18%</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-arrow-up text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Revenue Boost</p>
                    <p class="text-2xl font-bold text-purple-600 mt-2">+Rp 45jt</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Scheduled Rules</p>
                    <p class="text-3xl font-bold text-blue-600 mt-2">5</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-sm p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-xl font-bold mb-2">Weekend Surge Pricing</h3>
                <p class="text-blue-100">Aktif untuk 23-24 November 2025 (Sabtu-Minggu)</p>
                <p class="text-sm text-blue-100 mt-1">12 rute terpengaruh • Rata-rata kenaikan: +15%</p>
            </div>
            <div class="flex items-center space-x-3">
                <button class="px-4 py-2 bg-white text-blue-600 rounded-lg hover:bg-blue-50 transition-colors">
                    Lihat Detail
                </button>
                <button class="px-4 py-2 bg-blue-700 text-white rounded-lg hover:bg-blue-800 transition-colors">
                    Nonaktifkan
                </button>
            </div>
        </div>
    </div>

    <!-- Dynamic Pricing Rules -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-900">Aturan Dynamic Pricing</h3>
        </div>

        <div class="divide-y divide-gray-200">
            @php
                $rules = [
                    [
                        'name' => 'Weekend Premium',
                        'type' => 'Time-based',
                        'condition' => 'Sabtu & Minggu',
                        'adjustment' => '+15%',
                        'routes' => ['Medan - Pematang Siantar', 'Medan - Rantau Prapat', 'Medan - Berastagi'],
                        'status' => 'active',
                        'priority' => 'high'
                    ],
                    [
                        'name' => 'High Demand Surge',
                        'type' => 'Occupancy-based',
                        'condition' => 'Occupancy > 80%',
                        'adjustment' => '+25%',
                        'routes' => ['Semua rute'],
                        'status' => 'active',
                        'priority' => 'high'
                    ],
                    [
                        'name' => 'Early Bird Discount',
                        'type' => 'Time-based',
                        'condition' => 'Booking > 7 hari sebelumnya',
                        'adjustment' => '-10%',
                        'routes' => ['Medan - Sibolga', 'Medan - Padang Sidempuan'],
                        'status' => 'active',
                        'priority' => 'medium'
                    ],
                    [
                        'name' => 'Peak Season - Lebaran',
                        'type' => 'Seasonal',
                        'condition' => '20 Mar - 5 Apr 2025',
                        'adjustment' => '+30%',
                        'routes' => ['Semua rute'],
                        'status' => 'scheduled',
                        'priority' => 'high'
                    ],
                    [
                        'name' => 'Late Booking Fee',
                        'type' => 'Time-based',
                        'condition' => 'Booking < 24 jam',
                        'adjustment' => '+20%',
                        'routes' => ['Medan - Pematang Siantar', 'Medan - Berastagi'],
                        'status' => 'active',
                        'priority' => 'medium'
                    ],
                    [
                        'name' => 'Low Demand Promo',
                        'type' => 'Occupancy-based',
                        'condition' => 'Occupancy < 30%',
                        'adjustment' => '-15%',
                        'routes' => ['Medan - Kabanjahe', 'Medan - Binjai'],
                        'status' => 'active',
                        'priority' => 'low'
                    ],
                ];
            @endphp

            @foreach($rules as $index => $rule)
            <div class="p-6 hover:bg-gray-50 transition-colors">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-3 mb-2">
                            <h4 class="text-lg font-bold text-gray-900">{{ $rule['name'] }}</h4>
                            <span class="px-3 py-1 text-xs font-medium rounded-full
                                {{ $rule['status'] == 'active' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $rule['status'] == 'scheduled' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $rule['status'] == 'inactive' ? 'bg-gray-100 text-gray-700' : '' }}">
                                {{ $rule['status'] == 'active' ? 'Aktif' : '' }}
                                {{ $rule['status'] == 'scheduled' ? 'Terjadwal' : '' }}
                                {{ $rule['status'] == 'inactive' ? 'Non-aktif' : '' }}
                            </span>
                            <span class="px-3 py-1 text-xs font-medium rounded-full
                                {{ $rule['priority'] == 'high' ? 'bg-red-100 text-red-700' : '' }}
                                {{ $rule['priority'] == 'medium' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $rule['priority'] == 'low' ? 'bg-blue-100 text-blue-700' : '' }}">
                                Priority: {{ ucfirst($rule['priority']) }}
                            </span>
                        </div>

                        <div class="grid grid-cols-4 gap-4 mb-3">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Tipe</p>
                                <p class="text-sm font-medium text-gray-900">{{ $rule['type'] }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Kondisi</p>
                                <p class="text-sm font-medium text-gray-900">{{ $rule['condition'] }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Penyesuaian Harga</p>
                                <p class="text-lg font-bold {{ strpos($rule['adjustment'], '+') !== false ? 'text-orange-600' : 'text-green-600' }}">
                                    {{ $rule['adjustment'] }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Rute Terdampak</p>
                                <p class="text-sm font-medium text-gray-900">{{ count($rule['routes']) }} rute</p>
                            </div>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500 mb-1">Rute:</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach(array_slice($rule['routes'], 0, 3) as $route)
                                <span class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded">{{ $route }}</span>
                                @endforeach
                                @if(count($rule['routes']) > 3)
                                <span class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded">+{{ count($rule['routes']) - 3 }} lainnya</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center space-x-2 ml-4">
                        <button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="p-2 text-purple-600 hover:bg-purple-50 rounded-lg transition-colors" title="Analytics">
                            <i class="fas fa-chart-bar"></i>
                        </button>
                        <button class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Duplicate">
                            <i class="fas fa-copy"></i>
                        </button>
                        <button class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Performance Chart -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Performance Dynamic Pricing (30 Hari Terakhir)</h3>
        <div class="h-64 bg-gray-50 rounded-lg flex items-center justify-center">
            <div class="text-center text-gray-500">
                <i class="fas fa-chart-area text-6xl mb-4"></i>
                <p>Grafik revenue impact dari dynamic pricing</p>
            </div>
        </div>
    </div>
</div>

<!-- Add Rule Modal -->
<div id="addRuleModal" data-modal="overlay" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0, 0, 0, 0.5); z-index: 9999; padding: 1rem; overflow-y: auto;">
    <div class="bg-white rounded-xl max-w-3xl w-full mx-auto my-8">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900">Tambah Dynamic Pricing Rule</h3>
                <button onclick="closeModal('addRuleModal')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        
        <form class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Rule</label>
                <input type="text" placeholder="Contoh: Weekend Premium" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Rule</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option>Time-based</option>
                        <option>Occupancy-based</option>
                        <option>Seasonal</option>
                        <option>Event-based</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Priority</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option>High</option>
                        <option>Medium</option>
                        <option>Low</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kondisi</label>
                <input type="text" placeholder="Contoh: Sabtu & Minggu" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Adjustment Type</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option>Percentage</option>
                        <option>Fixed Amount</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nilai Adjustment</label>
                    <div class="flex">
                        <select class="px-4 py-2 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option>+</option>
                            <option>-</option>
                        </select>
                        <input type="number" placeholder="15" class="flex-1 px-4 py-2 border-t border-r border-b border-gray-300 rounded-r-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Rute</label>
                <div class="border border-gray-300 rounded-lg p-4 max-h-48 overflow-y-auto">
                    <label class="flex items-center mb-2">
                        <input type="checkbox" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Semua Rute</span>
                    </label>
                    <label class="flex items-center mb-2">
                        <input type="checkbox" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Medan - Pematang Siantar</span>
                    </label>
                    <label class="flex items-center mb-2">
                        <input type="checkbox" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Medan - Rantau Prapat</span>
                    </label>
                    <label class="flex items-center mb-2">
                        <input type="checkbox" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Medan - Sibolga</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Medan - Berastagi</span>
                    </label>
                </div>
            </div>

            <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200">
                <button type="button" onclick="closeModal('addRuleModal')" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                    <i class="fas fa-save mr-2"></i>Simpan Rule
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openModal(id) {
    const modal = document.getElementById(id);
    modal.style.display = 'flex';
    modal.style.alignItems = 'center';
    modal.style.justifyContent = 'center';
}

function closeModal(id) {
    document.getElementById(id).style.display = 'none';
}
</script>
@endpush
