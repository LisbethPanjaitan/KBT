@extends('layouts.app')

@section('title', 'Cek Pesanan - KBT')

@section('content')
<div class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen py-16">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Cek Pesanan</h1>
            <p class="text-lg text-gray-600">Masukkan kode booking dan email untuk melihat detail pesanan Anda</p>
        </div>

        @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700">{{ session('error') }}</p>
                </div>
            </div>
        </div>
        @endif

        <div class="bg-white rounded-2xl shadow-xl p-8">
            <form method="POST" action="{{ route('ticket.search') }}" class="space-y-6">
                @csrf
                
                <div>
                    <label for="booking_code" class="block text-sm font-medium text-gray-700 mb-2">
                        Kode Booking *
                    </label>
                    <input 
                        type="text" 
                        id="booking_code" 
                        name="booking_code" 
                        required
                        value="{{ old('booking_code') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-lg"
                        placeholder="Contoh: KBT20240315001">
                    <p class="text-sm text-gray-500 mt-1">Kode booking dikirim ke email Anda setelah pemesanan</p>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email *
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        required
                        value="{{ old('email') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-lg"
                        placeholder="email@example.com">
                </div>

                <button type="submit" class="w-full btn-primary py-4 text-lg">
                    Cari Pesanan
                </button>
            </form>

            <div class="mt-8 pt-8 border-t border-gray-200">
                <h3 class="text-lg font-semibold mb-4">Informasi</h3>
                <div class="space-y-3 text-sm text-gray-600">
                    <div class="flex items-start">
                        <svg class="h-5 w-5 text-blue-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <p>Kode booking terdiri dari 3 huruf "KBT" diikuti tanggal dan nomor urut</p>
                    </div>
                    <div class="flex items-start">
                        <svg class="h-5 w-5 text-blue-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                        </svg>
                        <p>Email yang digunakan adalah email yang Anda masukkan saat pemesanan</p>
                    </div>
                    <div class="flex items-start">
                        <svg class="h-5 w-5 text-blue-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <p>Jika tidak menemukan kode booking, periksa folder spam/junk email Anda</p>
                    </div>
                </div>
            </div>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Butuh bantuan? 
                    <a href="{{ route('help') }}" class="text-blue-600 hover:text-blue-700 font-medium">
                        Hubungi Customer Service
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
