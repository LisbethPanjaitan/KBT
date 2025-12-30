@extends('layouts.app')

@section('title', 'Cek Pesanan - KBT')

@section('content')
<div class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen py-16">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-black text-gray-900 mb-4 uppercase tracking-tight">Cek Pesanan</h1>
            <p class="text-lg text-gray-600">Masukkan kode booking (**KBT-** atau **LK-**) dan nomor HP Anda</p>
        </div>

        @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 shadow-sm rounded-r-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700 font-bold">{{ session('error') }}</p>
                </div>
            </div>
        </div>
        @endif

        <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
            <form method="POST" action="{{ route('ticket.search') }}" class="space-y-6">
                @csrf
                
                {{-- Input Kode Booking --}}
                <div>
                    <label for="booking_code" class="block text-sm font-medium text-gray-700 mb-2 font-bold uppercase tracking-wide">
                        Kode Booking *
                    </label>
                    <input 
                        type="text" 
                        id="booking_code" 
                        name="booking_code" 
                        required
                        value="{{ old('booking_code') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent text-lg font-mono uppercase"
                        placeholder="Contoh: KBT-ABC12345 atau LK-ABC12345">
                    <p class="text-[11px] text-gray-400 mt-1 italic uppercase font-bold">Cek kode di struk loket (LK-) atau email konfirmasi (KBT-)</p>
                </div>

                {{-- Input Nomor HP --}}
                <div>
                    <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-2 font-bold uppercase tracking-wide">
                        Nomor HP Penumpang *
                    </label>
                    <input 
                        type="text" 
                        id="phone_number" 
                        name="phone_number" 
                        required
                        value="{{ old('phone_number') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent text-lg"
                        placeholder="Contoh: 081234567890">
                    <p class="text-[11px] text-gray-400 mt-1 italic uppercase font-bold">Gunakan nomor HP yang didaftarkan saat pemesanan</p>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-xl text-lg shadow-lg shadow-blue-200 transition duration-200 transform active:scale-95">
                    CARI PESANAN SAYA
                </button>
            </form>

            <div class="mt-8 pt-8 border-t border-gray-100">
                <h3 class="text-sm font-black text-gray-900 mb-4 uppercase tracking-widest">Informasi Bantuan</h3>
                <div class="space-y-4 text-xs text-gray-600 font-bold uppercase">
                    <div class="flex items-start">
                        <svg class="h-5 w-5 text-blue-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <p>Pesanan Loket (LK-) dan Online (KBT-) dapat dicari di sini</p>
                    </div>
                    <div class="flex items-start">
                        <svg class="h-5 w-5 text-blue-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                        </svg>
                        <p>Gunakan nomor HP yang Anda berikan kepada petugas loket</p>
                    </div>
                </div>
            </div>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-500 font-bold italic">
                    Butuh bantuan? 
                    <a href="{{ route('help') }}" class="text-blue-600 hover:underline">
                        Hubungi WhatsApp Admin KBT
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection