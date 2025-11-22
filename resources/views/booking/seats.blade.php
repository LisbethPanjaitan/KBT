@extends('layouts.app')

@section('title', 'Pilih Kursi - KBT')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Progress Steps -->
        <div class="mb-8">
            <div class="flex items-center justify-center">
                <div class="flex items-center">
                    <div class="flex items-center text-blue-600 relative">
                        <div class="rounded-full h-12 w-12 flex items-center justify-center bg-blue-600 text-white font-bold">1</div>
                        <div class="absolute top-14 left-1/2 transform -translate-x-1/2 text-xs font-medium whitespace-nowrap">Pilih Kursi</div>
                    </div>
                    <div class="w-24 h-1 bg-blue-200 mx-2"></div>
                    <div class="flex items-center text-gray-400 relative">
                        <div class="rounded-full h-12 w-12 flex items-center justify-center bg-gray-200 font-bold">2</div>
                        <div class="absolute top-14 left-1/2 transform -translate-x-1/2 text-xs font-medium whitespace-nowrap">Checkout</div>
                    </div>
                    <div class="w-24 h-1 bg-gray-200 mx-2"></div>
                    <div class="flex items-center text-gray-400 relative">
                        <div class="rounded-full h-12 w-12 flex items-center justify-center bg-gray-200 font-bold">3</div>
                        <div class="absolute top-14 left-1/2 transform -translate-x-1/2 text-xs font-medium whitespace-nowrap">Pembayaran</div>
                    </div>
                    <div class="w-24 h-1 bg-gray-200 mx-2"></div>
                    <div class="flex items-center text-gray-400 relative">
                        <div class="rounded-full h-12 w-12 flex items-center justify-center bg-gray-200 font-bold">4</div>
                        <div class="absolute top-14 left-1/2 transform -translate-x-1/2 text-xs font-medium whitespace-nowrap">E-Ticket</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Trip Info -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Rute</p>
                    <p class="font-bold text-lg">{{ $schedule->route->origin_city }} → {{ $schedule->route->destination_city }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tanggal & Waktu</p>
                    <p class="font-bold text-lg">{{ \Carbon\Carbon::parse($schedule->departure_date)->format('d M Y') }}, {{ \Carbon\Carbon::parse($schedule->departure_time)->format('H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Bus</p>
                    <p class="font-bold text-lg">{{ $schedule->bus->bus_type }}</p>
                    <p class="text-sm text-gray-600">{{ $schedule->bus->plate_number }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" x-data="seatSelector()">
            <!-- Seat Map -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-2xl font-bold mb-4">Pilih Kursi Anda</h2>
                    
                    <!-- Legend -->
                    <div class="flex items-center space-x-6 mb-6 text-sm">
                        <div class="flex items-center">
                            <div class="h-8 w-8 bg-green-500 rounded mr-2"></div>
                            <span>Tersedia</span>
                        </div>
                        <div class="flex items-center">
                            <div class="h-8 w-8 bg-gray-400 rounded mr-2"></div>
                            <span>Terisi</span>
                        </div>
                        <div class="flex items-center">
                            <div class="h-8 w-8 bg-yellow-500 rounded mr-2"></div>
                            <span>Di-hold</span>
                        </div>
                        <div class="flex items-center">
                            <div class="h-8 w-8 bg-blue-600 rounded mr-2"></div>
                            <span>Dipilih</span>
                        </div>
                    </div>

                    <!-- Bus Layout -->
                    <div class="bg-gray-100 rounded-lg p-8">
                        <div class="max-w-md mx-auto">
                            <!-- Driver -->
                            <div class="flex justify-between items-center mb-6 pb-4 border-b-2 border-gray-300">
                                <div class="bg-gray-600 text-white rounded-lg px-4 py-2 text-sm font-medium">
                                    <i class="bi bi-person-fill"></i> Sopir
                                </div>
                                <div class="text-gray-500 text-sm">Pintu →</div>
                            </div>

                            <!-- Seats Grid -->
                            <div class="space-y-3">
                                @php
                                    $seatsByRow = $schedule->seats->groupBy('row_number');
                                @endphp
                                
                                @foreach($seatsByRow as $rowNumber => $rowSeats)
                                <div class="flex justify-center space-x-3">
                                    @foreach($rowSeats->sortBy('column_number') as $seat)
                                    <button 
                                        @click="toggleSeat({{ $seat->id }}, '{{ $seat->seat_number }}', {{ $schedule->price }}, '{{ $seat->status }}')"
                                        :disabled="'{{ $seat->status }}' !== 'available'"
                                        :class="{
                                            'bg-green-500 hover:bg-green-600': '{{ $seat->status }}' === 'available' && !selectedSeats.includes({{ $seat->id }}),
                                            'bg-blue-600': selectedSeats.includes({{ $seat->id }}),
                                            'bg-gray-400 cursor-not-allowed': '{{ $seat->status }}' === 'booked',
                                            'bg-yellow-500 cursor-not-allowed': '{{ $seat->status }}' === 'held'
                                        }"
                                        class="h-12 w-12 rounded text-white font-bold transition duration-200 transform hover:scale-105">
                                        {{ $seat->seat_number }}
                                    </button>
                                    @endforeach
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-md p-6 sticky top-24">
                    <h3 class="text-xl font-bold mb-4">Ringkasan Pesanan</h3>
                    
                    <div class="space-y-3 mb-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Kursi Dipilih:</span>
                            <span class="font-semibold" x-text="selectedSeats.length || '-'"></span>
                        </div>
                        <div class="text-sm text-gray-600" x-show="selectedSeatNumbers.length > 0">
                            <span class="font-medium">Nomor Kursi: </span>
                            <span x-text="selectedSeatNumbers.join(', ')"></span>
                        </div>
                    </div>

                    <div class="border-t pt-4 mb-4">
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Harga per kursi:</span>
                            <span class="font-semibold">Rp {{ number_format($schedule->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold text-blue-600">
                            <span>Total:</span>
                            <span x-text="'Rp ' + totalPrice.toLocaleString('id-ID')"></span>
                        </div>
                    </div>

                    <div class="text-xs text-gray-500 mb-4" x-show="selectedSeats.length > 0">
                        <i class="bi bi-clock"></i> Kursi akan di-hold selama 10 menit setelah Anda klik Lanjutkan
                    </div>

                    <form method="GET" action="{{ route('booking.checkout') }}" x-show="selectedSeats.length > 0">
                        <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                        <template x-for="seatId in selectedSeats" :key="seatId">
                            <input type="hidden" name="seat_ids[]" :value="seatId">
                        </template>
                        <button type="submit" class="w-full btn-primary">
                            Lanjutkan ke Checkout →
                        </button>
                    </form>

                    <div x-show="selectedSeats.length === 0" class="text-center text-gray-500 py-8">
                        Pilih kursi terlebih dahulu
                    </div>

                    <a href="{{ route('search') }}" class="block text-center text-blue-600 hover:text-blue-700 mt-4">
                        ← Kembali ke Pencarian
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function seatSelector() {
    return {
        selectedSeats: [],
        selectedSeatNumbers: [],
        totalPrice: 0,
        pricePerSeat: {{ $schedule->price }},
        
        init() {
            console.log('Seat selector initialized');
        },
        
        toggleSeat(seatId, seatNumber, price, status) {
            console.log('Toggle seat:', seatId, seatNumber, status);
            
            if (status !== 'available') {
                console.log('Seat not available');
                return;
            }
            
            const index = this.selectedSeats.indexOf(seatId);
            if (index > -1) {
                // Remove seat
                this.selectedSeats.splice(index, 1);
                this.selectedSeatNumbers.splice(index, 1);
                console.log('Seat removed');
            } else {
                // Add seat
                this.selectedSeats.push(seatId);
                this.selectedSeatNumbers.push(seatNumber);
                console.log('Seat added');
            }
            
            this.totalPrice = this.selectedSeats.length * this.pricePerSeat;
            console.log('Selected seats:', this.selectedSeats);
            console.log('Total price:', this.totalPrice);
        }
    }
}
</script>
@endpush
@endsection
