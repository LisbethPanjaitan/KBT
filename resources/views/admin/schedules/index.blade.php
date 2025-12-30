@extends('layouts.admin')

@section('title', 'Kelola Jadwal')
@section('page-title', 'Kelola Jadwal')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Jadwal Keberangkatan</h2>
            <p class="text-gray-600 mt-1">Kelola jadwal perjalanan bus</p>
        </div>
        <div class="flex space-x-3">
            <button onclick="openModal('importScheduleModal')" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-upload mr-2"></i>Import
            </button>
            <a href="{{ route('admin.schedules.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg flex items-center font-medium">
                <i class="fas fa-plus mr-2"></i>Tambah Jadwal
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <p class="text-sm text-gray-600">Jadwal Hari Ini</p>
            <p class="text-3xl font-bold text-blue-600 mt-2">{{ $stats['today'] ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <p class="text-sm text-gray-600">Aktif</p>
            <p class="text-3xl font-bold text-green-600 mt-2">{{ $stats['active'] ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <p class="text-sm text-gray-600">Dalam Perjalanan</p>
            <p class="text-3xl font-bold text-orange-600 mt-2">{{ $stats['departed'] ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <p class="text-sm text-gray-600">Dibatalkan</p>
            <p class="text-3xl font-bold text-red-600 mt-2">{{ $stats['cancelled'] ?? 0 }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.schedules.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div class="md:col-span-2">
                <select name="route_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Rute</option>
                    @foreach(\App\Models\Route::all() as $route)
                        <option value="{{ $route->id }}" {{ request('route_id') == $route->id ? 'selected' : '' }}>
                            {{ $route->origin_city }} - {{ $route->destination_city }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <input type="date" name="date" value="{{ request('date') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Status</option>
                    <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Active</option>
                    <option value="departed" {{ request('status') == 'departed' ? 'selected' : '' }}>Departed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center justify-center font-bold">
                    <i class="fas fa-filter mr-2"></i> Filter
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Tanggal & Waktu</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Rute</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Bus</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Harga</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Kapasitas</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Terisi</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($schedules as $schedule)
                    @php
                        // FIX: Gunakan null-safe operator untuk mencegah crash jika bus null
                        $totalCap = $schedule->bus?->total_seats ?? 0;
                        $bookedSeats = $schedule->booked_seats_count ?? ($totalCap - $schedule->available_seats);
                        $fillPercentage = $totalCap > 0 ? ($bookedSeats / $totalCap) * 100 : 0;
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($schedule->departure_date)->format('d M Y') }}</p>
                            <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($schedule->departure_time)->format('H:i') }} WIB</p>
                        </td>
                        <td class="px-6 py-4">
                            {{-- FIX: Gunakan null-safe operator (?->) dan null coalescing (??) untuk rute --}}
                            <p class="font-semibold text-gray-900">
                                {{ $schedule->route?->origin_city ?? 'Rute Tidak Ditemukan' }} → {{ $schedule->route?->destination_city ?? 'N/A' }}
                            </p>
                            <p class="text-xs text-gray-500">
                                @if($schedule->route)
                                    ~{{ floor($schedule->route->estimated_duration_minutes / 60) }} jam {{ $schedule->route->estimated_duration_minutes % 60 }} menit
                                @else
                                    Durasi tidak tersedia
                                @endif
                            </p>
                        </td>
                        <td class="px-6 py-4 text-gray-700 font-medium">
                            {{ $schedule->bus?->plate_number ?? 'Bus Tidak Ditemukan' }}
                        </td>
                        <td class="px-6 py-4 font-bold text-blue-600">
                            Rp {{ number_format($schedule->price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-gray-600 text-sm">
                            {{ $totalCap }} kursi
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <span class="mr-2 text-xs font-bold {{ $bookedSeats >= $totalCap && $totalCap > 0 ? 'text-red-600' : 'text-gray-700' }}">
                                    {{ $bookedSeats }}
                                </span>
                                <div class="w-16 bg-gray-200 rounded-full h-1.5">
                                    <div class="h-1.5 rounded-full {{ $bookedSeats >= $totalCap && $totalCap > 0 ? 'bg-red-500' : 'bg-blue-600' }}" 
                                         style="width: {{ $fillPercentage }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $badgeClass = [
                                    'scheduled' => 'bg-green-100 text-green-700',
                                    'departed'  => 'bg-blue-100 text-blue-700',
                                    'arrived'   => 'bg-gray-100 text-gray-700',
                                    'cancelled' => 'bg-red-100 text-red-700',
                                ][$schedule->status] ?? 'bg-gray-100 text-gray-700';
                            @endphp
                            <span class="px-3 py-1 text-[10px] font-black uppercase rounded-full {{ $badgeClass }}">
                                {{ $schedule->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.schedules.edit', $schedule->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit Jadwal">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('admin.schedules.show', $schedule->id) }}" class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition" title="Detail Penumpang">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus jadwal ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-gray-400 italic">
                            <i class="fas fa-calendar-times text-4xl mb-3 opacity-20"></i>
                            <p>Belum ada jadwal tersedia.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $schedules->links() }}
        </div>
    </div>
</div>

<div id="createScheduleModal" data-modal="overlay" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0, 0, 0, 0.5); z-index: 9999; padding: 1rem; overflow-y: auto;">
    <div class="bg-white rounded-xl max-w-3xl w-full mx-auto my-8 shadow-2xl">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-xl font-bold text-gray-900">Buat Jadwal Baru</h3>
            <button onclick="closeModal('createScheduleModal')" class="text-gray-400 hover:text-gray-600 transition">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <form action="{{ route('admin.schedules.store') }}" method="POST" class="p-6 space-y-6">
            @csrf
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Rute *</label>
                    <select name="route_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Rute</option>
                        @foreach(\App\Models\Route::where('status', 'active')->get() as $route)
                            <option value="{{ $route->id }}">{{ $route->origin_city }} → {{ $route->destination_city }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Bus *</label>
                    <select name="bus_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Bus</option>
                        @foreach(\App\Models\Bus::where('status', 'active')->get() as $bus)
                            <option value="{{ $bus->id }}">{{ $bus->plate_number }} ({{ $bus->total_seats }} kursi)</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal *</label>
                    <input type="date" name="departure_date" required min="{{ date('Y-m-d') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Waktu Berangkat *</label>
                    <input type="time" name="departure_time" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Estimasi Tiba *</label>
                    <input type="time" name="arrival_time" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Harga (Kosongkan = Ikuti Base Price)</label>
                    <input type="number" name="price" min="0" step="1000" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="Opsional">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Status *</label>
                    <select name="status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="scheduled">Scheduled (Terjadwal)</option>
                        <option value="departed">Departed</option>
                        <option value="arrived">Arrived</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
            </div>

            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                <p class="text-sm text-yellow-800"><i class="fas fa-info-circle mr-2"></i><strong>Penting:</strong> Pastikan status "Scheduled" agar muncul di pencarian user!</p>
            </div>

            <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200">
                <button type="button" onclick="closeModal('createScheduleModal')" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit" class="px-8 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-bold">
                    <i class="fas fa-save mr-2"></i>Simpan Jadwal
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