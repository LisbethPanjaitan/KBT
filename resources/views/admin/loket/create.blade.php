@extends('layouts.admin')

@section('title', 'Pemesanan Manual')
@section('page-title', 'Pemesanan Manual - Loket')

@section('content')
<div class="max-w-6xl mx-auto" x-data="bookingForm()">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex items-center justify-between">
            <template x-for="i in 4" :key="i">
                <div class="flex items-center flex-1">
                    <div class="flex items-center" :class="step >= i ? 'text-blue-600' : 'text-gray-400'">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold transition-colors" 
                             :class="step >= i ? 'bg-blue-600 text-white' : 'bg-gray-200'"
                             x-text="i"></div>
                        <span class="ml-3 font-medium hidden md:block" x-text="['Pilih Jadwal', 'Pilih Kursi', 'Data Penumpang', 'Pembayaran'][i-1]"></span>
                    </div>
                    <div x-show="i < 4" class="flex-1 h-1 mx-4 rounded-full" :class="step > i ? 'bg-blue-600' : 'bg-gray-200'"></div>
                </div>
            </template>
        </div>
    </div>

    <div x-show="step === 1" class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Cari Jadwal</h3>
            <form action="{{ route('admin.loket.create') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Dari</label>
                        <select name="origin" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            <option value="">Pilih Kota Asal</option>
                            @foreach($origins as $city)
                                <option value="{{ $city }}" {{ request('origin') == $city ? 'selected' : '' }}>{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kota Tujuan</label>
                        <select name="destination" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            <option value="">Pilih Kota Tujuan</option>
                            @foreach($destinations as $city)
                                <option value="{{ $city }}" {{ request('destination') == $city ? 'selected' : '' }}>{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                        <input type="date" name="date" required value="{{ request('date', now()->toDateString()) }}" 
                               min="{{ now()->toDateString() }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition-colors">
                            <i class="fas fa-search mr-2"></i>Cari Jadwal
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="space-y-4">
            @forelse($schedules as $schedule)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:border-blue-500 cursor-pointer"
                     @click="selectSchedule({{ $schedule->toJson() }})">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-6">
                            <div class="text-center">
                                <p class="text-xl font-bold">{{ $schedule->departure_time }}</p>
                                <p class="text-xs text-gray-500">{{ $schedule->route->origin_city }}</p>
                            </div>
                            <i class="fas fa-arrow-right text-blue-600"></i>
                            <div class="text-center">
                                <p class="text-xl font-bold">{{ $schedule->estimated_arrival_time }}</p>
                                <p class="text-xs text-gray-500">{{ $schedule->route->destination_city }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-bold text-blue-600">Rp {{ number_format($schedule->price, 0, ',', '.') }}</p>
                            <p class="text-xs text-green-600">{{ $schedule->available_seats }} Kursi Tersedia</p>
                            <button class="mt-2 bg-blue-600 text-white px-4 py-1 rounded text-sm font-bold">Pilih</button>
                        </div>
                    </div>
                </div>
            @empty
                @if(request('origin'))
                    <p class="text-center py-10 bg-white rounded-xl border border-dashed text-gray-500">Jadwal tidak ditemukan.</p>
                @endif
            @endforelse
        </div>
    </div>

    <div x-show="step === 2" class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <h3 class="text-xl font-bold mb-8">Pilih Nomor Kursi</h3>
        <div class="max-w-xs mx-auto grid grid-cols-4 gap-4 mb-8">
            <template x-for="seat in seats" :key="seat.id">
                <button @click="toggleSeat(seat)"
                        :disabled="seat.status !== 'available'"
                        :class="{
                            'bg-green-100 border-green-600 text-green-700': seat.status === 'available',
                            'bg-blue-600 text-white': seat.status === 'selected',
                            'bg-gray-200 text-gray-400': seat.status === 'occupied'
                        }"
                        class="aspect-square border-2 rounded-lg font-bold"
                        x-text="seat.seat_number">
                </button>
            </template>
        </div>
        <div class="flex justify-between border-t pt-6">
            <button @click="step = 1" class="px-6 py-2 border rounded-lg">Kembali</button>
            <button @click="step = 3" :disabled="selectedSeats.length === 0" class="px-6 py-2 bg-blue-600 text-white rounded-lg">Lanjut</button>
        </div>
    </div>

    <div x-show="step === 3" class="space-y-6">
        <template x-for="(passenger, index) in passengers" :key="index">
            <div class="bg-white p-6 rounded-xl border">
                <h4 class="font-bold mb-4">Penumpang Kursi <span x-text="passenger.seat_number" class="text-blue-600"></span></h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="text" x-model="passenger.name" placeholder="Nama Lengkap" class="rounded-lg border-gray-300">
                    <input type="text" x-model="passenger.phone" placeholder="Nomor WA" class="rounded-lg border-gray-300">
                </div>
            </div>
        </template>
        <div class="flex justify-between bg-white p-6 rounded-xl border">
            <button @click="step = 2" class="px-6 py-2 border rounded-lg">Kembali</button>
            <button @click="validatePassengers" class="px-6 py-2 bg-blue-600 text-white rounded-lg">Lanjut</button>
        </div>
    </div>

    <div x-show="step === 4" class="max-w-md mx-auto">
        <div class="bg-white p-8 rounded-xl border shadow-lg text-center">
            <h3 class="text-xl font-bold mb-6">Konfirmasi Pembayaran</h3>
            <div class="text-left space-y-3 mb-8 bg-gray-50 p-4 rounded-lg">
                <div class="flex justify-between text-sm"><span>Rute:</span><span class="font-bold" x-text="selectedSchedule?.route?.origin_city + ' → ' + selectedSchedule?.route?.destination_city"></span></div>
                <div class="flex justify-between text-lg border-t pt-3 font-bold"><span>Total:</span><span class="text-blue-600" x-text="'Rp ' + (selectedSchedule?.price * selectedSeats.length).toLocaleString()"></span></div>
            </div>

            <div class="mb-6 text-left">
                <label class="block text-xs font-bold text-gray-400 mb-2 uppercase">Metode Pembayaran</label>
                <div class="grid grid-cols-3 gap-2">
                    <button @click="paymentMethod = 'cash'" :class="paymentMethod === 'cash' ? 'bg-blue-600 text-white' : 'bg-gray-100'" class="py-2 rounded-lg text-xs font-bold transition-all">Tunai</button>
                    <button @click="paymentMethod = 'transfer'" :class="paymentMethod === 'transfer' ? 'bg-blue-600 text-white' : 'bg-gray-100'" class="py-2 rounded-lg text-xs font-bold transition-all">Transfer</button>
                    <button @click="paymentMethod = 'qris'" :class="paymentMethod === 'qris' ? 'bg-blue-600 text-white' : 'bg-gray-100'" class="py-2 rounded-lg text-xs font-bold transition-all">QRIS</button>
                </div>
            </div>

            <button @click="submitBooking" class="w-full bg-green-600 text-white py-3 rounded-xl font-bold shadow-lg">Simpan & Cetak Tiket</button>
            <button @click="step = 3" class="mt-4 text-gray-400 text-sm underline block w-full text-center">Kembali</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function bookingForm() {
    return {
        step: 1,
        selectedSchedule: null,
        seats: [],
        selectedSeats: [],
        passengers: [],
        paymentMethod: 'cash',

        async selectSchedule(schedule) {
            this.selectedSchedule = schedule;
            const res = await fetch(`/admin/loket/schedules/${schedule.id}/seats`);
            this.seats = await res.json();
            this.step = 2;
        },

        toggleSeat(seat) {
    // FIX: Jangan izinkan klik jika statusnya booked/held/broken
    if (seat.status === 'booked' || seat.status === 'held' || seat.status === 'broken') return;

    if (seat.status === 'selected') {
        seat.status = 'available';
        this.selectedSeats = this.selectedSeats.filter(s => s !== seat.seat_number);
        this.passengers = this.passengers.filter(p => p.seat_id !== seat.id);
    } else {
        seat.status = 'selected';
        this.selectedSeats.push(seat.seat_number);
        this.passengers.push({ 
            name: '', 
            phone: '', 
            seat_id: seat.id, 
            seat_number: seat.seat_number 
        });
    }
},

        validatePassengers() {
            if (this.passengers.some(p => !p.name || !p.phone)) {
                alert('Mohon lengkapi data semua penumpang!');
                return;
            }
            this.step = 4;
        },

        async submitBooking() {
            const res = await fetch("{{ route('admin.loket.store') }}", {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({
                    schedule_id: this.selectedSchedule.id,
                    payment_method: this.paymentMethod,
                    passengers: this.passengers
                })
            });
            const data = await res.json();
            if(data.success) {
                alert(data.message);
                window.location.href = data.redirect;
            } else {
                alert('Gagal: ' + data.message);
            }
        }
    }
}
</script>
@endpush