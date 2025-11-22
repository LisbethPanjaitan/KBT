@extends('layouts.app')

@section('title', 'Checkout - KBT')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Progress Steps -->
        <div class="mb-8">
            <div class="flex items-center justify-center">
                <div class="flex items-center">
                    <div class="flex items-center text-green-600 relative">
                        <div class="rounded-full h-12 w-12 flex items-center justify-center bg-green-600 text-white font-bold"><i class="bi bi-check-lg"></i></div>
                        <div class="absolute top-14 left-1/2 transform -translate-x-1/2 text-xs font-medium whitespace-nowrap">Pilih Kursi</div>
                    </div>
                    <div class="w-24 h-1 bg-green-600 mx-2"></div>
                    <div class="flex items-center text-blue-600 relative">
                        <div class="rounded-full h-12 w-12 flex items-center justify-center bg-blue-600 text-white font-bold">2</div>
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

        <!-- Countdown Timer -->
        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-6" x-data="countdownTimer()">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        Selesaikan pemesanan dalam <span class="font-bold" x-text="timeLeft"></span>
                    </p>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('booking.store') }}" x-data="checkoutForm()">
            @csrf
            <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
            @foreach($seats as $seat)
            <input type="hidden" name="seat_ids[]" value="{{ $seat->id }}">
            @endforeach

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Contact Information -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h2 class="text-xl font-bold mb-4">Informasi Kontak</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                <input type="email" name="contact_email" required 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="email@example.com">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">No. WhatsApp *</label>
                                <input type="tel" name="contact_phone" required 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="08123456789">
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">E-ticket akan dikirim ke email dan WhatsApp Anda</p>
                    </div>

                    <!-- Passenger Information -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h2 class="text-xl font-bold mb-4">Data Penumpang</h2>
                        
                        @foreach($seats as $index => $seat)
                        <div class="mb-6 pb-6 {{ $loop->last ? '' : 'border-b' }}">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="font-semibold text-lg">Penumpang {{ $index + 1 }} - Kursi {{ $seat->seat_number }}</h3>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                                    <input type="text" name="passengers[{{ $index }}][name]" required 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="Sesuai KTP">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">No. Identitas (KTP/SIM) *</label>
                                    <input type="text" name="passengers[{{ $index }}][id_number]" required 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="16 digit">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">No. Telepon *</label>
                                    <input type="tel" name="passengers[{{ $index }}][phone]" required 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="08123456789">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                    <input type="email" name="passengers[{{ $index }}][email]"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="email@example.com (opsional)">
                                </div>
                            </div>
                            <input type="hidden" name="passengers[{{ $index }}][seat_id]" value="{{ $seat->id }}">
                        </div>
                        @endforeach
                    </div>

                    <!-- Add-ons -->
                    @if($addons->count() > 0)
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h2 class="text-xl font-bold mb-4">Tambahan (Opsional)</h2>
                        <div class="space-y-3">
                            @foreach($addons as $addon)
                            <label class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                <input type="checkbox" name="addons[]" value="{{ $addon->id }}" 
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                    @change="toggleAddon({{ $addon->id }}, {{ $addon->price }})">
                                <div class="ml-3 flex-1">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $addon->name }}</p>
                                            <p class="text-sm text-gray-500">{{ $addon->description }}</p>
                                        </div>
                                        <p class="font-semibold text-blue-600">+ Rp {{ number_format($addon->price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Payment Method -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h2 class="text-xl font-bold mb-4">Metode Pembayaran</h2>
                        <div class="space-y-3">
                            <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 cursor-pointer">
                                <input type="radio" name="payment_method" value="bank_transfer" required 
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                                <div class="ml-3">
                                    <p class="font-medium">Transfer Bank</p>
                                    <p class="text-sm text-gray-500">BCA, BNI, BRI, Mandiri</p>
                                </div>
                            </label>
                            <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 cursor-pointer">
                                <input type="radio" name="payment_method" value="e_wallet" 
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                                <div class="ml-3">
                                    <p class="font-medium">E-Wallet</p>
                                    <p class="text-sm text-gray-500">GoPay, OVO, DANA, LinkAja</p>
                                </div>
                            </label>
                            <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 cursor-pointer">
                                <input type="radio" name="payment_method" value="credit_card" 
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                                <div class="ml-3">
                                    <p class="font-medium">Kartu Kredit/Debit</p>
                                    <p class="text-sm text-gray-500">Visa, Mastercard</p>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Order Summary Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-md p-6 sticky top-24">
                        <h3 class="text-xl font-bold mb-4">Ringkasan Pesanan</h3>
                        
                        <!-- Trip Details -->
                        <div class="mb-4 pb-4 border-b">
                            <div class="text-sm text-gray-600 mb-1">{{ \Carbon\Carbon::parse($schedule->departure_date)->format('d M Y') }}</div>
                            <div class="font-bold text-lg">{{ $schedule->route->origin_city }} → {{ $schedule->route->destination_city }}</div>
                            <div class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($schedule->departure_time)->format('H:i') }} - {{ $schedule->bus->bus_type }}</div>
                        </div>

                        <!-- Seats -->
                        <div class="mb-4 pb-4 border-b">
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600">{{ $seats->count() }} Kursi:</span>
                                <span class="font-semibold">Rp {{ number_format($schedule->price * $seats->count(), 0, ',', '.') }}</span>
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $seats->pluck('seat_number')->join(', ') }}
                            </div>
                        </div>

                        <!-- Add-ons Total -->
                        <div class="mb-4 pb-4 border-b" x-show="addonTotal > 0">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tambahan:</span>
                                <span class="font-semibold" x-text="'Rp ' + addonTotal.toLocaleString('id-ID')"></span>
                            </div>
                        </div>

                        <!-- Promo Code -->
                        <div class="mb-4 pb-4 border-b">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kode Promo</label>
                            <div class="flex space-x-2">
                                <input type="text" name="promo_code" 
                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm"
                                    placeholder="Masukkan kode">
                                <button type="button" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200">
                                    Pakai
                                </button>
                            </div>
                        </div>

                        <!-- Total -->
                        <div class="mb-6">
                            <div class="flex justify-between text-xl font-bold text-blue-600">
                                <span>Total Bayar:</span>
                                <span x-text="'Rp ' + totalAmount.toLocaleString('id-ID')"></span>
                            </div>
                        </div>

                        <button type="submit" class="w-full btn-primary mb-3">
                            Lanjut Pembayaran →
                        </button>

                        <a href="{{ route('booking.seats', $schedule->id) }}" class="block text-center text-blue-600 hover:text-blue-700">
                            ← Ubah Kursi
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function countdownTimer() {
    return {
        minutes: 10,
        seconds: 0,
        timeLeft: '10:00',
        
        init() {
            this.startTimer();
        },
        
        startTimer() {
            setInterval(() => {
                if (this.seconds > 0) {
                    this.seconds--;
                } else if (this.minutes > 0) {
                    this.minutes--;
                    this.seconds = 59;
                } else {
                    // Time's up
                    alert('Waktu pemesanan habis! Kursi akan dilepas.');
                    window.location.href = '{{ route('search') }}';
                }
                
                this.timeLeft = String(this.minutes).padStart(2, '0') + ':' + String(this.seconds).padStart(2, '0');
            }, 1000);
        }
    }
}

function checkoutForm() {
    return {
        basePrice: {{ $schedule->price * $seats->count() }},
        addonTotal: 0,
        totalAmount: {{ $schedule->price * $seats->count() }},
        
        toggleAddon(addonId, addonPrice) {
            const checkbox = event.target;
            if (checkbox.checked) {
                this.addonTotal += addonPrice;
            } else {
                this.addonTotal -= addonPrice;
            }
            this.totalAmount = this.basePrice + this.addonTotal;
        }
    }
}
</script>
@endpush
@endsection
