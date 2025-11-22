@extends('layouts.app')

@section('title', 'Bantuan & FAQ - KBT')

@section('content')
<div class="bg-gray-50 min-h-screen py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Pusat Bantuan</h1>
            <p class="text-xl text-gray-600">Temukan jawaban untuk pertanyaan Anda</p>
        </div>

        <!-- Contact Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="bg-white rounded-xl shadow-md p-6 text-center">
                <div class="inline-block bg-blue-100 rounded-full p-4 mb-4">
                    <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">Telepon</h3>
                <p class="text-gray-600 mb-4">Senin - Minggu<br>08:00 - 20:00 WIB</p>
                <a href="tel:+628001234567" class="text-blue-600 font-semibold hover:text-blue-700">
                    0800-123-4567
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 text-center">
                <div class="inline-block bg-green-100 rounded-full p-4 mb-4">
                    <svg class="h-8 w-8 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">WhatsApp</h3>
                <p class="text-gray-600 mb-4">Chat dengan kami<br>24/7</p>
                <a href="https://wa.me/628123456789" target="_blank" class="text-green-600 font-semibold hover:text-green-700">
                    0812-3456-789
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 text-center">
                <div class="inline-block bg-purple-100 rounded-full p-4 mb-4">
                    <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">Email</h3>
                <p class="text-gray-600 mb-4">Balas dalam 1x24 jam</p>
                <a href="mailto:support@kbt.co.id" class="text-purple-600 font-semibold hover:text-purple-700">
                    support@kbt.co.id
                </a>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="bg-white rounded-xl shadow-md p-8">
            <h2 class="text-3xl font-bold mb-8">Pertanyaan yang Sering Diajukan (FAQ)</h2>
            
            <div x-data="{ activeTab: 'booking' }" class="space-y-6">
                <!-- Tab Navigation -->
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8">
                        <button @click="activeTab = 'booking'" 
                                :class="activeTab === 'booking' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Pemesanan
                        </button>
                        <button @click="activeTab = 'payment'" 
                                :class="activeTab === 'payment' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Pembayaran
                        </button>
                        <button @click="activeTab = 'ticket'" 
                                :class="activeTab === 'ticket' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            E-Ticket
                        </button>
                        <button @click="activeTab = 'refund'" 
                                :class="activeTab === 'refund' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Refund
                        </button>
                    </nav>
                </div>

                <!-- Booking Tab -->
                <div x-show="activeTab === 'booking'" class="space-y-4">
                    <details class="group">
                        <summary class="flex justify-between items-center cursor-pointer p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                            <span class="font-semibold">Bagaimana cara memesan tiket?</span>
                            <svg class="h-5 w-5 text-gray-500 group-open:rotate-180 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </summary>
                        <div class="p-4 text-gray-600">
                            <ol class="list-decimal list-inside space-y-2">
                                <li>Pilih menu "Cari Tiket" di halaman utama</li>
                                <li>Masukkan kota asal, tujuan, dan tanggal keberangkatan</li>
                                <li>Pilih jadwal yang tersedia dan klik "Pilih Kursi"</li>
                                <li>Pilih nomor kursi yang diinginkan</li>
                                <li>Isi data penumpang dan pilih metode pembayaran</li>
                                <li>Lakukan pembayaran sesuai instruksi</li>
                                <li>E-ticket akan dikirim ke email Anda</li>
                            </ol>
                        </div>
                    </details>

                    <details class="group">
                        <summary class="flex justify-between items-center cursor-pointer p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                            <span class="font-semibold">Berapa lama kursi di-hold setelah dipilih?</span>
                            <svg class="h-5 w-5 text-gray-500 group-open:rotate-180 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </summary>
                        <div class="p-4 text-gray-600">
                            Kursi yang Anda pilih akan di-hold selama 10 menit. Setelah itu, kursi akan dilepas secara otomatis jika pembayaran belum diselesaikan.
                        </div>
                    </details>

                    <details class="group">
                        <summary class="flex justify-between items-center cursor-pointer p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                            <span class="font-semibold">Apakah bisa memesan untuk orang lain?</span>
                            <svg class="h-5 w-5 text-gray-500 group-open:rotate-180 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </summary>
                        <div class="p-4 text-gray-600">
                            Ya, Anda bisa memesan tiket untuk orang lain. Pastikan data penumpang yang diinput sesuai dengan identitas yang akan digunakan saat perjalanan.
                        </div>
                    </details>
                </div>

                <!-- Payment Tab -->
                <div x-show="activeTab === 'payment'" class="space-y-4">
                    <details class="group">
                        <summary class="flex justify-between items-center cursor-pointer p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                            <span class="font-semibold">Metode pembayaran apa saja yang tersedia?</span>
                            <svg class="h-5 w-5 text-gray-500 group-open:rotate-180 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </summary>
                        <div class="p-4 text-gray-600">
                            <p class="mb-2">Kami menerima berbagai metode pembayaran:</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li>Transfer Bank (BCA, BNI, BRI, Mandiri)</li>
                                <li>E-Wallet (GoPay, OVO, DANA, LinkAja)</li>
                                <li>Kartu Kredit/Debit (Visa, Mastercard)</li>
                            </ul>
                        </div>
                    </details>

                    <details class="group">
                        <summary class="flex justify-between items-center cursor-pointer p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                            <span class="font-semibold">Berapa lama batas waktu pembayaran?</span>
                            <svg class="h-5 w-5 text-gray-500 group-open:rotate-180 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </summary>
                        <div class="p-4 text-gray-600">
                            Batas waktu pembayaran adalah 1 jam setelah pemesanan dibuat. Pesanan akan otomatis dibatalkan jika pembayaran belum diterima.
                        </div>
                    </details>

                    <details class="group">
                        <summary class="flex justify-between items-center cursor-pointer p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                            <span class="font-semibold">Kapan e-ticket dikirim setelah pembayaran?</span>
                            <svg class="h-5 w-5 text-gray-500 group-open:rotate-180 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </summary>
                        <div class="p-4 text-gray-600">
                            E-ticket akan dikirim ke email Anda secara otomatis maksimal 5 menit setelah pembayaran dikonfirmasi.
                        </div>
                    </details>
                </div>

                <!-- Ticket Tab -->
                <div x-show="activeTab === 'ticket'" class="space-y-4">
                    <details class="group">
                        <summary class="flex justify-between items-center cursor-pointer p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                            <span class="font-semibold">Bagaimana cara melihat e-ticket saya?</span>
                            <svg class="h-5 w-5 text-gray-500 group-open:rotate-180 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </summary>
                        <div class="p-4 text-gray-600">
                            Pilih menu "Cek Pesanan" di website, lalu masukkan kode booking dan email yang digunakan saat pemesanan. E-ticket juga sudah dikirim ke email Anda.
                        </div>
                    </details>

                    <details class="group">
                        <summary class="flex justify-between items-center cursor-pointer p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                            <span class="font-semibold">Apakah harus print e-ticket?</span>
                            <svg class="h-5 w-5 text-gray-500 group-open:rotate-180 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </summary>
                        <div class="p-4 text-gray-600">
                            Tidak wajib. Anda bisa menunjukkan e-ticket dari smartphone. Pastikan QR code terlihat jelas untuk proses check-in.
                        </div>
                    </details>

                    <details class="group">
                        <summary class="flex justify-between items-center cursor-pointer p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                            <span class="font-semibold">Kapan harus datang untuk check-in?</span>
                            <svg class="h-5 w-5 text-gray-500 group-open:rotate-180 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </summary>
                        <div class="p-4 text-gray-600">
                            Harap datang minimal 15 menit sebelum jadwal keberangkatan untuk proses check-in dan pemuatan bagasi.
                        </div>
                    </details>
                </div>

                <!-- Refund Tab -->
                <div x-show="activeTab === 'refund'" class="space-y-4">
                    <details class="group">
                        <summary class="flex justify-between items-center cursor-pointer p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                            <span class="font-semibold">Bagaimana cara membatalkan pesanan?</span>
                            <svg class="h-5 w-5 text-gray-500 group-open:rotate-180 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </summary>
                        <div class="p-4 text-gray-600">
                            Hubungi Customer Service kami via WhatsApp atau telepon dengan menyertakan kode booking. Pembatalan hanya bisa dilakukan maksimal 6 jam sebelum keberangkatan.
                        </div>
                    </details>

                    <details class="group">
                        <summary class="flex justify-between items-center cursor-pointer p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                            <span class="font-semibold">Berapa biaya pembatalan?</span>
                            <svg class="h-5 w-5 text-gray-500 group-open:rotate-180 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </summary>
                        <div class="p-4 text-gray-600">
                            <ul class="list-disc list-inside space-y-1">
                                <li>Lebih dari 24 jam sebelum keberangkatan: 10% dari harga tiket</li>
                                <li>12-24 jam sebelum keberangkatan: 25% dari harga tiket</li>
                                <li>6-12 jam sebelum keberangkatan: 50% dari harga tiket</li>
                                <li>Kurang dari 6 jam: tidak bisa dibatalkan</li>
                            </ul>
                        </div>
                    </details>

                    <details class="group">
                        <summary class="flex justify-between items-center cursor-pointer p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                            <span class="font-semibold">Berapa lama proses refund?</span>
                            <svg class="h-5 w-5 text-gray-500 group-open:rotate-180 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </summary>
                        <div class="p-4 text-gray-600">
                            Proses refund akan diproses dalam 3-7 hari kerja setelah permintaan pembatalan disetujui, tergantung metode pembayaran yang digunakan.
                        </div>
                    </details>
                </div>
            </div>
        </div>

        <!-- Still Need Help -->
        <div class="mt-12 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl shadow-xl p-8 text-white text-center">
            <h2 class="text-3xl font-bold mb-4">Masih Butuh Bantuan?</h2>
            <p class="text-blue-100 mb-6 text-lg">Tim kami siap membantu Anda 24/7</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="https://wa.me/628123456789" target="_blank" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition">
                    <i class="bi bi-chat-dots"></i> Chat WhatsApp
                </a>
                <a href="tel:+628001234567" class="bg-blue-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-400 transition">
                    <i class="bi bi-telephone"></i> Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
