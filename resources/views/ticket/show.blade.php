@extends('layouts.app')

@section('title', 'Detail Pesanan - ' . $booking->booking_code)

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4">
        
        <div class="mb-8 flex items-center justify-between print:hidden">
            <a href="{{ route('ticket.check') }}" class="text-blue-600 font-bold flex items-center hover:text-blue-800 transition">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Pencarian
            </a>
            <button onclick="window.print()" class="bg-white text-gray-700 font-bold px-5 py-2 rounded-xl shadow-sm border border-gray-200 hover:bg-gray-50 transition flex items-center">
                <i class="fas fa-print mr-2 text-blue-500"></i> Cetak E-Tiket
            </button>
        </div>

        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100 print:shadow-none print:border-none">
            
            <div class="bg-blue-600 p-8 text-white flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div>
                    <h1 class="text-2xl font-black uppercase tracking-tighter italic">E-Tiket Bus KBT</h1>
                    <p class="opacity-80 text-sm mt-1">Kode Booking: <span class="font-mono font-bold bg-white/20 px-2 py-0.5 rounded">{{ $booking->booking_code }}</span></p>
                </div>
                <div class="flex flex-col items-center md:items-end">
                    <p class="text-[10px] font-black uppercase tracking-widest opacity-70 mb-1">Status Keamanan</p>
                    <span class="px-6 py-2 rounded-full font-black text-xs uppercase tracking-widest shadow-lg {{ $booking->status == 'confirmed' ? 'bg-green-400 text-green-900' : 'bg-orange-400 text-orange-900 animate-pulse' }}">
                        {{ strtoupper($booking->status) }}
                    </span>
                </div>
            </div>

            <div class="p-8 space-y-10">
                
                <div>
                    <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Informasi Perjalanan</h3>
                    <div class="bg-blue-50 rounded-2xl p-6 border border-blue-100 grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                        <div class="text-center md:text-left">
                            <p class="text-[10px] font-black text-blue-400 uppercase mb-1">Asal</p>
                            <p class="text-xl font-black text-blue-900">{{ $booking->schedule->route->origin_city }}</p>
                            <p class="text-xs text-blue-700 font-bold">{{ $booking->schedule->route->origin_terminal }}</p>
                        </div>
                        <div class="flex flex-col items-center justify-center">
                            <div class="w-full flex items-center">
                                <div class="flex-1 h-0.5 bg-blue-200 border-t border-dashed"></div>
                                <i class="fas fa-bus text-blue-600 mx-3 text-xl"></i>
                                <div class="flex-1 h-0.5 bg-blue-200 border-t border-dashed"></div>
                            </div>
                            <p class="text-[10px] font-black text-blue-400 mt-2 uppercase">
                                {{ \Carbon\Carbon::parse($booking->schedule->departure_date)->translatedFormat('d F Y') }}
                            </p>
                            <p class="text-lg font-black text-blue-600">
                                {{ \Carbon\Carbon::parse($booking->schedule->departure_time)->format('H:i') }} WIB
                            </p>
                        </div>
                        <div class="text-center md:text-right">
                            <p class="text-[10px] font-black text-blue-400 uppercase mb-1">Tujuan</p>
                            <p class="text-xl font-black text-blue-900">{{ $booking->schedule->route->destination_city }}</p>
                            <p class="text-xs text-blue-700 font-bold">{{ $booking->schedule->route->destination_terminal }}</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div>
                        <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Manifest Penumpang</h3>
                        <div class="space-y-3">
                            @foreach($booking->passengers as $index => $passenger)
                            <div class="flex items-center justify-between p-4 border border-gray-100 rounded-2xl bg-gray-50 transition hover:bg-white hover:shadow-md">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-blue-600 text-white rounded-lg flex items-center justify-center font-black mr-3 shadow-sm">
                                        {{ $loop->iteration }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900 leading-none text-sm">{{ $passenger->full_name }}</p>
                                        <p class="text-[10px] text-gray-500 font-bold mt-1 uppercase">{{ $passenger->phone_number }}</p>
                                    </div>
                                </div>
                                <div class="bg-blue-100 text-blue-700 font-black px-3 py-1 rounded-lg text-[10px] uppercase">
                                    Kursi {{ $booking->seats[$index]->seat_number ?? '-' }}
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Ringkasan Biaya</h3>
                        <div class="p-6 border border-gray-100 rounded-3xl space-y-4 bg-white">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-400 font-bold uppercase text-[10px]">Harga Tiket ({{ $booking->total_seats }}x)</span>
                                <span class="font-bold text-gray-900">Rp {{ number_format($booking->subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm border-b border-gray-50 pb-4">
                                <span class="text-gray-400 font-bold uppercase text-[10px]">Layanan Armada</span>
                                <span class="font-bold text-green-600 text-xs uppercase italic">Included</span>
                            </div>
                            <div class="flex justify-between items-end pt-2">
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Bayar</p>
                                    <p class="text-3xl font-black text-blue-600 tracking-tighter">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Metode</p>
                                    <p class="font-black text-gray-700 uppercase text-[10px]">{{ str_replace('_', ' ', $booking->payment_method) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($booking->status == 'pending')
                <div class="mt-8 pt-8 border-t-2 border-dashed border-gray-100">
                    <div class="bg-gray-900 rounded-3xl p-8 text-white relative overflow-hidden shadow-2xl">
                        <div class="relative z-10">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-blue-500/20 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-wallet text-blue-400"></i>
                                </div>
                                <h4 class="text-xl font-black uppercase italic">Selesaikan Pembayaran</h4>
                            </div>
                            <p class="text-gray-400 text-xs leading-relaxed mb-6 max-w-lg">
                                Tiket Anda belum aktif. Silakan transfer tepat <span class="text-white font-bold">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</span> ke rekening di bawah ini untuk aktivasi otomatis.
                            </p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-white/5 p-4 rounded-2xl border border-white/10 hover:bg-white/10 transition">
                                    <p class="text-[10px] font-black text-blue-400 uppercase mb-1">Bank Mandiri (Pusat)</p>
                                    <p class="text-xl font-mono font-bold tracking-widest text-white">123-456-7890</p>
                                    <p class="text-[10px] text-gray-500 font-bold uppercase mt-1">A.N PT KBT SEJAHTERA</p>
                                </div>
                                <div class="bg-white/5 p-4 rounded-2xl border border-white/10 hover:bg-white/10 transition">
                                    <p class="text-[10px] font-black text-blue-400 uppercase mb-1">Bank BCA (Pusat)</p>
                                    <p class="text-xl font-mono font-bold tracking-widest text-white">098-765-4321</p>
                                    <p class="text-[10px] text-gray-500 font-bold uppercase mt-1">A.N PT KBT SEJAHTERA</p>
                                </div>
                            </div>
                            <div class="mt-8 flex flex-col md:flex-row items-center justify-between gap-4 border-t border-white/5 pt-6">
                                <p class="text-[10px] font-bold italic text-orange-400">
                                    <i class="fas fa-info-circle mr-1"></i> Setelah transfer, kirimkan bukti bayar melalui link WhatsApp di samping.
                                </p>
                                <a href="https://wa.me/6281234567890?text=Halo%20Admin%20KBT,%20saya%20ingin%20konfirmasi%20pembayaran%20dengan%20Kode%20Booking:%20{{ $booking->booking_code }}" target="_blank" class="bg-green-500 hover:bg-green-600 text-white font-black px-8 py-4 rounded-2xl shadow-lg transition transform hover:scale-105 active:scale-95 flex items-center text-sm">
                                    <i class="fab fa-whatsapp mr-2 text-lg"></i> KONFIRMASI PEMBAYARAN
                                </a>
                            </div>
                        </div>
                        <i class="fas fa-shield-alt absolute -right-10 -bottom-10 opacity-5 text-9xl transform -rotate-12"></i>
                    </div>
                </div>
                @else
                <div class="mt-8 pt-8 border-t border-gray-100 flex flex-col items-center justify-center text-center">
                    <div class="bg-green-50 p-8 rounded-3xl border border-green-100 max-w-xl">
                        <div class="w-16 h-16 bg-green-500 text-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-green-200">
                            <i class="fas fa-check text-2xl"></i>
                        </div>
                        <h4 class="text-xl font-black text-green-900 uppercase italic">Tiket Siap Digunakan</h4>
                        <p class="text-sm text-green-700 font-medium mt-2 leading-relaxed">
                            Pembayaran Anda telah diverifikasi oleh sistem. Tunjukkan halaman ini atau QR-Code di bawah kepada petugas saat naik ke armada.
                        </p>
                    </div>
                </div>
                @endif

                <div class="pt-8 flex flex-col items-center justify-center space-y-4">
                    <div class="text-center">
                         <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.4em] mb-4">Boarding Pass QR-Code</p>
                         <div class="p-5 bg-white border-2 border-gray-100 rounded-3xl shadow-inner inline-block">
                             {!! QrCode::size(160)->margin(1)->generate($booking->booking_code) !!}
                         </div>
                    </div>
                    <div class="text-center">
                        <p class="text-[10px] text-gray-400 font-bold uppercase italic max-w-xs">
                            KBT Transportasi &copy; 2025<br>
                            Simpan QR-Code ini untuk keperluan Check-in di Terminal.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="hidden print:block mt-12 text-center border-t border-gray-200 pt-8">
            <p class="text-sm font-bold text-gray-500 uppercase tracking-widest">Terima Kasih Telah Menggunakan Jasa KBT</p>
            <p class="text-[10px] text-gray-400 mt-1 italic italic">Tiket ini sah dan diterbitkan secara elektronik melalui kbt-transport.id</p>
        </div>
    </div>
</div>

<style>
    @media print {
        body { background: white !important; }
        .bg-gray-50 { background: white !important; }
        nav, footer, .print\:hidden { display: none !important; }
        .max-w-4xl { max-width: 100% !important; width: 100% !important; margin: 0 !important; }
        .shadow-xl { box-shadow: none !important; }
        .rounded-3xl { border-radius: 0.5rem !important; }
        .bg-blue-600 { background-color: #2563eb !important; -webkit-print-color-adjust: exact; }
        .bg-blue-50 { background-color: #eff6ff !important; -webkit-print-color-adjust: exact; }
        .bg-gray-900 { background-color: #111827 !important; -webkit-print-color-adjust: exact; color: white !important; }
        .text-white { color: white !important; }
    }
</style>
@endsection