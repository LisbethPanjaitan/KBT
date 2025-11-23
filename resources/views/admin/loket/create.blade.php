@extends('layouts.admin')

@section('title', 'Pemesanan Manual')
@section('page-title', 'Pemesanan Manual - Loket')

@section('content')
<div class="max-w-6xl mx-auto" x-data="bookingForm()">
    <!-- Steps Progress -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center flex-1" :class="step >= 1 ? 'text-blue-600' : 'text-gray-400'">
                <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold" 
                     :class="step >= 1 ? 'bg-blue-600 text-white' : 'bg-gray-200'">1</div>
                <span class="ml-3 font-medium">Pilih Jadwal</span>
            </div>
            <div class="flex-1 h-1 mx-4" :class="step >= 2 ? 'bg-blue-600' : 'bg-gray-200'"></div>
            
            <div class="flex items-center flex-1" :class="step >= 2 ? 'text-blue-600' : 'text-gray-400'">
                <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold" 
                     :class="step >= 2 ? 'bg-blue-600 text-white' : 'bg-gray-200'">2</div>
                <span class="ml-3 font-medium">Pilih Kursi</span>
            </div>
            <div class="flex-1 h-1 mx-4" :class="step >= 3 ? 'bg-blue-600' : 'bg-gray-200'"></div>
            
            <div class="flex items-center flex-1" :class="step >= 3 ? 'text-blue-600' : 'text-gray-400'">
                <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold" 
                     :class="step >= 3 ? 'bg-blue-600 text-white' : 'bg-gray-200'">3</div>
                <span class="ml-3 font-medium">Data Penumpang</span>
            </div>
            <div class="flex-1 h-1 mx-4" :class="step >= 4 ? 'bg-blue-600' : 'bg-gray-200'"></div>
            
            <div class="flex items-center flex-1" :class="step >= 4 ? 'text-blue-600' : 'text-gray-400'">
                <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold" 
                     :class="step >= 4 ? 'bg-blue-600 text-white' : 'bg-gray-200'">4</div>
                <span class="ml-3 font-medium">Pembayaran</span>
            </div>
        </div>
    </div>

    <!-- Step 1: Pilih Jadwal -->
    <div x-show="step === 1" class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Cari Jadwal</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Dari</label>
                    <select x-model="searchForm.from" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Kota</option>
                        <option value="medan">Medan</option>
                        <option value="binjai">Binjai</option>
                        <option value="pematangsiantar">Pematang Siantar</option>
                        <option value="rantauprapat">Rantau Prapat</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kota Tujuan</label>
                    <select id="destination" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Pilih Kota</option>
                        <option value="pematangsiantar">Pematang Siantar</option>
                        <option value="rantauprapat">Rantau Prapat</option>
                        <option value="sibolga">Sibolga</option>
                        <option value="berastagi">Berastagi</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                    <input type="date" x-model="searchForm.date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Penumpang</label>
                    <input type="number" x-model="searchForm.passengers" min="1" max="10" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            <button @click="searchSchedules()" class="mt-4 w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition-colors">
                <i class="fas fa-search mr-2"></i>Cari Jadwal
            </button>
        </div>

        <!-- Available Schedules -->
        <div class="space-y-4">
            <template x-for="schedule in schedules" :key="schedule.id">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow cursor-pointer"
                     @click="selectSchedule(schedule)">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-6">
                            <div class="text-center">
                                <p class="text-2xl font-bold text-gray-900" x-text="schedule.departure_time"></p>
                                <p class="text-sm text-gray-500" x-text="schedule.from"></p>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-arrow-right text-blue-600 text-xl"></i>
                            </div>
                            <div class="text-center">
                                <p class="text-2xl font-bold text-gray-900" x-text="schedule.arrival_time"></p>
                                <p class="text-sm text-gray-500" x-text="schedule.to"></p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-6">
                            <div>
                                <p class="text-sm text-gray-600">Kursi Tersedia</p>
                                <p class="text-xl font-bold text-green-600" x-text="schedule.available_seats"></p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-600">Harga</p>
                                <p class="text-2xl font-bold text-blue-600" x-text="'Rp ' + schedule.price.toLocaleString('id-ID')"></p>
                            </div>
                            <button class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium">
                                Pilih
                            </button>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Step 2: Pilih Kursi -->
    <div x-show="step === 2" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-6">Pilih Kursi</h3>
        
        <div class="flex justify-center mb-6">
            <div class="inline-flex items-center space-x-6 text-sm">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-green-100 border-2 border-green-600 rounded mr-2"></div>
                    <span>Tersedia</span>
                </div>
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-blue-600 text-white rounded mr-2 flex items-center justify-center">
                        <i class="fas fa-check text-xs"></i>
                    </div>
                    <span>Dipilih</span>
                </div>
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-gray-300 rounded mr-2"></div>
                    <span>Terisi</span>
                </div>
            </div>
        </div>

        <!-- Seat Map -->
        <div class="max-w-2xl mx-auto">
            <!-- Driver -->
            <div class="flex justify-end mb-6">
                <div class="w-12 h-12 bg-gray-700 rounded-lg flex items-center justify-center">
                    <i class="fas fa-steering-wheel text-white"></i>
                </div>
            </div>

            <!-- Seats Grid -->
            <div class="grid grid-cols-4 gap-3">
                <template x-for="seat in seats" :key="seat.number">
                    <button 
                        @click="toggleSeat(seat)"
                        :disabled="seat.status === 'occupied'"
                        class="w-full aspect-square rounded-lg font-bold text-sm transition-all transform hover:scale-105 disabled:cursor-not-allowed disabled:hover:scale-100"
                        :class="{
                            'bg-green-100 border-2 border-green-600 text-green-700 hover:bg-green-200': seat.status === 'available',
                            'bg-blue-600 text-white': seat.status === 'selected',
                            'bg-gray-300 text-gray-600': seat.status === 'occupied'
                        }"
                        x-text="seat.number">
                    </button>
                </template>
            </div>
        </div>

        <div class="mt-6 flex justify-between items-center">
            <button @click="step = 1" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </button>
            <div class="text-right">
                <p class="text-sm text-gray-600">Total: <span class="text-2xl font-bold text-blue-600" x-text="selectedSeats.length"></span> kursi</p>
            </div>
            <button @click="step = 3" :disabled="selectedSeats.length === 0" 
                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg disabled:bg-gray-300">
                Lanjut<i class="fas fa-arrow-right ml-2"></i>
            </button>
        </div>
    </div>

    <!-- Step 3: Data Penumpang -->
    <div x-show="step === 3" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-6">Data Penumpang</h3>
        
        <div class="space-y-6">
            <template x-for="(seat, index) in selectedSeats" :key="seat">
                <div class="p-4 border-2 border-gray-200 rounded-lg">
                    <h4 class="font-semibold text-gray-900 mb-4">Penumpang <span x-text="index + 1"></span> - Kursi <span x-text="seat"></span></h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                            <input type="text" x-model="passengers[index].name" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">No. Identitas (KTP/SIM) *</label>
                            <input type="text" x-model="passengers[index].id_number" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">No. Telepon *</label>
                            <input type="tel" x-model="passengers[index].phone" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" x-model="passengers[index].email"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <div class="mt-6 flex justify-between">
            <button @click="step = 2" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </button>
            <button @click="step = 4" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                Lanjut<i class="fas fa-arrow-right ml-2"></i>
            </button>
        </div>
    </div>

    <!-- Step 4: Pembayaran -->
    <div x-show="step === 4" class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-6">Metode Pembayaran</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div @click="paymentMethod = 'cash'" 
                     :class="paymentMethod === 'cash' ? 'border-blue-600 bg-blue-50' : 'border-gray-300'"
                     class="p-4 border-2 rounded-lg cursor-pointer hover:border-blue-400 transition-colors">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-money-bill-wave text-2xl text-green-600 mr-3"></i>
                            <span class="font-semibold">Tunai</span>
                        </div>
                        <i x-show="paymentMethod === 'cash'" class="fas fa-check-circle text-blue-600"></i>
                    </div>
                </div>

                <div @click="paymentMethod = 'transfer'" 
                     :class="paymentMethod === 'transfer' ? 'border-blue-600 bg-blue-50' : 'border-gray-300'"
                     class="p-4 border-2 rounded-lg cursor-pointer hover:border-blue-400 transition-colors">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-university text-2xl text-blue-600 mr-3"></i>
                            <span class="font-semibold">Transfer Bank</span>
                        </div>
                        <i x-show="paymentMethod === 'transfer'" class="fas fa-check-circle text-blue-600"></i>
                    </div>
                </div>

                <div @click="paymentMethod = 'qris'" 
                     :class="paymentMethod === 'qris' ? 'border-blue-600 bg-blue-50' : 'border-gray-300'"
                     class="p-4 border-2 rounded-lg cursor-pointer hover:border-blue-400 transition-colors">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-qrcode text-2xl text-purple-600 mr-3"></i>
                            <span class="font-semibold">QRIS</span>
                        </div>
                        <i x-show="paymentMethod === 'qris'" class="fas fa-check-circle text-blue-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Ringkasan Pemesanan</h3>
            <div class="space-y-3">
                <div class="flex justify-between text-gray-700">
                    <span>Harga Tiket (<span x-text="selectedSeats.length"></span> kursi)</span>
                    <span class="font-semibold" x-text="'Rp ' + (selectedSchedule.price * selectedSeats.length).toLocaleString('id-ID')"></span>
                </div>
                <div class="flex justify-between text-gray-700">
                    <span>Biaya Admin</span>
                    <span class="font-semibold">Rp 5.000</span>
                </div>
                <div class="border-t border-gray-200 pt-3 flex justify-between text-lg font-bold text-gray-900">
                    <span>Total Pembayaran</span>
                    <span class="text-blue-600" x-text="'Rp ' + ((selectedSchedule.price * selectedSeats.length) + 5000).toLocaleString('id-ID')"></span>
                </div>
            </div>
        </div>

        <div class="flex justify-between">
            <button @click="step = 3" class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </button>
            <button @click="processBooking()" class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold text-lg">
                <i class="fas fa-check-circle mr-2"></i>Proses & Cetak Tiket
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function bookingForm() {
    return {
        step: 1,
        searchForm: {
            from: '',
            to: '',
            date: '',
            passengers: 1
        },
        schedules: [],
        selectedSchedule: null,
        seats: [],
        selectedSeats: [],
        passengers: [],
        paymentMethod: 'cash',
        
        searchSchedules() {
            // Mock data - replace with actual API call
            const schedules = [
                { id: 1, from: 'Medan', to: 'Pematang Siantar', departure_time: '08:00', arrival_time: '10:30', available_seats: 15, price: 75000 },
                { id: 2, from: 'Medan', to: 'Pematang Siantar', departure_time: '14:00', arrival_time: '16:30', available_seats: 8, price: 75000 },
                { id: 3, from: 'Medan', to: 'Rantau Prapat', departure_time: '09:00', arrival_time: '13:00', available_seats: 22, price: 120000 },
            ];
        },
        
        selectSchedule(schedule) {
            this.selectedSchedule = schedule;
            this.generateSeats();
            this.step = 2;
        },
        
        generateSeats() {
            this.seats = [];
            for (let i = 1; i <= 48; i++) {
                this.seats.push({
                    number: i,
                    status: Math.random() > 0.7 ? 'occupied' : 'available'
                });
            }
        },
        
        toggleSeat(seat) {
            if (seat.status === 'occupied') return;
            
            if (seat.status === 'selected') {
                seat.status = 'available';
                this.selectedSeats = this.selectedSeats.filter(s => s !== seat.number);
                this.passengers = this.passengers.filter((_, i) => i < this.selectedSeats.length);
            } else {
                seat.status = 'selected';
                this.selectedSeats.push(seat.number);
                this.passengers.push({ name: '', id_number: '', phone: '', email: '' });
            }
        },
        
        processBooking() {
            // Process booking via API
            alert('Booking processed successfully!');
            // Redirect to print ticket page
        }
    }
}
</script>
@endpush
