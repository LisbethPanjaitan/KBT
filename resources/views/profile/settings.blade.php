@extends('layouts.app')

@section('title', 'Pengaturan - KBT')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Pengaturan Akun</h1>

        @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded">
            <div class="flex items-center">
                <i class="bi bi-check-circle text-green-500 text-xl mr-3"></i>
                <p class="text-green-700">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
            <div class="flex items-center">
                <i class="bi bi-exclamation-triangle text-red-500 text-xl mr-3"></i>
                <p class="text-red-700">{{ session('error') }}</p>
            </div>
        </div>
        @endif

        <!-- Profile Information -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <h2 class="text-xl font-bold mb-6">Informasi Profil</h2>
            
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <input 
                            type="text" 
                            name="name" 
                            value="{{ old('name', $user->name) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                            required>
                        @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input 
                            type="email" 
                            name="email" 
                            value="{{ old('email', $user->email) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                            required>
                        @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">No. WhatsApp</label>
                        <input 
                            type="tel" 
                            name="phone" 
                            value="{{ old('phone', $user->phone) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone') border-red-500 @enderror"
                            required>
                        @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="btn-primary">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <!-- Change Password -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-xl font-bold mb-6">Ubah Password</h2>
            
            <form method="POST" action="{{ route('profile.password') }}">
                @csrf
                @method('PUT')
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password Lama</label>
                        <input 
                            type="password" 
                            name="current_password" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('current_password') border-red-500 @enderror"
                            required>
                        @error('current_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                        <input 
                            type="password" 
                            name="password" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror"
                            required>
                        @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Minimal 8 karakter</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            required>
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition">
                        <i class="bi bi-key"></i> Ubah Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
