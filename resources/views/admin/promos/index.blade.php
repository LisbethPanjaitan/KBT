@extends('layouts.admin')

@section('title', 'Kelola Promo')
@section('page-title', 'Manajemen Promo & Diskon')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Kelola Promo & Diskon</h2>
            <p class="text-gray-600 mt-1">Manajemen kode promo, voucher, dan diskon</p>
        </div>
        <button onclick="openModal('createPromoModal')" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg flex items-center font-medium transition-colors">
            <i class="fas fa-plus mr-2"></i>
            Buat Promo Baru
        </button>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Promo Aktif</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">8</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-tags text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Penggunaan</p>
                    <p class="text-3xl font-bold text-blue-600 mt-2">1,234</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-ticket-alt text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Diskon</p>
                    <p class="text-2xl font-bold text-orange-600 mt-2">Rp 15.8jt</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Akan Expired</p>
                    <p class="text-3xl font-bold text-red-600 mt-2">3</p>
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
                <input type="text" placeholder="Cari kode promo..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div>
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option>Semua Status</option>
                    <option>Aktif</option>
                    <option>Terjadwal</option>
                    <option>Expired</option>
                    <option>Non-aktif</option>
                </select>
            </div>
            <div>
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option>Semua Tipe</option>
                    <option>Persentase</option>
                    <option>Nominal</option>
                </select>
            </div>
            <div>
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option>Semua Rute</option>
                    <option>Medan - Pematang Siantar</option>
                    <option>Medan - Rantau Prapat</option>
                    <option>Medan - Sibolga</option>
                </select>
            </div>
            <div>
                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-search mr-2"></i>Cari
                </button>
            </div>
        </div>
    </div>

    <!-- Promo List -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @php
            $promos = [
                [
                    'code' => 'WEEKEND50',
                    'name' => 'Weekend Special',
                    'type' => 'percentage',
                    'value' => 50,
                    'min_purchase' => 100000,
                    'max_discount' => 50000,
                    'usage' => 245,
                    'limit' => 500,
                    'valid_from' => '2025-11-01',
                    'valid_until' => '2025-11-30',
                    'routes' => ['Semua rute'],
                    'status' => 'active'
                ],
                [
                    'code' => 'NEWUSER',
                    'name' => 'Diskon Pengguna Baru',
                    'type' => 'nominal',
                    'value' => 25000,
                    'min_purchase' => 75000,
                    'max_discount' => 25000,
                    'usage' => 89,
                    'limit' => 1000,
                    'valid_from' => '2025-11-01',
                    'valid_until' => '2025-12-31',
                    'routes' => ['Semua rute'],
                    'status' => 'active'
                ],
                [
                    'code' => 'MEDAN50K',
                    'name' => 'Promo Medan',
                    'type' => 'nominal',
                    'value' => 50000,
                    'min_purchase' => 150000,
                    'max_discount' => 50000,
                    'usage' => 156,
                    'limit' => 300,
                    'valid_from' => '2025-11-15',
                    'valid_until' => '2025-11-25',
                    'routes' => ['Medan - Pematang Siantar', 'Medan - Rantau Prapat'],
                    'status' => 'active'
                ],
                [
                    'code' => 'LEBARAN30',
                    'name' => 'Promo Lebaran',
                    'type' => 'percentage',
                    'value' => 30,
                    'min_purchase' => 100000,
                    'max_discount' => 75000,
                    'usage' => 0,
                    'limit' => 1000,
                    'valid_from' => '2026-03-20',
                    'valid_until' => '2026-04-05',
                    'routes' => ['Semua rute'],
                    'status' => 'scheduled'
                ],
                [
                    'code' => 'EARLYBIRD',
                    'name' => 'Early Bird Discount',
                    'type' => 'percentage',
                    'value' => 20,
                    'min_purchase' => 50000,
                    'max_discount' => 40000,
                    'usage' => 367,
                    'limit' => 500,
                    'valid_from' => '2025-10-01',
                    'valid_until' => '2025-11-24',
                    'routes' => ['Medan - Berastagi', 'Medan - Kabanjahe'],
                    'status' => 'active'
                ],
                [
                    'code' => 'FLASH50',
                    'name' => 'Flash Sale',
                    'type' => 'percentage',
                    'value' => 50,
                    'min_purchase' => 200000,
                    'max_discount' => 100000,
                    'usage' => 500,
                    'limit' => 500,
                    'valid_from' => '2025-10-15',
                    'valid_until' => '2025-10-31',
                    'routes' => ['Semua rute'],
                    'status' => 'expired'
                ],
            ];
        @endphp

        @foreach($promos as $promo)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
            <div class="p-6">
                <!-- Header -->
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <div class="flex items-center space-x-3 mb-2">
                            <h3 class="text-xl font-bold text-gray-900">{{ $promo['name'] }}</h3>
                            <span class="px-3 py-1 text-xs font-bold rounded-full
                                {{ $promo['status'] == 'active' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $promo['status'] == 'scheduled' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $promo['status'] == 'expired' ? 'bg-red-100 text-red-700' : '' }}">
                                {{ $promo['status'] == 'active' ? 'AKTIF' : '' }}
                                {{ $promo['status'] == 'scheduled' ? 'TERJADWAL' : '' }}
                                {{ $promo['status'] == 'expired' ? 'EXPIRED' : '' }}
                            </span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-bold rounded-lg text-lg">
                                {{ $promo['code'] }}
                            </span>
                            <button class="p-2 text-gray-400 hover:text-gray-600" onclick="copyPromoCode('{{ $promo['code'] }}')">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Discount Info -->
                <div class="bg-gradient-to-r from-orange-50 to-red-50 rounded-lg p-4 mb-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Nilai Diskon</p>
                            <p class="text-3xl font-bold text-orange-600">
                                @if($promo['type'] == 'percentage')
                                    {{ $promo['value'] }}%
                                @else
                                    Rp {{ number_format($promo['value'], 0, ',', '.') }}
                                @endif
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-600 mb-1">Maks. Diskon</p>
                            <p class="text-xl font-bold text-gray-900">Rp {{ number_format($promo['max_discount'], 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Details -->
                <div class="space-y-3 mb-4">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Min. Pembelian</span>
                        <span class="font-semibold text-gray-900">Rp {{ number_format($promo['min_purchase'], 0, ',', '.') }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Periode</span>
                        <span class="font-semibold text-gray-900">
                            {{ date('d M Y', strtotime($promo['valid_from'])) }} - {{ date('d M Y', strtotime($promo['valid_until'])) }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Penggunaan</span>
                        <span class="font-semibold text-gray-900">{{ $promo['usage'] }} / {{ $promo['limit'] }}</span>
                    </div>
                    
                    <!-- Progress Bar -->
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ ($promo['usage'] / $promo['limit']) * 100 }}%"></div>
                    </div>
                </div>

                <!-- Routes -->
                <div class="mb-4">
                    <p class="text-xs text-gray-500 mb-2">Berlaku untuk:</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($promo['routes'] as $route)
                        <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded">{{ $route }}</span>
                        @endforeach
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center space-x-2 pt-4 border-t border-gray-200">
                    <button class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors text-sm">
                        <i class="fas fa-edit mr-2"></i>Edit
                    </button>
                    <button class="px-4 py-2 bg-green-100 text-green-700 hover:bg-green-200 rounded-lg transition-colors text-sm">
                        <i class="fas fa-chart-bar"></i>
                    </button>
                    <button class="px-4 py-2 bg-purple-100 text-purple-700 hover:bg-purple-200 rounded-lg transition-colors text-sm">
                        <i class="fas fa-copy"></i>
                    </button>
                    <button class="px-4 py-2 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg transition-colors text-sm">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Create Promo Modal -->
<div id="createPromoModal" data-modal="overlay" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0, 0, 0, 0.5); z-index: 9999; padding: 1rem; overflow-y: auto;">
    <div class="bg-white rounded-xl max-w-3xl w-full mx-auto my-8">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900">Buat Promo Baru</h3>
                <button onclick="closeModal('createPromoModal')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        
        <form class="p-6 space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Promo</label>
                    <input type="text" placeholder="Weekend Special" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kode Promo</label>
                    <input type="text" placeholder="WEEKEND50" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Diskon</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="percentage">Persentase (%)</option>
                        <option value="nominal">Nominal (Rp)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nilai Diskon</label>
                    <input type="number" placeholder="50" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Maks. Diskon (Rp)</label>
                    <input type="number" placeholder="50000" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Min. Pembelian (Rp)</label>
                    <input type="number" placeholder="100000" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Limit Penggunaan</label>
                    <input type="number" placeholder="500" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Berlaku Dari</label>
                    <input type="date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Berlaku Sampai</label>
                    <input type="date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
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
                <button type="button" onclick="closeModal('createPromoModal')" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                    <i class="fas fa-save mr-2"></i>Simpan Promo
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

function copyPromoCode(code) {
    navigator.clipboard.writeText(code);
    alert('Kode promo "' + code + '" berhasil disalin!');
}
</script>
@endpush
