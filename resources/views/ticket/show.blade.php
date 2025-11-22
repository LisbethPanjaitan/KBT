@extends('layouts.app')

@section('title', 'Detail E-Ticket - KBT')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Status Badge -->
        <div class="mb-6 text-center">
            @php
                $statusColors = [
                    'pending' => 'bg-yellow-100 text-yellow-800',
                    'paid' => 'bg-green-100 text-green-800',
                    'confirmed' => 'bg-blue-100 text-blue-800',
                    'cancelled' => 'bg-red-100 text-red-800',
                ];
                $statusLabels = [
                    'pending' => 'Menunggu Pembayaran',
                    'paid' => 'Sudah Dibayar',
                    'confirmed' => 'Dikonfirmasi',
                    'cancelled' => 'Dibatalkan',
                ];
            @endphp
            <span class="inline-block px-6 py-2 rounded-full text-lg font-semibold {{ $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-800' }}">
                {{ $statusLabels[$booking->status] ?? ucfirst($booking->status) }}
            </span>
        </div>

        <!-- E-Ticket -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-6 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-3xl font-bold mb-2">E-Ticket</h1>
                        <p class="text-blue-100">Kode Booking: <span class="font-mono font-bold">{{ $booking->booking_code }}</span></p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-blue-100">Tanggal Booking</p>
                        <p class="font-semibold">{{ $booking->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Trip Details -->
            <div class="p-8 border-b">
                <h2 class="text-2xl font-bold mb-6">Detail Perjalanan</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Tanggal Keberangkatan</p>
                        <p class="text-xl font-bold">{{ \Carbon\Carbon::parse($booking->schedule->departure_date)->format('d F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Waktu Keberangkatan</p>
                        <p class="text-xl font-bold">{{ \Carbon\Carbon::parse($booking->schedule->departure_time)->format('H:i') }} WIB</p>
                    </div>
                </div>

                <div class="flex items-center justify-between mb-6">
                    <div class="flex-1">
                        <p class="text-sm text-gray-500">Dari</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $booking->schedule->route->origin_city }}</p>
                        <p class="text-sm text-gray-600">{{ $booking->schedule->route->origin_terminal }}</p>
                    </div>
                    <div class="flex-shrink-0 mx-4">
                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </div>
                    <div class="flex-1 text-right">
                        <p class="text-sm text-gray-500">Ke</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $booking->schedule->route->destination_city }}</p>
                        <p class="text-sm text-gray-600">{{ $booking->schedule->route->destination_terminal }}</p>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Bus</p>
                            <p class="font-semibold">{{ $booking->schedule->bus->bus_type }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Nomor Polisi</p>
                            <p class="font-semibold">{{ $booking->schedule->bus->plate_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Kapasitas</p>
                            <p class="font-semibold">{{ $booking->schedule->bus->capacity }} kursi</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Durasi</p>
                            <p class="font-semibold">{{ $booking->schedule->route->duration }} jam</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Passengers -->
            <div class="p-8 border-b">
                <h2 class="text-2xl font-bold mb-6">Data Penumpang</h2>
                
                @foreach($booking->passengers as $passenger)
                <div class="bg-gray-50 rounded-lg p-4 mb-4">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <p class="font-bold text-lg mb-2">{{ $passenger->name }}</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm">
                                <p class="text-gray-600">
                                    <span class="font-medium">No. Identitas:</span> {{ $passenger->id_number }}
                                </p>
                                <p class="text-gray-600">
                                    <span class="font-medium">No. Telepon:</span> {{ $passenger->phone }}
                                </p>
                                @if($passenger->email)
                                <p class="text-gray-600">
                                    <span class="font-medium">Email:</span> {{ $passenger->email }}
                                </p>
                                @endif
                            </div>
                        </div>
                        <div class="text-right ml-4">
                            <p class="text-sm text-gray-500">Kursi</p>
                            @php
                                $passengerSeat = $booking->seats->where('id', $passenger->seat_id)->first();
                            @endphp
                            <p class="text-2xl font-bold text-blue-600">{{ $passengerSeat->seat_number ?? '-' }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Payment Info -->
            <div class="p-8 border-b">
                <h2 class="text-2xl font-bold mb-6">Informasi Pembayaran</h2>
                
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Harga Tiket ({{ $booking->seats->count() }} kursi)</span>
                        <span class="font-semibold">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                    </div>
                    @if($booking->addons->count() > 0)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tambahan</span>
                        <span class="font-semibold">
                            Rp {{ number_format($booking->addons->sum('price'), 0, ',', '.') }}
                        </span>
                    </div>
                    @endif
                    <div class="border-t pt-3 flex justify-between text-xl font-bold text-blue-600">
                        <span>Total Pembayaran</span>
                        <span>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>

                @if($booking->payment)
                <div class="mt-4 bg-gray-50 rounded-lg p-4">
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500">Metode Pembayaran</p>
                            <p class="font-semibold">{{ ucwords(str_replace('_', ' ', $booking->payment->payment_method)) }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Status Pembayaran</p>
                            <p class="font-semibold {{ $booking->payment->status === 'paid' ? 'text-green-600' : 'text-yellow-600' }}">
                                {{ ucfirst($booking->payment->status) }}
                            </p>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- QR Code -->
            <div class="p-8 bg-gray-50">
                <div class="text-center">
                    <h3 class="text-xl font-bold mb-4">QR Code Check-in</h3>
                    <div class="inline-block bg-white p-6 rounded-lg shadow">
                        <div class="w-48 h-48 bg-gray-200 flex items-center justify-center">
                            <!-- QR Code will be generated here -->
                            <svg class="h-full w-full" viewBox="0 0 100 100">
                                <rect width="100" height="100" fill="white"/>
                                <text x="50" y="50" text-anchor="middle" font-size="8" fill="#666">
                                    QR Code: {{ $booking->booking_code }}
                                </text>
                            </svg>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 mt-4">Tunjukkan QR code ini saat check-in</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="p-8 bg-white">
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('ticket.download', $booking->id) }}" 
                       class="flex-1 btn-primary text-center">
                        <i class="bi bi-download"></i> Download E-Ticket PDF
                    </a>
                    <button onclick="window.print()" 
                            class="flex-1 bg-gray-100 text-gray-700 px-6 py-3 rounded-lg font-medium hover:bg-gray-200 transition">
                        <i class="bi bi-printer"></i> Print Tiket
                    </button>
                </div>

                @if($booking->status === 'pending')
                <div class="mt-4">
                    <a href="{{ route('payment.process') }}" 
                       class="block w-full bg-green-600 text-white px-6 py-3 rounded-lg font-medium text-center hover:bg-green-700 transition">
                        <i class="bi bi-credit-card"></i> Bayar Sekarang
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Important Notes -->
        <div class="mt-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
            <h3 class="font-bold text-yellow-800 mb-2">Informasi Penting:</h3>
            <ul class="text-sm text-yellow-700 space-y-1 list-disc list-inside">
                <li>Harap datang minimal 15 menit sebelum jadwal keberangkatan</li>
                <li>Bawa dokumen identitas asli (KTP/SIM) sesuai dengan data pemesanan</li>
                <li>E-ticket ini berlaku untuk satu kali perjalanan</li>
                <li>Simpan e-ticket ini sampai perjalanan selesai</li>
            </ul>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('ticket.check') }}" class="text-blue-600 hover:text-blue-700 font-medium">
                ← Kembali ke Cek Pesanan
            </a>
        </div>
    </div>
</div>

@push('styles')
<style>
@media print {
    nav, footer, .no-print {
        display: none !important;
    }
    body {
        background: white;
    }
}
</style>
@endpush
@endsection
