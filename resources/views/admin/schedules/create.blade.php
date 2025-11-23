@extends('layouts.admin')

@section('title', 'Tambah Jadwal')
@section('page-title', 'Tambah Jadwal Baru')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.schedules.store') }}" method="POST">
            @csrf
            
            <div class="space-y-6">
                <!-- Route Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rute *</label>
                    <select name="route_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('route_id') border-red-500 @enderror">
                        <option value="">Pilih Rute</option>
                        @foreach($routes as $route)
                        <option value="{{ $route->id }}" {{ old('route_id') == $route->id ? 'selected' : '' }}>
                            {{ $route->origin_city }} ({{ $route->origin_terminal }}) → {{ $route->destination_city }} ({{ $route->destination_terminal }})
                        </option>
                        @endforeach
                    </select>
                    @error('route_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bus Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Bus/Kendaraan *</label>
                    <select name="bus_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('bus_id') border-red-500 @enderror">
                        <option value="">Pilih Bus</option>
                        @foreach($buses as $bus)
                        <option value="{{ $bus->id }}" {{ old('bus_id') == $bus->id ? 'selected' : '' }}>
                            {{ $bus->plate_number }} - {{ $bus->bus_type }} ({{ $bus->total_seats }} kursi)
                        </option>
                        @endforeach
                    </select>
                    @error('bus_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date & Time -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Keberangkatan *</label>
                        <input type="date" name="departure_date" value="{{ old('departure_date') }}" required 
                               min="{{ date('Y-m-d') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('departure_date') border-red-500 @enderror">
                        @error('departure_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jam Keberangkatan *</label>
                        <input type="time" name="departure_time" value="{{ old('departure_time') }}" required 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('departure_time') border-red-500 @enderror">
                        @error('departure_time')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jam Tiba *</label>
                        <input type="time" name="arrival_time" value="{{ old('arrival_time') }}" required 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('arrival_time') border-red-500 @enderror">
                        @error('arrival_time')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Price -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Harga Tiket (Rp) *</label>
                    <input type="number" name="price" value="{{ old('price') }}" required min="0" step="1000"
                           placeholder="Contoh: 75000"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('price') border-red-500 @enderror">
                    @error('price')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">
                        <i class="fas fa-info-circle"></i> Harga akan otomatis mengikuti base_price dari rute yang dipilih jika dikosongkan
                    </p>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                    <select name="status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror">
                        <option value="scheduled" {{ old('status') == 'scheduled' ? 'selected' : '' }}>Scheduled (Terjadwal)</option>
                        <option value="departed" {{ old('status') == 'departed' ? 'selected' : '' }}>Departed (Berangkat)</option>
                        <option value="arrived" {{ old('status') == 'arrived' ? 'selected' : '' }}>Arrived (Tiba)</option>
                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled (Dibatalkan)</option>
                    </select>
                    @error('status')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Info Box -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-blue-600 text-lg mt-0.5 mr-3"></i>
                        <div class="text-sm text-blue-800">
                            <p class="font-medium mb-1">Informasi Penting:</p>
                            <ul class="list-disc list-inside space-y-1 text-xs">
                                <li>Seat akan otomatis dibuat sesuai konfigurasi bus yang dipilih</li>
                                <li>Jadwal hanya akan muncul di pencarian user jika statusnya "Scheduled"</li>
                                <li>Pastikan tanggal keberangkatan >= hari ini</li>
                                <li>Harga akan mengikuti base_price rute jika tidak diisi manual</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.schedules.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                        <i class="fas fa-save mr-2"></i>Simpan Jadwal
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@if(session('success'))
<script>
    alert('{{ session('success') }}');
</script>
@endif

@if($errors->any())
<script>
    alert('Terdapat kesalahan dalam pengisian form. Mohon periksa kembali.');
</script>
@endif
@endsection
