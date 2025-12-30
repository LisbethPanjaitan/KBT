@extends('layouts.app')

@section('title', 'Konfirmasi Pembayaran - ' . $booking->booking_code)

@section('content')
<div class="bg-gray-50 min-h-screen py-16">
    <div class="max-w-xl mx-auto px-4">
        <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
            <h2 class="text-2xl font-black text-gray-900 uppercase italic mb-2 tracking-tighter">Konfirmasi Pembayaran</h2>
            <p class="text-xs text-gray-500 mb-8 uppercase font-bold tracking-widest">Booking Code: <span class="text-blue-600">{{ $booking->booking_code }}</span></p>

            <form action="{{ route('ticket.payment.upload', $booking->booking_code) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div class="p-6 border-2 border-dashed border-gray-200 rounded-3xl bg-gray-50 text-center">
                    <label class="block cursor-pointer">
                        <i class="fas fa-cloud-upload-alt text-4xl text-blue-500 mb-3"></i>
                        <span class="block text-sm font-black text-gray-700 uppercase">Pilih Foto Struk/Bukti Transfer</span>
                        <input type="file" name="payment_proof" required class="hidden" onchange="this.nextElementSibling.innerText = this.files[0].name">
                        <span class="mt-2 block text-[10px] text-blue-600 font-bold italic">Klik untuk memilih file...</span>
                    </label>
                </div>

                <div class="bg-blue-50 p-4 rounded-2xl border border-blue-100">
                    <p class="text-[10px] text-blue-800 font-bold leading-relaxed">
                        <i class="fas fa-info-circle mr-1"></i> Pastikan foto bukti transfer terlihat jelas, mencantumkan nominal, tanggal, dan nomor rekening tujuan.
                    </p>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-2xl shadow-lg transition transform active:scale-95 uppercase tracking-widest">
                    KIRIM BUKTI PEMBAYARAN
                </button>
            </form>
        </div>
    </div>
</div>
@endsection