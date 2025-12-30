@extends('layouts.app')

@section('title', 'Pemesanan Berhasil - KBT')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-3xl mx-auto px-4">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            
            <div class="bg-blue-600 p-10 text-center text-white">
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-check text-4xl"></i>
                </div>
                <h1 class="text-3xl font-black uppercase tracking-tight">Pemesanan Berhasil!</h1>
                <p class="mt-2 text-blue-100 italic">Terima kasih telah memilih KBT untuk perjalanan Anda.</p>
            </div>

            <div class="p-8 space-y-8">
                <div class="text-center border-b border-gray-100 pb-6">
                    <p class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-1">Nomor Transaksi</p>
                    <h2 class="text-4xl font-black text-gray-900 font-mono">{{ $booking->booking_code }}</h2>
                </div>

                <div class="bg-blue-50 rounded-2xl p-6 flex justify-between items-center border border-blue-100">
                    <div class="text-center md:text-left">
                        <p class="text-xs font-black text-blue-400 uppercase">ASAL</p>
                        <p class="text-xl font-black text-blue-900">{{ $booking->schedule->route?->origin_city ?? 'N/A' }}</p>
                        <p class="text-xs text-blue-700 font-bold">{{ $booking->schedule->route?->origin_terminal ?? '-' }}</p>
                    </div>
                    <div class="text-blue-600 text-3xl"><i class="fas fa-bus"></i></div>
                    <div class="text-center md:text-right">
                        <p class="text-xs font-black text-blue-400 uppercase">TUJUAN</p>
                        <p class="text-xl font-black text-blue-900">{{ $booking->schedule->route?->destination_city ?? 'N/A' }}</p>
                        <p class="text-xs text-blue-700 font-bold">{{ $booking->schedule->route?->destination_terminal ?? '-' }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Manifest Penumpang</h3>
                        <ul class="space-y-3">
                            @foreach($booking->passengers as $passenger)
                            <li class="flex items-center p-3 bg-gray-50 rounded-xl border border-gray-100">
                                <div class="w-8 h-8 bg-blue-600 text-white rounded-lg flex items-center justify-center font-bold mr-3">
                                    {{ $loop->iteration }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900 leading-none">{{ $passenger->full_name }}</p>
                                    <p class="text-[10px] text-gray-500 font-bold mt-1">{{ $passenger->phone_number }}</p>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Informasi Armada</h3>
                        <div class="p-4 border border-gray-100 rounded-2xl space-y-4">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500 font-bold">Nomor Polisi</span>
                                <span class="text-sm text-gray-900 font-black uppercase">{{ $booking->schedule->bus?->plate_number ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500 font-bold">Nomor Kursi</span>
                                <div class="flex gap-1">
                                    @foreach($booking->seats as $seat)
                                    <span class="bg-blue-100 text-blue-700 text-[10px] font-black px-2 py-1 rounded-lg">
                                        {{ $seat->seat_number }}
                                    </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-t border-dashed border-gray-200 pt-8">
                    <div class="flex justify-between items-end mb-6">
                        <div>
                            <p class="text-xs text-gray-400 font-black uppercase mb-1">Status Pembayaran</p>
                            <span class="px-4 py-1.5 rounded-full font-black text-[10px] uppercase tracking-widest {{ $booking->status == 'confirmed' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                                {{ $booking->status }}
                            </span>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-400 font-black uppercase mb-1">Total Biaya</p>
                            <p class="text-3xl font-black text-blue-600 tracking-tighter">
                                Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    @if($booking->status == 'pending')
                    <div class="bg-gray-900 text-white rounded-2xl p-6">
                        <p class="text-xs font-bold text-gray-400 uppercase mb-3">Instruksi Pembayaran</p>
                        <p class="text-sm leading-relaxed mb-4 text-gray-300">
                            Silakan lakukan transfer ke salah satu rekening di bawah ini dan tiket Anda akan aktif otomatis setelah diverifikasi admin.
                        </p>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white/10 p-3 rounded-xl">
                                <p class="text-[10px] text-gray-400 font-bold uppercase">Bank Mandiri</p>
                                <p class="font-mono font-bold">123-456-7890</p>
                            </div>
                            <div class="bg-white/10 p-3 rounded-xl">
                                <p class="text-[10px] text-gray-400 font-bold uppercase">Bank BCA</p>
                                <p class="font-mono font-bold">098-765-4321</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="pt-4 flex flex-col gap-3">
                    <a href="{{ route('home') }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-2xl text-center shadow-lg transition duration-200">
                        Kembali ke Beranda
                    </a>
                    <p class="text-center text-[10px] text-gray-400 font-bold italic uppercase tracking-widest">
                        Hubungi WhatsApp KBT di +62 812-3456-7890 jika ada kendala
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection