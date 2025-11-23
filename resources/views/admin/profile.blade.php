@extends('layouts.admin')

@section('title', 'Profile Admin')
@section('page-title', 'Profile Saya')

@section('content')
<div class="space-y-6">
    <!-- Profile Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="h-32 bg-gradient-to-r from-blue-500 to-blue-600"></div>
        <div class="px-6 pb-6">
            <div class="flex items-end -mt-16 mb-4">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3b82f6&color=fff&size=128" 
                     class="w-32 h-32 rounded-full border-4 border-white shadow-lg" alt="">
                <div class="ml-6 mb-2">
                    <h2 class="text-2xl font-bold text-gray-900">{{ Auth::user()->name }}</h2>
                    <p class="text-gray-600">{{ Auth::user()->email }}</p>
                    <span class="inline-block mt-2 px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">
                        {{ ucfirst(Auth::user()->role ?? 'Admin') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Personal Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-900">Informasi Personal</h3>
                    <button onclick="openModal('editProfileModal')" class="text-blue-600 hover:text-blue-700">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                </div>
                
                <div class="space-y-4">
                    <div class="flex items-center">
                        <div class="w-32 text-sm text-gray-600">Nama Lengkap</div>
                        <div class="flex-1 font-medium text-gray-900">{{ Auth::user()->name }}</div>
                    </div>
                    <div class="flex items-center">
                        <div class="w-32 text-sm text-gray-600">Email</div>
                        <div class="flex-1 font-medium text-gray-900">{{ Auth::user()->email }}</div>
                    </div>
                    <div class="flex items-center">
                        <div class="w-32 text-sm text-gray-600">No. Telepon</div>
                        <div class="flex-1 font-medium text-gray-900">{{ Auth::user()->phone ?? '-' }}</div>
                    </div>
                    <div class="flex items-center">
                        <div class="w-32 text-sm text-gray-600">Role</div>
                        <div class="flex-1">
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">
                                {{ ucfirst(Auth::user()->role ?? 'Admin') }}
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="w-32 text-sm text-gray-600">Bergabung</div>
                        <div class="flex-1 font-medium text-gray-900">{{ Auth::user()->created_at->format('d M Y') }}</div>
                    </div>
                </div>
            </div>

            <!-- Change Password -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-6">Ganti Password</h3>
                
                <form class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password Lama</label>
                        <input type="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                        <input type="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                        <input type="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div class="flex justify-end pt-2">
                        <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                            <i class="fas fa-key mr-2"></i>Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Security & Activity -->
        <div class="space-y-6">
            <!-- Security Settings -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-6">Keamanan</h3>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-medium text-gray-900">Two-Factor Auth</p>
                            <p class="text-sm text-gray-500">Aktifkan 2FA</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <div class="pt-4 border-t border-gray-200">
                        <p class="text-sm font-medium text-gray-700 mb-2">Password terakhir diubah</p>
                        <p class="text-sm text-gray-500">30 hari yang lalu</p>
                    </div>

                    <div class="pt-4 border-t border-gray-200">
                        <p class="text-sm font-medium text-gray-700 mb-2">Login terakhir</p>
                        <p class="text-sm text-gray-500">Hari ini, 09:23 WIB</p>
                        <p class="text-xs text-gray-400 mt-1">IP: 127.0.0.1</p>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-6">Aktivitas Hari Ini</h3>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-ticket-alt text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Booking Diproses</p>
                                <p class="text-xl font-bold text-gray-900">24</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-check-circle text-green-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Pembayaran Konfirmasi</p>
                                <p class="text-xl font-bold text-gray-900">18</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-clock text-orange-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Total Jam Kerja</p>
                                <p class="text-xl font-bold text-gray-900">4.5 jam</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div id="editProfileModal" data-modal="overlay" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0, 0, 0, 0.5); z-index: 9999; padding: 1rem; overflow-y: auto;">
    <div class="bg-white rounded-xl max-w-lg w-full mx-auto my-8">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900">Edit Profile</h3>
                <button onclick="closeModal('editProfileModal')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        
        <form class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                <input type="text" value="{{ Auth::user()->name }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" value="{{ Auth::user()->email }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">No. Telepon</label>
                <input type="tel" value="{{ Auth::user()->phone }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200">
                <button type="button" onclick="closeModal('editProfileModal')" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                    <i class="fas fa-save mr-2"></i>Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openModal(id) {
    const modal = document.getElementById(id);
    modal.style.display = 'flex';
    modal.style.alignItems = 'center';
    modal.style.justifyContent = 'center';
}
function closeModal(id) {
    document.getElementById(id).style.display = 'none';
}
</script>
@endpush
