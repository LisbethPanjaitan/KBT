@extends('layouts.admin')

@section('title', 'Kelola Rute')
@section('page-title', 'Manajemen Rute Perjalanan')

@section('content')
<div class="space-y-6">
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

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.routes.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div class="md:col-span-4">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari rute (Kota Asal / Tujuan)..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors font-bold uppercase tracking-widest text-xs">
                    <i class="fas fa-search mr-2"></i>Cari
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-wider">Rute</th>
                        <th class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-wider">Detail</th>
                        <th class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-wider">Harga</th>
                        <th class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($routes as $route)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center mr-3">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900 uppercase tracking-tighter">{{ $route->origin_city }} <i class="fas fa-arrow-right mx-1 text-xs text-gray-300"></i> {{ $route->destination_city }}</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase">{{ $route->origin_terminal }} - {{ $route->destination_terminal }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-xs font-bold text-gray-600 uppercase">{{ $route->distance_km }} KM</p>
                            <p class="text-[10px] text-gray-400 uppercase">{{ floor($route->estimated_duration_minutes / 60) }}j {{ $route->estimated_duration_minutes % 60 }}m</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-black text-gray-900">Rp {{ number_format($route->base_price, 0, ',', '.') }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-[10px] font-black rounded-full uppercase tracking-widest {{ $route->status == 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $route->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.routes.edit', $route->id) }}" class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition shadow-sm">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                <form action="{{ route('admin.routes.destroy', $route->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus rute ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition shadow-sm">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic font-bold uppercase tracking-widest">Data Rute Belum Tersedia</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $routes->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<div id="createRouteModal" class="fixed inset-0 z-[9999] hidden bg-black bg-opacity-50 overflow-y-auto" onclick="if(event.target == this) closeModal('createRouteModal')">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full">
            <div class="p-8 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-black text-gray-900 uppercase italic tracking-tighter">Tambah Rute Perjalanan Baru</h3>
                    <button onclick="closeModal('createRouteModal')" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            
            <form action="{{ route('admin.routes.store') }}" method="POST" class="p-8 space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Kota Asal *</label>
                        <input type="text" name="origin_city" required placeholder="Contoh: Medan" class="w-full px-4 py-3 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-50">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Terminal Asal *</label>
                        <input type="text" name="origin_terminal" required placeholder="Contoh: Terminal Amplas" class="w-full px-4 py-3 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-50">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Kota Tujuan *</label>
                        <input type="text" name="destination_city" required placeholder="Contoh: Sibolga" class="w-full px-4 py-3 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-50">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Terminal Tujuan *</label>
                        <input type="text" name="destination_terminal" required placeholder="Contoh: Terminal Sibolga" class="w-full px-4 py-3 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-50">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Jarak (KM) *</label>
                        <input type="number" name="distance_km" required placeholder="320" class="w-full px-4 py-3 border border-gray-200 rounded-2xl">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Durasi (Menit) *</label>
                        <input type="number" name="estimated_duration_minutes" required placeholder="480" class="w-full px-4 py-3 border border-gray-200 rounded-2xl">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Harga Dasar (Rp) *</label>
                        <input type="number" name="base_price" required placeholder="150000" class="w-full px-4 py-3 border border-gray-200 rounded-2xl">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Status Operasional *</label>
                    <select name="status" required class="w-full px-4 py-3 border border-gray-200 rounded-2xl">
                        <option value="active">AKTIF (TERSEDIA UNTUK JADWAL)</option>
                        <option value="inactive">NON-AKTIF (DISEMBUNYIKAN)</option>
                    </select>
                </div>

                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-100">
                    <button type="button" onclick="closeModal('createRouteModal')" class="px-8 py-3 text-xs font-black text-gray-400 uppercase tracking-widest hover:text-gray-600 transition">BATAL</button>
                    <button type="submit" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-black uppercase tracking-widest shadow-lg shadow-blue-100 transition transform active:scale-95">SIMPAN RUTE</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openModal(id) {
    const modal = document.getElementById(id);
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}
function closeModal(id) {
    const modal = document.getElementById(id);
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}
</script>
@endpush