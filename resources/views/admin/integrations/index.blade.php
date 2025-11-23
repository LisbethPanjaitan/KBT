@extends('layouts.admin')

@section('title', 'Integrasi & Automasi')
@section('page-title', 'Integrasi & Automasi')

@section('content')
<div class="space-y-6">
    <!-- Integrations -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-6">Integrasi Eksternal</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $integrations = [
                    ['name' => 'WhatsApp Business API', 'icon' => 'fab fa-whatsapp', 'color' => 'green', 'status' => 'connected', 'description' => 'Kirim notifikasi dan reminder otomatis'],
                    ['name' => 'Google Maps API', 'icon' => 'fas fa-map-marked-alt', 'color' => 'red', 'description' => 'Tracking GPS real-time dan estimasi waktu', 'status' => 'connected'],
                    ['name' => 'Payment Gateway - Midtrans', 'icon' => 'fas fa-credit-card', 'color' => 'blue', 'description' => 'Pembayaran online multi-channel', 'status' => 'connected'],
                    ['name' => 'SMS Gateway', 'icon' => 'fas fa-sms', 'color' => 'purple', 'description' => 'Notifikasi SMS untuk penumpang', 'status' => 'connected'],
                    ['name' => 'Email Service (SMTP)', 'icon' => 'fas fa-envelope', 'color' => 'indigo', 'description' => 'Kirim e-ticket dan konfirmasi', 'status' => 'connected'],
                    ['name' => 'Accounting System', 'icon' => 'fas fa-chart-pie', 'color' => 'orange', 'description' => 'Sinkronisasi data ke sistem akuntansi', 'status' => 'disconnected'],
                ];
            @endphp

            @foreach($integrations as $integration)
            <div class="border-2 border-gray-200 rounded-xl p-6 hover:border-blue-400 hover:shadow-md transition-all">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-14 h-14 bg-{{ $integration['color'] }}-100 rounded-xl flex items-center justify-center">
                        <i class="{{ $integration['icon'] }} text-{{ $integration['color'] }}-600 text-2xl"></i>
                    </div>
                    @if($integration['status'] == 'connected')
                        <span class="px-3 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">
                            <i class="fas fa-check-circle mr-1"></i>Connected
                        </span>
                    @else
                        <span class="px-3 py-1 text-xs font-medium bg-gray-100 text-gray-700 rounded-full">
                            <i class="fas fa-times-circle mr-1"></i>Not Connected
                        </span>
                    @endif
                </div>
                
                <h4 class="font-bold text-gray-900 text-lg mb-2">{{ $integration['name'] }}</h4>
                <p class="text-sm text-gray-600 mb-4">{{ $integration['description'] }}</p>
                
                <div class="flex space-x-2">
                    @if($integration['status'] == 'connected')
                        <button class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium">
                            <i class="fas fa-cog mr-1"></i>Konfigurasi
                        </button>
                        <button class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg text-sm font-medium">
                            <i class="fas fa-unlink"></i>
                        </button>
                    @else
                        <button class="flex-1 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium">
                            <i class="fas fa-plug mr-1"></i>Connect
                        </button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Automation Rules -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-bold text-gray-900">Aturan Automasi</h3>
                <p class="text-sm text-gray-600 mt-1">Otomatiskan tugas berulang dan notifikasi</p>
            </div>
            <button onclick="openModal('automationModal')" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                <i class="fas fa-plus mr-2"></i>Tambah Aturan
            </button>
        </div>

        <div class="space-y-4">
            @php
                $automations = [
                    [
                        'name' => 'Auto-Cancel Unpaid Booking',
                        'trigger' => 'Booking pending > 15 menit',
                        'action' => 'Cancel booking & release seat',
                        'status' => 'active',
                        'runs' => 342
                    ],
                    [
                        'name' => 'Reminder Keberangkatan',
                        'trigger' => '2 jam sebelum keberangkatan',
                        'action' => 'Kirim WA & SMS reminder',
                        'status' => 'active',
                        'runs' => 1250
                    ],
                    [
                        'name' => 'Delay Notification',
                        'trigger' => 'Bus delay > 15 menit',
                        'action' => 'Broadcast notifikasi ke penumpang',
                        'status' => 'active',
                        'runs' => 23
                    ],
                    [
                        'name' => 'Daily Sales Report',
                        'trigger' => 'Setiap hari @ 23:59',
                        'action' => 'Email laporan ke manager',
                        'status' => 'active',
                        'runs' => 365
                    ],
                    [
                        'name' => 'Birthday Promo',
                        'trigger' => 'H-7 ulang tahun customer',
                        'action' => 'Kirim voucher diskon via email',
                        'status' => 'paused',
                        'runs' => 89
                    ],
                ];
            @endphp

            @foreach($automations as $automation)
            <div class="flex items-center justify-between p-4 border-2 border-gray-200 rounded-lg hover:border-blue-400 transition-colors">
                <div class="flex items-start space-x-4 flex-1">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-bolt text-purple-600 text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center space-x-3 mb-2">
                            <h4 class="font-semibold text-gray-900 text-lg">{{ $automation['name'] }}</h4>
                            @if($automation['status'] == 'active')
                                <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-700 rounded">Active</span>
                            @else
                                <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-700 rounded">Paused</span>
                            @endif
                        </div>
                        <div class="flex items-center space-x-4 text-sm text-gray-600">
                            <span><i class="fas fa-play-circle text-blue-600 mr-1"></i>Trigger: {{ $automation['trigger'] }}</span>
                            <span><i class="fas fa-arrow-right text-gray-400 mr-1"></i>Action: {{ $automation['action'] }}</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">
                            <i class="fas fa-check-circle mr-1"></i>Dijalankan {{ number_format($automation['runs']) }} kali
                        </p>
                    </div>
                </div>
                <div class="flex items-center space-x-2 ml-4">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" {{ $automation['status'] == 'active' ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
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

    <!-- API Documentation -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">API Documentation</h3>
        <p class="text-gray-600 mb-4">Akses API untuk integrasi dengan sistem eksternal</p>
        
        <div class="bg-gray-50 rounded-lg p-4">
            <div class="flex items-center justify-between mb-3">
                <p class="text-sm font-medium text-gray-700">API Base URL</p>
                <button class="text-sm text-blue-600 hover:text-blue-700">
                    <i class="fas fa-copy mr-1"></i>Copy
                </button>
            </div>
            <code class="text-sm bg-white px-4 py-2 rounded border border-gray-200 block">https://api.kbt.com/v1</code>
        </div>

        <div class="mt-4 bg-gray-50 rounded-lg p-4">
            <div class="flex items-center justify-between mb-3">
                <p class="text-sm font-medium text-gray-700">API Key</p>
                <button class="text-sm text-blue-600 hover:text-blue-700">
                    <i class="fas fa-refresh mr-1"></i>Regenerate
                </button>
            </div>
            <code class="text-sm bg-white px-4 py-2 rounded border border-gray-200 block">••••••••••••••••••••••••••••••••</code>
        </div>

        <div class="mt-6">
            <a href="#" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium">
                <i class="fas fa-book mr-2"></i>Buka Dokumentasi API
            </a>
        </div>
    </div>
</div>

<!-- Automation Modal -->
<!-- @formatter:off -->
<div id="automationModal" data-modal="overlay" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0, 0, 0, 0.5); z-index: 9999; padding: 1rem; overflow-y: auto;">
<!-- @formatter:on -->
    <div class="bg-white rounded-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto mx-auto my-auto">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900">Buat Aturan Automasi Baru</h3>
                <button onclick="closeModal('automationModal')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        
        <form class="p-6 space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Aturan *</label>
                <input type="text" placeholder="Contoh: Auto-Cancel Unpaid Booking" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Trigger (Kondisi) *</label>
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option>Pilih Trigger</option>
                    <option>Booking Created</option>
                    <option>Payment Received</option>
                    <option>Booking Cancelled</option>
                    <option>Schedule Time</option>
                    <option>Bus Delay</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kondisi Tambahan</label>
                <input type="text" placeholder="Contoh: pending > 15 menit" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Action (Tindakan) *</label>
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option>Pilih Action</option>
                    <option>Cancel Booking</option>
                    <option>Send Notification</option>
                    <option>Send Email</option>
                    <option>Update Status</option>
                    <option>Create Report</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <textarea rows="3" placeholder="Jelaskan aturan automasi ini..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            <div>
                <label class="flex items-center">
                    <input type="checkbox" checked class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <span class="ml-2 text-sm text-gray-700">Aktifkan aturan setelah disimpan</span>
                </label>
            </div>

            <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200">
                <button type="button" onclick="closeModal('automationModal')" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                    <i class="fas fa-save mr-2"></i>Simpan Aturan
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
