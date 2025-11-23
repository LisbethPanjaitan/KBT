@extends('layouts.admin')

@section('title', 'Notifikasi & Broadcast')
@section('page-title', 'Notifikasi & Broadcast')

@section('content')
<div class="space-y-6">
    <!-- Quick Actions -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Kirim Notifikasi & Broadcast</h2>
            <p class="text-gray-600 mt-1">Kirim pesan ke penumpang melalui WA, SMS, atau Email</p>
        </div>
        <button onclick="openModal('composerModal')" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg flex items-center font-medium">
            <i class="fas fa-paper-plane mr-2"></i>Buat Broadcast Baru
        </button>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Terkirim Hari Ini</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">1,247</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Pending</p>
                    <p class="text-3xl font-bold text-orange-600 mt-2">89</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Gagal</p>
                    <p class="text-3xl font-bold text-red-600 mt-2">23</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-times-circle text-red-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Delivery Rate</p>
                    <p class="text-3xl font-bold text-blue-600 mt-2">98.2%</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-line text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Broadcast History -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900">Riwayat Broadcast</h3>
                <div class="flex items-center space-x-2">
                    <select class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                        <option>Semua Channel</option>
                        <option>WhatsApp</option>
                        <option>SMS</option>
                        <option>Email</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="divide-y divide-gray-200">
            @php
                $broadcasts = [
                    ['title' => 'Delay Notification - Medan Pematang Siantar 08:00', 'channel' => 'whatsapp', 'audience' => 45, 'sent' => 45, 'delivered' => 43, 'failed' => 2, 'time' => '15 menit yang lalu', 'status' => 'completed'],
                    ['title' => 'Promo Diskon 25% - Semua Rute', 'channel' => 'email', 'audience' => 1250, 'sent' => 1250, 'delivered' => 1242, 'failed' => 8, 'time' => '2 jam yang lalu', 'status' => 'completed'],
                    ['title' => 'Reminder - Keberangkatan Besok', 'channel' => 'sms', 'audience' => 342, 'sent' => 342, 'delivered' => 338, 'failed' => 4, 'time' => '5 jam yang lalu', 'status' => 'completed'],
                    ['title' => 'Perubahan Jadwal - Medan Sibolga', 'channel' => 'whatsapp', 'audience' => 28, 'sent' => 15, 'delivered' => 15, 'failed' => 0, 'time' => '1 hari yang lalu', 'status' => 'sending'],
                ];
            @endphp

            @foreach($broadcasts as $broadcast)
            <div class="p-6 hover:bg-gray-50 transition-colors">
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-4 flex-1">
                        <div class="w-12 h-12 rounded-lg flex items-center justify-center
                            {{ $broadcast['channel'] == 'whatsapp' ? 'bg-green-100' : '' }}
                            {{ $broadcast['channel'] == 'email' ? 'bg-blue-100' : '' }}
                            {{ $broadcast['channel'] == 'sms' ? 'bg-purple-100' : '' }}">
                            @if($broadcast['channel'] == 'whatsapp')
                                <i class="fab fa-whatsapp text-green-600 text-2xl"></i>
                            @elseif($broadcast['channel'] == 'email')
                                <i class="fas fa-envelope text-blue-600 text-xl"></i>
                            @else
                                <i class="fas fa-sms text-purple-600 text-xl"></i>
                            @endif
                        </div>
                        
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900 text-lg">{{ $broadcast['title'] }}</h4>
                            <p class="text-sm text-gray-600 mt-1">
                                <i class="fas fa-users mr-1"></i>{{ number_format($broadcast['audience']) }} penerima
                                <span class="mx-2">•</span>
                                <i class="fas fa-clock mr-1"></i>{{ $broadcast['time'] }}
                            </p>
                            
                            <!-- Delivery Stats -->
                            <div class="flex items-center space-x-6 mt-3">
                                <div class="flex items-center">
                                    <i class="fas fa-paper-plane text-blue-600 mr-2"></i>
                                    <span class="text-sm"><span class="font-semibold">{{ $broadcast['sent'] }}</span> Terkirim</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-check-circle text-green-600 mr-2"></i>
                                    <span class="text-sm"><span class="font-semibold">{{ $broadcast['delivered'] }}</span> Delivered</span>
                                </div>
                                @if($broadcast['failed'] > 0)
                                <div class="flex items-center">
                                    <i class="fas fa-times-circle text-red-600 mr-2"></i>
                                    <span class="text-sm"><span class="font-semibold">{{ $broadcast['failed'] }}</span> Gagal</span>
                                </div>
                                @endif
                            </div>

                            <!-- Progress Bar -->
                            <div class="mt-3 bg-gray-200 rounded-full h-2">
                                <div class="bg-green-600 h-2 rounded-full" 
                                     style="width: {{ ($broadcast['delivered']/$broadcast['audience'])*100 }}%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center space-x-2 ml-4">
                        @if($broadcast['status'] == 'completed')
                            <span class="px-3 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">Selesai</span>
                        @else
                            <span class="px-3 py-1 text-xs font-medium bg-orange-100 text-orange-700 rounded-full">Mengirim...</span>
                        @endif
                        <button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg" title="Detail">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="p-2 text-purple-600 hover:bg-purple-50 rounded-lg" title="Kirim Ulang">
                            <i class="fas fa-redo"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Templates -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-900">Template Notifikasi</h3>
            <button class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm">
                <i class="fas fa-plus mr-2"></i>Tambah Template
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @php
                $templates = [
                    ['name' => 'Booking Confirmation', 'usage' => 1250, 'channels' => ['whatsapp', 'email']],
                    ['name' => 'Payment Reminder', 'usage' => 342, 'channels' => ['sms', 'whatsapp']],
                    ['name' => 'Departure Reminder', 'usage' => 890, 'channels' => ['whatsapp', 'sms', 'email']],
                    ['name' => 'Delay Notification', 'usage' => 45, 'channels' => ['whatsapp']],
                    ['name' => 'Promo Announcement', 'usage' => 2100, 'channels' => ['email', 'whatsapp']],
                    ['name' => 'Cancellation Notice', 'usage' => 120, 'channels' => ['email', 'sms']],
                ];
            @endphp

            @foreach($templates as $template)
            <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-400 hover:shadow-md transition-all cursor-pointer">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="font-semibold text-gray-900">{{ $template['name'] }}</h4>
                    <button class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                </div>
                <p class="text-sm text-gray-600 mb-3">
                    <i class="fas fa-paper-plane mr-1"></i>{{ number_format($template['usage']) }} kali digunakan
                </p>
                <div class="flex items-center space-x-2">
                    @foreach($template['channels'] as $channel)
                        @if($channel == 'whatsapp')
                            <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded"><i class="fab fa-whatsapp mr-1"></i>WA</span>
                        @elseif($channel == 'email')
                            <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded"><i class="fas fa-envelope mr-1"></i>Email</span>
                        @else
                            <span class="px-2 py-1 text-xs bg-purple-100 text-purple-700 rounded"><i class="fas fa-sms mr-1"></i>SMS</span>
                        @endif
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Broadcast Composer Modal -->
<!-- @formatter:off -->
<div id="composerModal" data-modal="overlay" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0, 0, 0, 0.5); z-index: 9999; padding: 1rem; overflow-y: auto;">
<!-- @formatter:on -->
    <div class="bg-white rounded-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto mx-auto my-auto">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900">Composer Broadcast</h3>
                <button onclick="closeModal('composerModal')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        
        <form class="p-6 space-y-6">
            <!-- Channel Selection -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">Pilih Channel *</label>
                <div class="grid grid-cols-3 gap-4">
                    <label class="relative cursor-pointer">
                        <input type="checkbox" name="channel[]" value="whatsapp" class="peer sr-only">
                        <div class="p-4 border-2 border-gray-300 rounded-lg peer-checked:border-green-600 peer-checked:bg-green-50 transition-all">
                            <div class="flex items-center justify-center mb-2">
                                <i class="fab fa-whatsapp text-3xl text-green-600"></i>
                            </div>
                            <p class="text-center font-semibold text-gray-900">WhatsApp</p>
                        </div>
                    </label>

                    <label class="relative cursor-pointer">
                        <input type="checkbox" name="channel[]" value="sms" class="peer sr-only">
                        <div class="p-4 border-2 border-gray-300 rounded-lg peer-checked:border-purple-600 peer-checked:bg-purple-50 transition-all">
                            <div class="flex items-center justify-center mb-2">
                                <i class="fas fa-sms text-3xl text-purple-600"></i>
                            </div>
                            <p class="text-center font-semibold text-gray-900">SMS</p>
                        </div>
                    </label>

                    <label class="relative cursor-pointer">
                        <input type="checkbox" name="channel[]" value="email" class="peer sr-only">
                        <div class="p-4 border-2 border-gray-300 rounded-lg peer-checked:border-blue-600 peer-checked:bg-blue-50 transition-all">
                            <div class="flex items-center justify-center mb-2">
                                <i class="fas fa-envelope text-3xl text-blue-600"></i>
                            </div>
                            <p class="text-center font-semibold text-gray-900">Email</p>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Audience Selection -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Target Audience *</label>
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option>Semua Penumpang</option>
                    <option>Penumpang Jadwal Tertentu</option>
                    <option>Penumpang Hari Ini</option>
                    <option>Penumpang Besok</option>
                    <option>Penumpang dengan Booking Pending</option>
                    <option>Custom Segment</option>
                </select>
            </div>

            <!-- Message Composer -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Judul Broadcast *</label>
                <input type="text" placeholder="Contoh: Promo Diskon 25%" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Pesan *</label>
                <textarea rows="6" placeholder="Tulis pesan Anda di sini..." 
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"></textarea>
                <p class="text-xs text-gray-500 mt-2">
                    <i class="fas fa-info-circle mr-1"></i>Gunakan {nama}, {booking_code}, {jadwal} untuk personalisasi
                </p>
            </div>

            <!-- Schedule -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Waktu Kirim</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option>Kirim Sekarang</option>
                        <option>Jadwalkan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal & Waktu</label>
                    <input type="datetime-local" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <!-- Preview -->
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-sm font-medium text-gray-700 mb-2">Preview</p>
                <div class="bg-white rounded-lg p-4 border border-gray-200">
                    <p class="text-gray-600 text-sm">Halo <span class="font-semibold">[Nama Penumpang]</span>,</p>
                    <p class="text-gray-800 mt-2">[Pesan Anda akan tampil di sini]</p>
                </div>
            </div>

            <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                <div class="text-sm text-gray-600">
                    <i class="fas fa-users mr-2"></i>Estimasi: <span class="font-semibold">342 penerima</span>
                </div>
                <div class="flex space-x-4">
                    <button type="button" onclick="closeModal('composerModal')" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                        <i class="fas fa-paper-plane mr-2"></i>Kirim Broadcast
                    </button>
                </div>
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
