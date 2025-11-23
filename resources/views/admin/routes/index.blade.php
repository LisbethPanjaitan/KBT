@extends('layouts.admin')

@section('title', 'Kelola Rute')
@section('page-title', 'Manajemen Rute Perjalanan')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Kelola Rute</h2>
            <p class="text-gray-600 mt-1">Manajemen rute perjalanan bus di Sumatera Utara</p>
        </div>
        <button onclick="openModal('createRouteModal')" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg flex items-center font-medium transition-colors">
            <i class="fas fa-plus mr-2"></i>
            Tambah Rute
        </button>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Rute</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ App\Models\Route::count() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-route text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Rute Aktif</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">{{ App\Models\Route::where('status', 'active')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Jadwal</p>
                    <p class="text-3xl font-bold text-purple-600 mt-2">{{ App\Models\Schedule::where('departure_date', '>=', date('Y-m-d'))->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Kota Terhubung</p>
                    <p class="text-3xl font-bold text-orange-600 mt-2">{{ collect(App\Models\Route::pluck('origin_city')->merge(App\Models\Route::pluck('destination_city')))->unique()->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-map-marked-alt text-orange-600 text-xl"></i>
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
                    <option>Rantau Prapat</option>
                </select>
            </div>
            <div>
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option>Semua Kota Tujuan</option>
                    <option>Medan</option>
                    <option>Sibolga</option>
                    <option>Padang Sidempuan</option>
                    <option>Berastagi</option>
                </select>
            </div>
            <div>
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option>Semua Status</option>
                    <option>Aktif</option>
                    <option>Non-aktif</option>
                </select>
            </div>
            <div>
                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-search mr-2"></i>Cari
                </button>
            </div>
        </div>
    </div>

    <!-- Routes Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Rute</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jarak</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Durasi</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Harga</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jadwal/Hari</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($routes as $route)
                    @php
                        $schedulesCount = $route->schedules()->where('departure_date', '>=', date('Y-m-d'))->count();
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <i class="fas fa-arrow-right text-blue-600 mr-3"></i>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $route->origin_city }} → {{ $route->destination_city }}</p>
                                    <p class="text-xs text-gray-500">{{ $route->origin_terminal }} - {{ $route->destination_terminal }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-900">{{ $route->distance_km }} km</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-900">{{ floor($route->estimated_duration_minutes / 60) }} jam {{ $route->estimated_duration_minutes % 60 }} menit</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-semibold text-gray-900">Rp {{ number_format($route->base_price, 0, ',', '.') }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">
                                {{ $schedulesCount }} jadwal
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($route->status == 'active')
                                <span class="flex items-center text-green-600">
                                    <span class="w-2 h-2 bg-green-600 rounded-full mr-2"></span>
                                    Aktif
                                </span>
                            @else
                                <span class="flex items-center text-gray-600">
                                    <span class="w-2 h-2 bg-gray-600 rounded-full mr-2"></span>
                                    Non-aktif
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.routes.edit', $route->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('admin.routes.show', $route->id) }}" class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.routes.destroy', $route->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus rute ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-route text-4xl mb-2"></i>
                            <p>Belum ada rute tersedia</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $routes->links() }}
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

    <!-- Route Map Preview -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Peta Jaringan Rute KBT di Sumatera Utara</h3>
        <div class="bg-gray-100 rounded-lg h-96 flex items-center justify-center">
            <div class="text-center text-gray-500">
                <i class="fas fa-map-marked-alt text-6xl mb-4"></i>
                <p>Peta interaktif jaringan rute akan ditampilkan di sini</p>
                <p class="text-sm mt-2">Menghubungkan 15 kota di Sumatera Utara</p>
            </div>
        </div>
    </div>
</div>

<!-- Create Route Modal -->
<div id="createRouteModal" data-modal="overlay" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0, 0, 0, 0.5); z-index: 9999; padding: 1rem; overflow-y: auto;">
    <div class="bg-white rounded-xl max-w-2xl w-full mx-auto my-8">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900">Tambah Rute Baru</h3>
                <button onclick="closeModal('createRouteModal')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        
        <form class="p-6 space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kota Asal</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option>Pilih Kota Asal</option>
                        <option>Medan</option>
                        <option>Binjai</option>
                        <option>Tebing Tinggi</option>
                        <option>Pematang Siantar</option>
                        <option>Rantau Prapat</option>
                        <option>Kisaran</option>
                        <option>Tanjung Balai</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kota Tujuan</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option>Pilih Kota Tujuan</option>
                        <option>Medan</option>
                        <option>Sibolga</option>
                        <option>Padang Sidempuan</option>
                        <option>Berastagi</option>
                        <option>Kabanjahe</option>
                        <option>Balige</option>
                        <option>Tarutung</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jarak (km)</label>
                    <input type="number" placeholder="128" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Estimasi Durasi (jam)</label>
                    <input type="number" step="0.5" placeholder="2.5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Harga Dasar (Rp)</label>
                    <input type="number" placeholder="75000" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option>Aktif</option>
                        <option>Non-aktif</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Rute</label>
                <textarea rows="3" placeholder="Rute melalui jalur utama Sumatera..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
            </div>

            <div>
                <label class="flex items-center">
                    <input type="checkbox" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <span class="ml-2 text-sm text-gray-700">Tandai sebagai rute populer</span>
                </label>
            </div>

            <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200">
                <button type="button" onclick="closeModal('createRouteModal')" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
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
