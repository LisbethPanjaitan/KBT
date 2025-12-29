@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-12 px-4">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        
        @if($booking->status == 'pending')
            <div class="bg-orange-500 p-8 text-center text-blue">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-clock text-3xl animate-pulse"></i>
                </div>
                <h1 class="text-2xl font-bold">Menunggu Pembayaran</h1>
                <p class="mt-1 opacity-90">Selesaikan pembayaran sebelum tiket kedaluwarsa.</p>
            </div>
        @else
            <div class="bg-blue-600 p-8 text-center text-white">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-check text-3xl"></i>
                </div>
                <h1 class="text-2xl font-bold">Pemesanan Berhasil!</h1>
                <p class="mt-1 opacity-90">Kode Booking: <span class="font-mono font-bold">{{ $booking->booking_code }}</span></p>
            </div>
        @endif

        <div class="p-8 space-y-8">
            
            <div>
                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Rincian Perjalanan</h3>
                <div class="flex justify-between items-center bg-gray-50 p-4 rounded-xl">
                    @if($booking->schedule)
                        <div>
                            <p class="text-lg font-bold text-gray-900">{{ $booking->schedule->route?->origin_city ?? 'Kota Asal' }}</p>
                            <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($booking->schedule->departure_date)->format('d M Y') }}</p>
                        </div>
                        <div class="text-blue-600 px-4"><i class="fas fa-long-arrow-alt-right text-xl"></i></div>
                        <div class="text-right">
                            <p class="text-lg font-bold text-gray-900">{{ $booking->schedule->route?->destination_city ?? 'Kota Tujuan' }}</p>
                            <p class="text-sm text-gray-500">{{ $booking->schedule->departure_time }} WIB</p>
                        </div>
                    @else
                        <p class="text-gray-500 italic">Data jadwal tidak ditemukan.</p>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Penumpang</h3>
                    <ul class="space-y-3">
                        @forelse($booking->passengers as $passenger)
                            <li class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-xs font-bold">
                                    {{ $loop->iteration }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $passenger->full_name }}</p>
                                    <p class="text-xs text-gray-500">{{ $passenger->phone_number }}</p>
                                </div>
                            </li>
                        @empty
                            <p class="text-gray-500 text-sm">Tidak ada data penumpang.</p>
                        @endforelse
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Kursi & Bus</h3>
                    <p class="font-semibold text-gray-800">
                        {{ $booking->schedule->bus?->plate_number ?? 'Armada Belum Ditentukan' }}
                    </p>
                    <div class="flex flex-wrap gap-2 mt-2">
                        @foreach($booking->seats as $seat)
                            <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-lg font-bold text-sm border border-blue-100">
                                {{ $seat->seat_number }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="border-t pt-8">
                <div class="flex justify-between items-end mb-6">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Metode Pembayaran</p>
                        <span class="px-4 py-1.5 bg-gray-100 text-gray-700 rounded-full font-bold text-xs uppercase">
                            {{ str_replace('_', ' ', $booking->payment_method ?? 'Belum dipilih') }}
                        </span>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Total Pembayaran</p>
                        <p class="text-2xl font-black text-blue-600 tracking-tighter">
                            Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                @if($booking->status == 'pending')
                    <div class="bg-blue-50 border border-blue-100 rounded-xl p-6">
                        <h4 class="font-bold text-blue-800 mb-2"><i class="fas fa-info-circle mr-2"></i>Instruksi Pembayaran</h4>
                        <p class="text-sm text-blue-700 leading-relaxed">
                            Silakan transfer tepat sebesar <strong>Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</strong> ke rekening resmi KBT. Tiket Anda akan otomatis aktif setelah admin melakukan verifikasi.
                        </p>
                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-white p-3 rounded-lg border border-blue-200">
                                <p class="text-xs text-gray-400 uppercase">Bank Mandiri</p>
                                <p class="font-mono font-bold text-gray-800">123-456-7890</p>
                                <p class="text-xs text-gray-500">a/n PT KBT Sejahtera</p>
                            </div>
                            <div class="bg-white p-3 rounded-lg border border-blue-200">
                                <p class="text-xs text-gray-400 uppercase">Bank BCA</p>
                                <p class="font-mono font-bold text-gray-800">098-765-4321</p>
                                <p class="text-xs text-gray-500">a/n PT KBT Sejahtera</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-1 gap-3 pt-4">
                <a href="{{ route('home') }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl text-center shadow-lg transition duration-200">
                    Kembali ke Beranda
                </a>
                <p class="text-center text-xs text-gray-400 italic">
                    Butuh bantuan? Hubungi WhatsApp Center KBT di +62 812-3456-7890
                </p>
            </div>
        </div>
    </div>
</div>
@endsection