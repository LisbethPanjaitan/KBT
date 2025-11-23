<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - KBT</title>
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-50 via-white to-blue-50">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="max-w-md w-full">
            <!-- Logo -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-600 rounded-2xl mb-4">
                    <i class="fas fa-bus text-white text-2xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-900">KBT Admin</h1>
                <p class="text-gray-600 mt-2">Masuk ke panel administrator</p>
            </div>

            <!-- Login Form -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle text-red-500"></i>
                            <p class="ml-3 text-sm text-red-700">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login.post') }}" x-data="{ show2FA: false }">
                    @csrf

                    <!-- Email -->
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-envelope text-gray-400 mr-2"></i>Email
                        </label>
                        <input type="email" id="email" name="email" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                               placeholder="admin@kbt.com" value="{{ old('email') }}">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-lock text-gray-400 mr-2"></i>Password
                        </label>
                        <div class="relative">
                            <input x-data="{ show: false }" :type="show ? 'text' : 'password'" 
                                   id="password" name="password" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all pr-12"
                                   placeholder="••••••••">
                            <button type="button" @click="show = !show"
                                    class="absolute right-3 top-3 text-gray-400 hover:text-gray-600">
                                <i :class="show ? 'fa-eye-slash' : 'fa-eye'" class="fas"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- 2FA Code (conditional) -->
                    <div x-show="show2FA" x-cloak class="mb-6" x-transition>
                        <label for="otp_code" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-shield-alt text-gray-400 mr-2"></i>Kode 2FA
                        </label>
                        <input type="text" id="otp_code" name="otp_code" maxlength="6"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-center text-2xl tracking-widest"
                               placeholder="000000">
                        <p class="mt-2 text-xs text-gray-500">Masukkan kode 6 digit dari aplikasi authenticator Anda</p>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" 
                                   class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                        </label>
                        <a href="{{ route('admin.password.request') }}" class="text-sm text-blue-600 hover:text-blue-700">
                            Lupa password?
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Masuk
                    </button>

                    <!-- 2FA Toggle (for testing) -->
                    <div class="mt-4 text-center">
                        <button type="button" @click="show2FA = !show2FA" 
                                class="text-sm text-gray-500 hover:text-gray-700">
                            <span x-show="!show2FA">Aktifkan 2FA</span>
                            <span x-show="show2FA" x-cloak>Sembunyikan 2FA</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Security Notice -->
            <div class="mt-6 text-center text-sm text-gray-600">
                <i class="fas fa-lock mr-1"></i>
                Koneksi aman dengan enkripsi SSL
            </div>
        </div>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
