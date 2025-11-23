@extends('layouts.admin')

@section('title', 'Kelola Harga')
@section('page-title', 'Manajemen Harga & Tarif')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Kelola Harga</h2>
            <p class="text-gray-600 mt-1">Manajemen harga tiket untuk setiap rute</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.pricing.dynamic') }}" class="bg-purple-100 hover:bg-purple-200 text-purple-700 px-4 py-2 rounded-lg transition-colors">
                <i class="fas fa-chart-line mr-2"></i>Dynamic Pricing
            </a>
            <button onclick="openModal('addPriceModal')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                <i class="fas fa-plus mr-2"></i>Tambah Harga
            </button>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Rute</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">28</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-route text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Rata-rata Harga</p>
                    <p class="text-2xl font-bold text-green-600 mt-2">Rp 125k</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Dynamic Pricing</p>
                    <p class="text-3xl font-bold text-purple-600 mt-2">12</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Promo Aktif</p>
                    <p class="text-3xl font-bold text-orange-600 mt-2">5</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-tags text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <input type="text" placeholder="Cari rute..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div>
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option>Semua Kota Asal</option>
                    <option>Medan</option>
                    <option>Binjai</option>
                    <option>Pematang Siantar</option>
                </select>
            </div>
            <div>
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option>Semua Tipe Bus</option>
                    <option>Executive</option>
                    <option>VIP</option>
                    <option>Economy</option>
                </select>
            </div>
            <div>
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option>Harga: Semua</option>
                    <option>< Rp 50.000</option>
                    <option>Rp 50.000 - Rp 100.000</option>
                    <option>Rp 100.000 - Rp 200.000</option>
                    <option>> Rp 200.000</option>
                </select>
            </div>
            <div>
                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-search mr-2"></i>Cari
                </button>
            </div>
        </div>
    </div>

    <!-- Pricing Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Rute</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tipe Bus</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Harga Dasar</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Dynamic</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Weekend</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Peak Season</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @php
                        $pricingData = [
                            ['route' => 'Medan - Pematang Siantar', 'bus_type' => 'Executive', 'base_price' => 75000, 'dynamic' => true, 'weekend' => 85000, 'peak' => 95000],
                            ['route' => 'Medan - Pematang Siantar', 'bus_type' => 'VIP', 'base_price' => 95000, 'dynamic' => true, 'weekend' => 110000, 'peak' => 125000],
                            ['route' => 'Medan - Rantau Prapat', 'bus_type' => 'Executive', 'base_price' => 120000, 'dynamic' => true, 'weekend' => 135000, 'peak' => 150000],
                            ['route' => 'Medan - Rantau Prapat', 'bus_type' => 'Economy', 'base_price' => 95000, 'dynamic' => false, 'weekend' => 105000, 'peak' => 115000],
                            ['route' => 'Medan - Sibolga', 'bus_type' => 'Executive', 'base_price' => 180000, 'dynamic' => true, 'weekend' => 200000, 'peak' => 225000],
                            ['route' => 'Medan - Padang Sidempuan', 'bus_type' => 'VIP', 'base_price' => 220000, 'dynamic' => false, 'weekend' => 245000, 'peak' => 270000],
                            ['route' => 'Medan - Berastagi', 'bus_type' => 'Executive', 'base_price' => 45000, 'dynamic' => true, 'weekend' => 55000, 'peak' => 65000],
                            ['route' => 'Medan - Berastagi', 'bus_type' => 'Economy', 'base_price' => 35000, 'dynamic' => false, 'weekend' => 40000, 'peak' => 45000],
                            ['route' => 'Medan - Kabanjahe', 'bus_type' => 'Executive', 'base_price' => 50000, 'dynamic' => true, 'weekend' => 60000, 'peak' => 70000],
                            ['route' => 'Medan - Binjai', 'bus_type' => 'Economy', 'base_price' => 25000, 'dynamic' => false, 'weekend' => 25000, 'peak' => 30000],
                        ];
                    @endphp

                    @foreach($pricingData as $price)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <i class="fas fa-route text-blue-600 mr-3"></i>
                                <p class="font-semibold text-gray-900">{{ $price['route'] }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-medium rounded-full
                                {{ $price['bus_type'] == 'Executive' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $price['bus_type'] == 'VIP' ? 'bg-purple-100 text-purple-700' : '' }}
                                {{ $price['bus_type'] == 'Economy' ? 'bg-green-100 text-green-700' : '' }}">
                                {{ $price['bus_type'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-semibold text-gray-900">Rp {{ number_format($price['base_price'], 0, ',', '.') }}</p>
                        </td>
                        <td class="px-6 py-4">
                            @if($price['dynamic'])
                                <span class="flex items-center text-green-600">
                                    <i class="fas fa-check-circle mr-2"></i>Aktif
                                </span>
                            @else
                                <span class="flex items-center text-gray-400">
                                    <i class="fas fa-times-circle mr-2"></i>Non-aktif
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-900">Rp {{ number_format($price['weekend'], 0, ',', '.') }}</p>
                            @if($price['weekend'] > $price['base_price'])
                                <span class="text-xs text-green-600">+{{ number_format((($price['weekend'] - $price['base_price']) / $price['base_price']) * 100, 0) }}%</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-900">Rp {{ number_format($price['peak'], 0, ',', '.') }}</p>
                            @if($price['peak'] > $price['base_price'])
                                <span class="text-xs text-orange-600">+{{ number_format((($price['peak'] - $price['base_price']) / $price['base_price']) * 100, 0) }}%</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="p-2 text-purple-600 hover:bg-purple-50 rounded-lg transition-colors" title="Dynamic Pricing">
                                    <i class="fas fa-chart-line"></i>
                                </button>
                                <button class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="History">
                                    <i class="fas fa-history"></i>
                                </button>
                                <button class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                    <i class="fas fa-trash"></i>
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
            <p class="text-sm text-gray-600">Menampilkan 1-10 dari 28 harga</p>
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

    <!-- Price Comparison Chart -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Perbandingan Harga Rute Populer</h3>
        <div class="h-64 bg-gray-50 rounded-lg flex items-center justify-center">
            <div class="text-center text-gray-500">
                <i class="fas fa-chart-bar text-6xl mb-4"></i>
                <p>Grafik perbandingan harga akan ditampilkan di sini</p>
            </div>
        </div>
    </div>
</div>

<!-- Add Price Modal -->
<div id="addPriceModal" data-modal="overlay" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0, 0, 0, 0.5); z-index: 9999; padding: 1rem; overflow-y: auto;">
    <div class="bg-white rounded-xl max-w-2xl w-full mx-auto my-8">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900">Tambah Harga Baru</h3>
                <button onclick="closeModal('addPriceModal')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        
        <form class="p-6 space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rute</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option>Pilih Rute</option>
                        <option>Medan - Pematang Siantar</option>
                        <option>Medan - Rantau Prapat</option>
                        <option>Medan - Sibolga</option>
                        <option>Medan - Berastagi</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Bus</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option>Executive</option>
                        <option>VIP</option>
                        <option>Economy</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Harga Dasar (Rp)</label>
                    <input type="number" placeholder="75000" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Harga Weekend (Rp)</label>
                    <input type="number" placeholder="85000" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Peak Season (Rp)</label>
                    <input type="number" placeholder="95000" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>

            <div>
                <label class="flex items-center">
                    <input type="checkbox" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <span class="ml-2 text-sm text-gray-700">Aktifkan Dynamic Pricing</span>
                </label>
            </div>

            <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200">
                <button type="button" onclick="closeModal('addPriceModal')" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                    <i class="fas fa-save mr-2"></i>Simpan
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
