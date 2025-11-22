# 🧪 Testing Guide - Website KBT

## URLs yang Bisa Diakses Sekarang

### ✅ Halaman Publik (Sudah Berfungsi)

1. **Homepage**
   - URL: `http://127.0.0.1:8000/`
   - Test: Lihat hero section, search form, popular routes
   - Action: Coba search tiket dari form

2. **Search Results**
   - URL: `http://127.0.0.1:8000/search`
   - Test dengan parameter:
     ```
     http://127.0.0.1:8000/search?origin=Medan&destination=Berastagi&date=2024-03-20&passengers=2
     ```
   - Action: Klik tombol "Pilih Kursi" pada salah satu jadwal

3. **Seat Selection**
   - URL: `http://127.0.0.1:8000/booking/seats/{schedule_id}`
   - Contoh: `http://127.0.0.1:8000/booking/seats/1`
   - Test: Klik beberapa kursi hijau (available)
   - Action: Klik "Lanjutkan ke Checkout"

4. **Checkout Page**
   - URL: `http://127.0.0.1:8000/booking/checkout?schedule_id=1&seat_ids[]=1&seat_ids[]=2`
   - Test: 
     - Isi form kontak
     - Isi data penumpang (sesuai jumlah kursi)
     - Pilih add-ons (opsional)
     - Pilih metode pembayaran
   - Action: Klik "Lanjut Pembayaran" (akan redirect karena belum implement)

5. **Cek Pesanan**
   - URL: `http://127.0.0.1:8000/cek-pesanan`
   - Test: 
     - Masukkan kode booking (format: KBT20240315001)
     - Masukkan email
   - Action: Submit form (akan error karena belum ada booking real)

6. **Bantuan**
   - URL: `http://127.0.0.1:8000/bantuan`
   - Test: 
     - Klik tab berbeda (Pemesanan, Pembayaran, E-Ticket, Refund)
     - Buka/tutup accordion FAQ
   - Action: Lihat semua konten FAQ

---

## 🎯 Flow Testing yang Direkomendasikan

### Test Flow 1: Happy Path (Pemesanan Normal)

```
1. Buka Homepage
   → http://127.0.0.1:8000/

2. Isi Search Form:
   - Asal: Medan
   - Tujuan: Berastagi
   - Tanggal: 2024-03-20
   - Penumpang: 2

3. Klik "Cari Tiket"
   → Muncul daftar jadwal tersedia

4. Pilih jadwal (klik "Pilih Kursi")
   → Muncul denah kursi

5. Klik 2 kursi hijau (available)
   → Kursi berubah biru (selected)
   → Total harga update

6. Klik "Lanjutkan ke Checkout"
   → Muncul form checkout dengan countdown timer

7. Isi semua form:
   - Email: test@example.com
   - WhatsApp: 08123456789
   - Data penumpang 1 & 2
   - Pilih add-ons (optional)
   - Pilih metode pembayaran

8. Klik "Lanjut Pembayaran"
   → (Akan redirect ke home karena belum implement payment)
```

### Test Flow 2: Navigation Links

```
1. Dari Homepage, klik "Cari Tiket" di navbar
   ✅ Harus redirect ke /search

2. Klik "Cek Pesanan" di navbar
   ✅ Harus redirect ke /cek-pesanan

3. Klik "Bantuan" di navbar
   ✅ Harus redirect ke /bantuan

4. Klik logo "KBT" di navbar
   ✅ Harus redirect ke homepage (/)
```

### Test Flow 3: Search Filters

```
1. Buka /search
2. Test filter berbeda:
   
   Filter 1:
   - Origin: Medan
   - Destination: Kabanjahe
   - Date: 2024-03-21
   - Sort: Termurah
   ✅ Harus tampil jadwal Medan-Kabanjahe dengan harga terendah dulu

   Filter 2:
   - Origin: Berastagi
   - Destination: Medan
   - Date: 2024-03-22
   - Sort: Paling Awal
   ✅ Harus tampil jadwal Berastagi-Medan dengan waktu paling pagi dulu
```

### Test Flow 4: Seat Selection

```
1. Buka /booking/seats/1
2. Test cases:

   Case 1: Pilih 1 kursi
   - Klik kursi A1
   - Total: 1 × harga
   ✅ Button "Lanjutkan" muncul

   Case 2: Pilih multiple kursi
   - Klik kursi A1, A2, B1
   - Total: 3 × harga
   ✅ Summary update real-time

   Case 3: Unselect kursi
   - Klik lagi kursi yang sudah dipilih
   ✅ Kursi kembali hijau, total berkurang

   Case 4: Klik kursi abu-abu (booked)
   ✅ Tidak bisa diklik

   Case 5: Klik kursi kuning (held)
   ✅ Tidak bisa diklik
```

### Test Flow 5: Checkout Form Validation

```
1. Buka checkout page dengan 2 kursi
2. Test validation:

   Test 1: Submit form kosong
   ✅ Harus tampil error "required"

   Test 2: Email invalid
   - Email: "bukan-email"
   ✅ Harus tampil error format email

   Test 3: No. Identitas < 16 digit
   - ID: "123"
   ✅ Harus tampil error (jika implement validation)

   Test 4: Form lengkap dan valid
   ✅ Bisa submit (redirect karena belum implement)
```

---

## 🔍 Yang Harus Dicek di Setiap Halaman

### Visual & UI
- ✅ Navbar sticky di top
- ✅ Logo KBT terlihat
- ✅ Navigation links berfungsi
- ✅ Footer tampil di bawah
- ✅ Responsive (test di mobile view)
- ✅ Tailwind classes applied
- ✅ No layout breaking

### Functionality
- ✅ Forms bisa disubmit
- ✅ Buttons bisa diklik
- ✅ Links mengarah ke URL yang benar
- ✅ Data dari database tampil
- ✅ No JavaScript errors (check console)
- ✅ Alpine.js components bekerja

### Data Integrity
- ✅ Schedules tampil dari database
- ✅ Buses info benar (tipe, plat nomor)
- ✅ Routes correct (origin → destination)
- ✅ Prices sesuai database
- ✅ Available seats count benar

---

## 🐛 Common Issues & Solutions

### Issue 1: Page Not Found (404)
**Solusi**: 
```bash
php artisan route:list
# Check apakah route terdaftar
```

### Issue 2: Styles Tidak Muncul
**Solusi**: 
```bash
npm run dev
# Atau
npm run build
```

### Issue 3: Data Tidak Muncul
**Solusi**: 
```bash
php artisan migrate:fresh --seed
php artisan db:seed --class=DemoDataSeeder
```

### Issue 4: Alpine.js Tidak Bekerja
**Cek**: 
- View source, pastikan Alpine.js CDN loaded
- Browser console, check JavaScript errors
- Syntax Alpine.js benar (x-data, x-show, @click)

### Issue 5: Navigation Links ke #
**Solusi**: 
- Sudah fixed! Semua links sekarang pakai route()
- Check: resources/views/layouts/app.blade.php

---

## 📊 Database Check Commands

```bash
# Check jumlah data di database
php artisan tinker

>>> \App\Models\Bus::count()
# Should return: 3

>>> \App\Models\Route::count()
# Should return: 6

>>> \App\Models\Schedule::count()
# Should return: 252

>>> \App\Models\Seat::count()
# Should return: 3780

>>> \App\Models\Addon::count()
# Should return: 4

# Check schedules dengan seats available
>>> \App\Models\Schedule::with('bus', 'route')->first()

# Check specific schedule
>>> $schedule = \App\Models\Schedule::find(1)
>>> $schedule->bus->bus_type
>>> $schedule->route->origin_city
>>> $schedule->seats->count()
>>> $schedule->available_seats
```

---

## ✅ Testing Checklist

Print checklist ini dan centang setiap test:

### Homepage
- [ ] Hero section tampil
- [ ] Search form ada 4 fields
- [ ] Popular routes tampil (min 3)
- [ ] "Cara Pemesanan" tampil (4 steps)
- [ ] Testimonials tampil
- [ ] Footer lengkap

### Search Results
- [ ] Filter form berfungsi
- [ ] Schedule cards tampil
- [ ] Timeline perjalanan terlihat
- [ ] Harga tampil dengan format Rp
- [ ] "Pilih Kursi" button berfungsi
- [ ] Sort by price/time works

### Seat Selection
- [ ] Progress indicator step 1 active
- [ ] Trip info lengkap tampil
- [ ] Denah kursi ter-render
- [ ] Legend kursi tampil
- [ ] Bisa select/unselect kursi
- [ ] Total harga update real-time
- [ ] Button "Lanjutkan" muncul setelah select

### Checkout
- [ ] Progress indicator step 2 active
- [ ] Countdown timer berjalan
- [ ] Form kontak tampil
- [ ] Form penumpang sesuai jumlah kursi
- [ ] Add-ons tampil dari database
- [ ] Payment methods tampil
- [ ] Summary order benar
- [ ] Total calculation correct

### Cek Pesanan
- [ ] Form search tampil
- [ ] Placeholder text jelas
- [ ] Info section tampil
- [ ] Link ke help berfungsi

### Bantuan
- [ ] Contact cards tampil (3)
- [ ] Tab navigation berfungsi
- [ ] FAQ accordion expand/collapse
- [ ] Semua konten readable
- [ ] CTA buttons berfungsi

### Navigation
- [ ] Beranda → /
- [ ] Cari Tiket → /search
- [ ] Cek Pesanan → /cek-pesanan
- [ ] Bantuan → /bantuan
- [ ] Logo → /

### Responsive
- [ ] Mobile view (< 640px)
- [ ] Tablet view (640px - 1024px)
- [ ] Desktop view (> 1024px)
- [ ] Hamburger menu di mobile
- [ ] No horizontal scroll

---

## 🎨 Visual Testing

### Colors
- Primary: Blue (#2563EB)
- Secondary: Indigo
- Success: Green
- Warning: Yellow
- Danger: Red
- Gray scale properly applied

### Typography
- Font: Inter
- Headings bold dan jelas
- Body text readable
- Proper hierarchy (h1 > h2 > h3)

### Spacing
- Padding consistent
- Margin proper
- No overlapping elements
- Proper whitespace

### Components
- Buttons ada hover state
- Cards ada shadow
- Inputs ada focus state
- Links ada hover color

---

**Happy Testing! 🚀**

Jika menemukan bug atau issue, catat:
1. URL halaman
2. Action yang dilakukan
3. Expected result
4. Actual result
5. Browser & device info
6. Screenshot/console errors
