@extends('layouts.admin')

@section('title', 'Kelola Pemesanan')
@section('page-title', 'Kelola Pemesanan')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        @php
            $cards = [
                ['Total Pemesanan', $stats['total'] ?? 0, 'text-gray-900'],
                ['Confirmed', $stats['confirmed'] ?? 0, 'text-green-600'],
                ['Pending', $stats['pending'] ?? 0, 'text-orange-600'],
                ['Cancelled', $stats['cancelled'] ?? 0, 'text-red-600'],
                ['Refunded', $stats['refunded'] ?? 0, 'text-purple-600'],
            ];
        @endphp
        @foreach($cards as $item)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <p class="text-sm text-gray-600">{{ $item[0] }}</p>
                <p class="text-2xl font-bold {{ $item[2] }} mt-1">
                    {{ number_format($item[1], 0, ',', '.') }}
                </p>
            </div>
        @endforeach
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.bookings.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div class="md:col-span-2">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari Nama / Kode Booking / HP" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <select name="status" class="w-full px-4 py-2 border rounded-lg">
                    <option value="">Semua Status</option>
                    @foreach(['Confirmed','Pending','Cancelled','Refunded'] as $st)
                        <option value="{{ $st }}" {{ request('status') === $st ? 'selected' : '' }}>{{ $st }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <input type="date" name="date" value="{{ request('date') }}" class="w-full px-4 py-2 border rounded-lg">
            </div>
            <button class="bg-blue-600 text-white rounded-lg font-bold">Cari</button>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold uppercase">Kode Booking</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase">Penumpang</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase">Rute & Jadwal</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase">Total</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <span class="font-bold text-blue-600">{{ $booking->booking_code }}</span>
                                <p class="text-[10px] text-gray-400 uppercase mt-1">{{ str_replace('_', ' ', $booking->payment_method) }}</p>
                            </td>
                            <td class="px-6 py-4">
                                @foreach($booking->passengers as $p)
                                    <p class="font-semibold text-gray-900 leading-tight">{{ $p->full_name }}</p>
                                    <p class="text-xs text-gray-500">{{ $p->phone_number }}</p>
                                @endforeach
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <p class="font-bold text-gray-800">
                                    {{ $booking->schedule->route->origin_city ?? '-' }} → {{ $booking->schedule->route->destination_city ?? '-' }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($booking->schedule->departure_date)->format('d M Y') }}
                                </p>
                            </td>
                            <td class="px-6 py-4 font-bold">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-blue-600"><i class="fas fa-eye"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-12 text-center text-gray-400 italic">Data tidak ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t bg-gray-50">{{ $bookings->links() }}</div>
    </div>
</div>
@endsection