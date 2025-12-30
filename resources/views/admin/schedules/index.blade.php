@extends('layouts.admin')

@section('title', 'Kelola Jadwal')
@section('page-title', 'Kelola Jadwal')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-black text-gray-900 uppercase italic tracking-tighter">Jadwal Keberangkatan</h2>
            <p class="text-xs text-gray-500 font-bold uppercase mt-1">Manajemen operasional armada bus KBT</p>
        </div>
        <div class="flex space-x-3">
            <button onclick="openModal('createScheduleModal')" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl flex items-center font-black uppercase tracking-widest text-xs shadow-lg shadow-blue-100 transition transform active:scale-95">
                <i class="fas fa-plus mr-2"></i>Tambah Jadwal
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 border-l-4 border-l-blue-500">
            <p class="text-[10px] font-black text-gray-400 uppercase">Jadwal Hari Ini</p>
            <p class="text-2xl font-black text-blue-600 mt-1">{{ $stats['today'] ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 border-l-4 border-l-green-500">
            <p class="text-[10px] font-black text-gray-400 uppercase">Aktif (Scheduled)</p>
            <p class="text-2xl font-black text-green-600 mt-1">{{ $stats['active'] ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 border-l-4 border-l-orange-500">
            <p class="text-[10px] font-black text-gray-400 uppercase">Dalam Perjalanan</p>
            <p class="text-2xl font-black text-orange-600 mt-1">{{ $stats['departed'] ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 border-l-4 border-l-red-500">
            <p class="text-[10px] font-black text-gray-400 uppercase">Dibatalkan</p>
            <p class="text-2xl font-black text-red-600 mt-1">{{ $stats['cancelled'] ?? 0 }}</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.schedules.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-6 gap-4">
            <div class="md:col-span-2">
                <label class="text-[10px] font-black text-gray-400 uppercase mb-1 block">Rute</label>
                <select name="route_id" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none text-sm font-bold uppercase">
                    <option value="">Semua Rute</option>
                    @foreach($routes as $r)
                        <option value="{{ $r->id }}" {{ request('route_id') == $r->id ? 'selected' : '' }}>
                            {{ $r->origin_city }} → {{ $r->destination_city }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-[10px] font-black text-gray-400 uppercase mb-1 block">Tanggal</label>
                <input type="date" name="date" value="{{ request('date') }}" class="w-full px-4 py-2 border border-gray-200 rounded-xl outline-none text-sm font-bold">
            </div>
            <div>
                <label class="text-[10px] font-black text-gray-400 uppercase mb-1 block">Status</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-200 rounded-xl outline-none text-sm font-bold uppercase">
                    <option value="">Semua</option>
                    <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                    <option value="departed" {{ request('status') == 'departed' ? 'selected' : '' }}>Departed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="flex items-end space-x-2 md:col-span-2">
                <button type="submit" class="flex-1 bg-gray-900 text-white px-4 py-2 rounded-xl font-black uppercase text-[10px] tracking-widest hover:bg-black transition">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
                <a href="{{ route('admin.schedules.index') }}" class="p-2 bg-gray-100 text-gray-500 rounded-xl hover:bg-gray-200" title="Reset Filter">
                    <i class="fas fa-undo"></i>
                </a>
                <a href="{{ route('admin.schedules.calendar') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-xl flex items-center justify-center font-black uppercase text-[10px] tracking-widest transition">
                    <i class="fas fa-calendar-alt mr-2"></i>Kalender
                </a>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Waktu Keberangkatan</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Rute Perjalanan</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Unit Bus</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Harga</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Kapasitas</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Edit Status</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($schedules as $schedule)
                    @php
                        $totalCap = $schedule->bus?->total_seats ?? 0;
                        $bookedSeats = $schedule->booked_seats_count ?? 0; 
                        $fillPercentage = ($totalCap > 0) ? ($bookedSeats / $totalCap) * 100 : 0;
                    @endphp
                    <tr class="hover:bg-blue-50/30 transition">
                        <td class="px-6 py-4">
                            <p class="font-bold text-gray-900 text-sm uppercase italic">{{ \Carbon\Carbon::parse($schedule->departure_date)->format('d M Y') }}</p>
                            <p class="text-[10px] font-black text-blue-500 uppercase">{{ \Carbon\Carbon::parse($schedule->departure_time)->format('H:i') }} WIB</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-black text-gray-800 text-xs uppercase italic">
                                {{ $schedule->route?->origin_city ?? 'DELETED' }} → {{ $schedule->route?->destination_city ?? 'N/A' }}
                            </p>
                            <p class="text-[9px] text-gray-400 font-bold uppercase mt-1">Estimasi Tiba: {{ \Carbon\Carbon::parse($schedule->estimated_arrival_time)->format('H:i') }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 bg-gray-100 rounded text-[10px] font-black text-gray-600 uppercase tracking-tighter">
                                {{ $schedule->bus?->plate_number ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-black text-gray-900 text-xs">
                            Rp {{ number_format($schedule->price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-black {{ $bookedSeats >= $totalCap && $totalCap > 0 ? 'text-red-600' : 'text-gray-500' }} mb-1 uppercase">
                                    {{ $bookedSeats }} / {{ $totalCap }} Terisi
                                </span>
                                <div class="w-20 bg-gray-100 rounded-full h-1.5 overflow-hidden">
                                    <div class="h-full {{ $bookedSeats >= $totalCap && $totalCap > 0 ? 'bg-red-500' : 'bg-blue-600' }}" style="width: {{ $fillPercentage }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <form action="{{ route('admin.schedules.updateStatus', $schedule->id) }}" method="POST">
                                @csrf @method('PUT')
                                <select name="status" onchange="if(confirm('Ubah status operasional bus?')) this.form.submit()" class="text-[9px] font-black border-gray-200 rounded-lg p-1 pr-6 uppercase outline-none focus:ring-2 focus:ring-blue-500
                                    {{ $schedule->status == 'scheduled' ? 'bg-green-50 text-green-700' : '' }}
                                    {{ $schedule->status == 'departed' ? 'bg-blue-50 text-blue-700' : '' }}
                                    {{ $schedule->status == 'cancelled' ? 'bg-red-50 text-red-700' : '' }}
                                ">
                                    <option value="scheduled" {{ $schedule->status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                    <option value="departed" {{ $schedule->status == 'departed' ? 'selected' : '' }}>Departed</option>
                                    <option value="arrived" {{ $schedule->status == 'arrived' ? 'selected' : '' }}>Arrived</option>
                                    <option value="cancelled" {{ $schedule->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </form>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <a href="{{ route('admin.schedules.show', $schedule->id) }}" class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition shadow-sm">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>
                                <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('Hapus jadwal?')">
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
                        <td colspan="7" class="px-6 py-20 text-center">
                            <div class="opacity-20 flex flex-col items-center">
                                <i class="fas fa-calendar-times text-5xl mb-3"></i>
                                <p class="font-black uppercase tracking-widest text-xs">Data Jadwal Tidak Ditemukan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $schedules->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<div id="createScheduleModal" class="fixed inset-0 z-[9999] hidden bg-black bg-opacity-50 overflow-y-auto" onclick="if(event.target == this) closeModal('createScheduleModal')">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full overflow-hidden">
            <div class="p-8 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
                <h3 class="text-xl font-black text-gray-900 uppercase italic tracking-tighter">Buat Jadwal Operasional Baru</h3>
                <button onclick="closeModal('createScheduleModal')" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times text-xl"></i></button>
            </div>
            
            <form action="{{ route('admin.schedules.store') }}" method="POST" class="p-8 space-y-6">
                @csrf
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Pilih Rute Perjalanan *</label>
                        <select name="route_id" required class="w-full px-4 py-3 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-50 font-bold text-sm">
                            <option value="">-- PILIH RUTE --</option>
                            @foreach($routes as $route)
                                <option value="{{ $route->id }}">{{ $route->origin_city }} → {{ $route->destination_city }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Unit Armada *</label>
                        <select name="bus_id" required class="w-full px-4 py-3 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-50 font-bold text-sm">
                            <option value="">-- PILIH BUS --</option>
                            @foreach(\App\Models\Bus::where('status', 'active')->get() as $bus)
                                <option value="{{ $bus->id }}">{{ $bus->plate_number }} ({{ $bus->total_seats }} Kursi)</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-6">
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Tanggal *</label>
                        <input type="date" name="departure_date" required min="{{ date('Y-m-d') }}" class="w-full px-4 py-3 border border-gray-200 rounded-2xl font-bold">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Waktu Berangkat *</label>
                        <input type="time" name="departure_time" required class="w-full px-4 py-3 border border-gray-200 rounded-2xl font-bold">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Estimasi Tiba *</label>
                        <input type="time" name="arrival_time" required class="w-full px-4 py-3 border border-gray-200 rounded-2xl font-bold">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Harga Tiket (Rp)</label>
                        <input type="number" name="price" placeholder="Ikuti harga rute" class="w-full px-4 py-3 border border-gray-200 rounded-2xl font-bold">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Status *</label>
                        <select name="status" required class="w-full px-4 py-3 border border-gray-200 rounded-2xl font-bold">
                            <option value="scheduled">SCHEDULED</option>
                            <option value="departed">DEPARTED</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-100">
                    <button type="button" onclick="closeModal('createScheduleModal')" class="px-8 py-3 text-xs font-black text-gray-400 uppercase tracking-widest">BATAL</button>
                    <button type="submit" class="px-10 py-3 bg-blue-600 text-white rounded-2xl font-black uppercase tracking-widest text-xs shadow-lg shadow-blue-100 transition transform active:scale-95">SIMPAN JADWAL</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openModal(id) {
    document.getElementById(id).classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}
function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
    document.body.style.overflow = 'auto';
}
</script>
@endpush