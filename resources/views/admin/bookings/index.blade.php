@extends('layouts.admin')

@section('title', 'Kelola Pemesanan')
@section('page-title', 'Kelola Pemesanan')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        @php
            $cards = [
                ['Total Pemesanan', $stats['total'] ?? 0, 'text-gray-900', 'fa-shopping-cart'],
                ['Confirmed', $stats['confirmed'] ?? 0, 'text-green-600', 'fa-check-circle'],
                ['Pending', $stats['pending'] ?? 0, 'text-orange-600', 'fa-clock'],
                ['Cancelled', $stats['cancelled'] ?? 0, 'text-red-600', 'fa-times-circle'],
                ['Refunded', $stats['refunded'] ?? 0, 'text-purple-600', 'fa-undo'],
            ];
        @endphp
        @foreach($cards as $item)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center space-x-4">
                <div class="p-3 rounded-lg bg-gray-50 {{ $item[2] }}">
                    <i class="fas {{ $item[3] }} text-xl"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">{{ $item[0] }}</p>
                    <p class="text-2xl font-black {{ $item[2] }} mt-1">
                        {{ number_format($item[1], 0, ',', '.') }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.bookings.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div class="md:col-span-2">
                <label class="text-[10px] font-black text-gray-400 uppercase mb-1 block">Pencarian</label>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari Nama / Kode Booking / HP" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div>
                <label class="text-[10px] font-black text-gray-400 uppercase mb-1 block">Filter Status</label>
                <select name="status" class="w-full px-4 py-2 border rounded-lg outline-none">
                    <option value="">Semua Status</option>
                    @foreach(['Confirmed','Pending','Cancelled','Refunded'] as $st)
                        <option value="{{ strtolower($st) }}" {{ request('status') === strtolower($st) ? 'selected' : '' }}>{{ $st }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-[10px] font-black text-gray-400 uppercase mb-1 block">Tanggal Keberangkatan</label>
                <input type="date" name="date" value="{{ request('date') }}" class="w-full px-4 py-2 border rounded-lg outline-none">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-bold py-2 transition">
                    <i class="fas fa-search mr-2"></i> Cari
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-4 text-xs font-black uppercase text-gray-400">Booking</th>
                        <th class="px-6 py-4 text-xs font-black uppercase text-gray-400">Penumpang</th>
                        <th class="px-6 py-4 text-xs font-black uppercase text-gray-400">Jadwal</th>
                        <th class="px-6 py-4 text-xs font-black uppercase text-gray-400">Status & Pembayaran</th>
                        <th class="px-6 py-4 text-xs font-black uppercase text-gray-400 text-center">Kelola</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <span class="font-black text-blue-600 tracking-tighter">{{ $booking->booking_code }}</span>
                                <div class="flex items-center mt-1">
                                    <span class="text-[10px] font-bold px-2 py-0.5 bg-gray-100 rounded text-gray-500 uppercase">
                                        {{ str_replace('_', ' ', $booking->payment_method) }}
                                    </span>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                @foreach($booking->passengers as $p)
                                    <p class="font-bold text-gray-900 leading-tight text-sm">{{ $p->full_name }}</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase mb-2">{{ $p->phone_number }}</p>
                                @endforeach
                            </td>

                            <td class="px-6 py-4">
                                <p class="text-xs font-black text-gray-800 uppercase">
                                    {{ $booking->schedule->route->origin_city ?? '-' }} 
                                    <i class="fas fa-long-arrow-alt-right mx-1 text-blue-400"></i> 
                                    {{ $booking->schedule->route->destination_city ?? '-' }}
                                </p>
                                <p class="text-[10px] font-bold text-gray-500 mt-1 uppercase">
                                    {{ \Carbon\Carbon::parse($booking->schedule->departure_date)->format('d M Y') }}
                                </p>
                            </td>

                            <td class="px-6 py-4">
                                <p class="font-black text-gray-900 mb-2">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</p>
                                
                                <div class="flex items-center space-x-2">
                                    @if($booking->payment && $booking->payment->proof_path)
                                        <a href="{{ Storage::url($booking->payment->proof_path) }}" target="_blank" class="w-8 h-8 rounded-lg bg-green-100 text-green-600 flex items-center justify-center hover:bg-green-600 hover:text-white transition shadow-sm" title="Lihat Bukti Transfer">
                                            <i class="fas fa-image text-xs"></i>
                                        </a>
                                    @else
                                        <div class="w-8 h-8 rounded-lg bg-gray-100 text-gray-400 flex items-center justify-center italic text-[8px] font-bold" title="Belum Unggah Bukti">NO</div>
                                    @endif

                                    <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest 
                                        {{ $booking->status == 'confirmed' ? 'bg-green-100 text-green-700' : '' }}
                                        {{ $booking->status == 'pending' ? 'bg-orange-100 text-orange-700 animate-pulse' : '' }}
                                        {{ $booking->status == 'cancelled' ? 'bg-red-100 text-red-700' : '' }}
                                    ">
                                        {{ $booking->status }}
                                    </span>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <form action="{{ route('admin.bookings.updateStatus', $booking->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" onchange="if(confirm('Ubah status pesanan ini?')) this.form.submit()" class="text-[10px] font-black border-gray-200 rounded-lg p-1 pr-6 focus:ring-blue-500 outline-none uppercase">
                                            <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Paid/Confirm</option>
                                            <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancel</option>
                                            <option value="refunded" {{ $booking->status == 'refunded' ? 'selected' : '' }}>Refund</option>
                                        </select>
                                    </form>

                                    <a href="{{ route('admin.bookings.show', $booking->id) }}" class="p-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition">
                                        <i class="fas fa-eye text-xs"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center opacity-30">
                                    <i class="fas fa-box-open text-5xl mb-4"></i>
                                    <p class="font-black uppercase tracking-widest text-sm">Data Pemesanan Kosong</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t bg-gray-50">{{ $bookings->links() }}</div>
    </div>
</div>
@endsection