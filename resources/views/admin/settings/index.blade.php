@extends('layouts.admin')

@section('title', 'Pengaturan Sistem')
@section('page-title', 'Pengaturan Sistem')

@section('content')
<div class="space-y-6">
    <!-- Navigation Tabs -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-2">
        <div class="flex space-x-2 overflow-x-auto">
            <button onclick="showTab('general')" id="tab-general" class="tab-button active px-6 py-3 rounded-lg font-medium whitespace-nowrap">
                <i class="fas fa-cog mr-2"></i>Umum
            </button>
            <button onclick="showTab('booking')" id="tab-booking" class="tab-button px-6 py-3 rounded-lg font-medium whitespace-nowrap">
                <i class="fas fa-ticket mr-2"></i>Pemesanan
            </button>
            <button onclick="showTab('payment')" id="tab-payment" class="tab-button px-6 py-3 rounded-lg font-medium whitespace-nowrap">
                <i class="fas fa-credit-card mr-2"></i>Pembayaran
            </button>
            <button onclick="showTab('notification')" id="tab-notification" class="tab-button px-6 py-3 rounded-lg font-medium whitespace-nowrap">
                <i class="fas fa-bell mr-2"></i>Notifikasi
            </button>
            <button onclick="showTab('branch')" id="tab-branch" class="tab-button px-6 py-3 rounded-lg font-medium whitespace-nowrap">
                <i class="fas fa-map-marker-alt mr-2"></i>Cabang
            </button>
        </div>
    </div>

    <!-- General Settings -->
    <div id="content-general" class="tab-content">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-6">Pengaturan Umum</h3>
            
            <form class="space-y-6">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Perusahaan</label>
                        <input type="text" value="Koperasi Bintang Tapanuli (KBT)" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email Kontak</label>
                        <input type="email" value="info@kbt.com" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Telepon Kantor</label>
                        <input type="tel" value="061-4567890" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <p class="mt-1 text-xs text-gray-500">Area kode Medan (061)</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">WhatsApp</label>
                        <input type="tel" value="0812-6000-7890" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Kantor Pusat</label>
                    <textarea rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">Jl. Sisingamangaraja No. 123, Medan, Sumatera Utara 20212</textarea>
                </div>

                <div class="grid grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Zona Waktu</label>
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option selected>Asia/Jakarta (WIB - Sumatera Utara)</option>
                            <option>Asia/Makassar (WITA)</option>
                            <option>Asia/Jayapura (WIT)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Bahasa</label>
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option selected>Bahasa Indonesia</option>
                            <option>English</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mata Uang</label>
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option selected>IDR (Rp)</option>
                        </select>
                    </div>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-blue-600 mt-1 mr-3"></i>
                        <div>
                            <h4 class="font-semibold text-blue-900 mb-1">Jangkauan Operasional</h4>
                            <p class="text-sm text-blue-800">Koperasi Bintang Tapanuli (KBT) melayani rute bus antar kota dalam provinsi <strong>Sumatera Utara</strong>. Kami menghubungkan Medan dengan berbagai kota seperti Pematang Siantar, Rantau Prapat, Sibolga, Padang Sidempuan, Berastagi, Kabanjahe, dan kota-kota lainnya di Sumut.</p>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-200">
                    <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Booking Settings -->
    <div id="content-booking" class="tab-content hidden">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-6">Pengaturan Pemesanan</h3>
            
            <form class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Booking Hold Time</label>
                    <div class="flex items-center space-x-4">
                        <input type="number" value="15" class="w-24 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <span class="text-gray-700">menit</span>
                        <p class="text-sm text-gray-500">(Durasi hold kursi sebelum pembayaran)</p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Min. Booking Sebelum Keberangkatan</label>
                    <div class="flex items-center space-x-4">
                        <input type="number" value="2" class="w-24 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <span class="text-gray-700">jam</span>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Max. Pemesanan per Transaksi</label>
                    <input type="number" value="10" class="w-24 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Cancellation Policy</label>
                    <div class="space-y-3">
                        <label class="flex items-center">
                            <input type="radio" name="cancellation" value="flexible" checked class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <span class="ml-2 text-gray-700">Flexible - Pembatalan hingga 6 jam sebelum (Refund 80%)</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="cancellation" value="moderate" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <span class="ml-2 text-gray-700">Moderate - Pembatalan hingga 24 jam sebelum (Refund 50%)</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="cancellation" value="strict" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <span class="ml-2 text-gray-700">Strict - Tidak ada refund</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="flex items-center">
                        <input type="checkbox" checked class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="ml-2 text-gray-700">Izinkan reschedule (ubah jadwal)</span>
                    </label>
                </div>

                <div>
                    <label class="flex items-center">
                        <input type="checkbox" checked class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="ml-2 text-gray-700">Wajib verifikasi identitas penumpang</span>
                    </label>
                </div>

                <div class="pt-6 border-t border-gray-200">
                    <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Payment Settings -->
    <div id="content-payment" class="tab-content hidden">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-6">Metode Pembayaran</h3>
            
            <div class="space-y-4">
                @php
                    $payments = [
                        ['name' => 'Tunai (Cash)', 'icon' => 'fa-money-bill-wave', 'color' => 'green', 'enabled' => true],
                        ['name' => 'Transfer Bank', 'icon' => 'fa-university', 'color' => 'blue', 'enabled' => true],
                        ['name' => 'QRIS', 'icon' => 'fa-qrcode', 'color' => 'purple', 'enabled' => true],
                        ['name' => 'Virtual Account', 'icon' => 'fa-wallet', 'color' => 'indigo', 'enabled' => true],
                        ['name' => 'E-Wallet (GoPay, OVO, Dana)', 'icon' => 'fa-mobile-alt', 'color' => 'orange', 'enabled' => true],
                        ['name' => 'Kartu Kredit/Debit', 'icon' => 'fa-credit-card', 'color' => 'red', 'enabled' => false],
                    ];
                @endphp

                @foreach($payments as $payment)
                <div class="flex items-center justify-between p-4 border-2 border-gray-200 rounded-lg hover:border-blue-400 transition-colors">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-{{ $payment['color'] }}-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas {{ $payment['icon'] }} text-{{ $payment['color'] }}-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $payment['name'] }}</p>
                            <p class="text-sm text-gray-500">{{ $payment['enabled'] ? 'Aktif' : 'Nonaktif' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" {{ $payment['enabled'] ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                        <button class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                            <i class="fas fa-cog"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-6 pt-6 border-t border-gray-200">
                <h4 class="font-semibold text-gray-900 mb-4">Fee & Charges</h4>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Biaya Admin</label>
                        <div class="flex items-center space-x-2">
                            <input type="number" value="5000" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <span class="text-gray-700">IDR</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">PPN (%)</label>
                        <input type="number" value="11" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notification Settings -->
    <div id="content-notification" class="tab-content hidden">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-6">Pengaturan Notifikasi</h3>
            
            <div class="space-y-6">
                <div>
                    <h4 class="font-semibold text-gray-900 mb-4">WhatsApp API</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">API URL</label>
                            <input type="text" placeholder="https://api.whatsapp.com/..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">API Token</label>
                            <input type="password" value="••••••••••••" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="font-semibold text-gray-900 mb-4">SMS Gateway</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Provider</label>
                            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                <option>Twilio</option>
                                <option>Nexmo</option>
                                <option>Zenziva</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">API Key</label>
                            <input type="password" value="••••••••••••" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="font-semibold text-gray-900 mb-4">Email SMTP</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">SMTP Host</label>
                            <input type="text" value="smtp.gmail.com" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">SMTP Port</label>
                            <input type="number" value="587" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                            <input type="email" value="noreply@kbt.com" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                            <input type="password" value="••••••••••••" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-200">
                    <button type="button" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Branch Settings -->
    <div id="content-branch" class="tab-content hidden">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-900">Daftar Cabang</h3>
                <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm">
                    <i class="fas fa-plus mr-2"></i>Tambah Cabang
                </button>
            </div>

            <div class="space-y-4">
                @php
                        $terminals = [
                        ['name' => 'Terminal Amplas', 'city' => 'Medan', 'address' => 'Jl. Sisingamangaraja KM 7.5', 'phone' => '061-7862345', 'status' => 'active'],
                        ['name' => 'Terminal Pinang Baris', 'city' => 'Medan', 'address' => 'Jl. Gatot Subroto', 'phone' => '061-4567890', 'status' => 'active'],
                        ['name' => 'Terminal Pematang Siantar', 'city' => 'Pematang Siantar', 'address' => 'Jl. Merdeka', 'phone' => '0622-21234', 'status' => 'active'],
                        ['name' => 'Terminal Rantau Prapat', 'city' => 'Rantau Prapat', 'address' => 'Jl. Sisingamangaraja', 'phone' => '0624-21567', 'status' => 'active'],
                    ];
                @endphp

                @foreach($branches as $branch)
                <div class="flex items-center justify-between p-4 border-2 border-gray-200 rounded-lg hover:border-blue-400 transition-colors">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-map-marker-alt text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 text-lg">{{ $branch['name'] }}</p>
                            <p class="text-sm text-gray-600 mt-1">{{ $branch['address'] }}, {{ $branch['city'] }}</p>
                            <p class="text-sm text-gray-500 mt-1"><i class="fas fa-phone mr-1"></i>{{ $branch['phone'] }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="px-3 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">{{ $branch['status'] }}</span>
                        <button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="p-2 text-red-600 hover:bg-red-50 rounded-lg">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function showTab(tabName) {
    // Hide all contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active class from all buttons
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active', 'bg-blue-600', 'text-white');
        button.classList.add('text-gray-600', 'hover:bg-gray-100');
    });
    
    // Show selected content
    document.getElementById('content-' + tabName).classList.remove('hidden');
    
    // Add active class to selected button
    const activeButton = document.getElementById('tab-' + tabName);
    activeButton.classList.remove('text-gray-600', 'hover:bg-gray-100');
    activeButton.classList.add('active', 'bg-blue-600', 'text-white');
}
</script>
@endpush
