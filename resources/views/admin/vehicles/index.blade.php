@extends('layouts.admin')

@section('title', 'Kelola Armada')
@section('page-title', 'Kelola Armada')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Daftar Kendaraan</h2>
            <p class="text-gray-600 mt-1">Kelola armada bus dan seat configuration</p>
        </div>
        <button onclick="openModal('createVehicleModal')" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg flex items-center font-medium">
            <i class="fas fa-plus mr-2"></i>Tambah Kendaraan
        </button>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Armada</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ App\Models\Bus::count() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-bus text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Aktif</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">{{ App\Models\Bus::where('status', 'active')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Maintenance</p>
                    <p class="text-3xl font-bold text-orange-600 mt-2">{{ App\Models\Bus::where('status', 'maintenance')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-wrench text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Tidak Aktif</p>
                    <p class="text-3xl font-bold text-gray-600 mt-2">{{ App\Models\Bus::where('status', 'inactive')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-times-circle text-gray-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Fleet Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($buses ?? [] as $bus)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
            <!-- Image -->
            <div class="h-48 bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                <i class="fas fa-bus text-6xl text-blue-600 opacity-50"></i>
            </div>

            <!-- Content -->
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">{{ $bus->plate_number }}</h3>
                        <p class="text-sm text-gray-600 mt-1">{{ $bus->bus_type }}</p>
                    </div>
                    @if($bus->status == 'active')
                        <span class="px-3 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">Aktif</span>
                    @elseif($bus->status == 'maintenance')
                        <span class="px-3 py-1 text-xs font-medium bg-orange-100 text-orange-700 rounded-full">Maintenance</span>
                    @else
                        <span class="px-3 py-1 text-xs font-medium bg-gray-100 text-gray-700 rounded-full">Non-aktif</span>
                    @endif
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <p class="text-xs text-gray-600">Kapasitas</p>
                        <p class="text-lg font-bold text-gray-900">{{ $bus->total_seats }} kursi</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600">Tahun</p>
                        <p class="text-lg font-bold text-gray-900">{{ $bus->manufacture_year ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="mb-4">
                    <p class="text-xs text-gray-600">Fasilitas</p>
                    <p class="text-sm text-gray-700">{{ $bus->facilities ?? 'AC, Reclining Seat, TV, Toilet' }}</p>
                </div>

                <!-- Actions -->
                <div class="flex items-center space-x-2">
                    <a href="{{ route('admin.vehicles.edit', $bus->id) }}" class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors text-center">
                        <i class="fas fa-edit mr-1"></i>Edit
                    </a>
                    <a href="{{ route('admin.vehicles.show', $bus->id) }}" class="px-4 py-2 bg-purple-100 hover:bg-purple-200 text-purple-700 rounded-lg text-sm font-medium transition-colors">
                        <i class="fas fa-eye"></i>
                    </a>
                    <form action="{{ route('admin.vehicles.destroy', $bus->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus bus ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg text-sm font-medium transition-colors">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-12">
            <i class="fas fa-bus text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500">Belum ada kendaraan tersedia</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if(isset($buses) && $buses->hasPages())
    <div class="mt-6">
        {{ $buses->links() }}
    </div>
    @endif
</div>

<!-- Create Vehicle Modal -->
<!-- @formatter:off -->
<div id="createVehicleModal" data-modal="overlay" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0, 0, 0, 0.5); z-index: 9999; padding: 1rem; overflow-y: auto;">
<!-- @formatter:on -->
    <div class="bg-white rounded-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto mx-auto my-8">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900">Tambah Kendaraan Baru</h3>
                <button onclick="closeModal('createVehicleModal')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        
        <form class="p-6 space-y-6">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Polisi *</label>
                    <input type="text" placeholder="B-1234-ABC" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Kendaraan *</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option>Mercedes-Benz OH 1526</option>
                        <option>Hino RK8</option>
                        <option>Scania K360</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kapasitas *</label>
                    <input type="number" value="48" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                    <input type="number" placeholder="2023" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Warna</label>
                    <input type="text" placeholder="Putih" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Kendaraan</label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-500 transition-colors cursor-pointer">
                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                    <p class="text-sm text-gray-600">Klik untuk upload atau drag & drop</p>
                    <p class="text-xs text-gray-500 mt-1">PNG, JPG hingga 5MB</p>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Konfigurasi Seat Map</label>
                <a href="{{ route('admin.vehicles.seatmap') }}" class="inline-flex items-center px-4 py-2 border-2 border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition-colors">
                    <i class="fas fa-th mr-2"></i>Buka Seat Map Editor
                </a>
            </div>

            <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200">
                <button type="button" onclick="closeModal('createVehicleModal')" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                    <i class="fas fa-save mr-2"></i>Simpan Kendaraan
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
