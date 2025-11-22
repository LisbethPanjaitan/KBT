# Website Pemesanan Tiket Minibus KBT

## 🎉 Status Development

Website KBT sudah siap untuk dilihat! Server development sudah running di **http://127.0.0.1:8000**

## ✅ Yang Sudah Dikembangkan

### 1. **Database Structure** ✅
- 13 migrations lengkap dengan relationships
- Semua tabel sudah ter-migrate ke database

### 2. **Models** ✅
- 12 Eloquent Models dengan relationships lengkap
- Helper methods dan query scopes
- Auto-generate booking code & QR code

### 3. **Routes** ✅
- Public routes (Home, Search)
- Booking routes
- Payment routes
- Ticket routes
- User dashboard routes
- Admin routes (CRUD)

### 4. **Controllers** ✅
- HomeController (index, search)
- BookingController
- PaymentController
- TicketController
- ProfileController
- Admin Controllers (Dashboard, Bus, Route, Schedule)

### 5. **Views (User Interface)** ✅
- **Homepage** dengan hero section & search form
- **Search Results** dengan filter dan sort
- Layout dengan Tailwind CSS
- Responsive design
- Sections: Popular Routes, How It Works, Why Choose Us, Testimonials

## 🚀 Cara Menjalankan

### 1. Server sudah running di:
```
http://127.0.0.1:8000
```

### 2. Atau jalankan manual:
```bash
php artisan serve
```

### 3. Akses di browser:
- **Homepage**: http://127.0.0.1:8000
- **Search**: http://127.0.0.1:8000/search

## 📋 Halaman Yang Sudah Tersedia

### User Pages:
1. ✅ **Homepage** (`/`) - Hero section, search form, rute populer
2. ✅ **Search Results** (`/search`) - Daftar jadwal dengan filter
3. 🔄 **Seat Selection** (`/booking/seats/{schedule}`) - Akan dibuat
4. 🔄 **Checkout** (`/booking/checkout`) - Akan dibuat
5. 🔄 **E-Ticket** (`/ticket/{booking}`) - Akan dibuat
6. 🔄 **User Dashboard** (`/profile/dashboard`) - Akan dibuat

### Admin Pages (Belum dibuat):
- Dashboard Admin (`/admin/dashboard`)
- Manage Buses (`/admin/buses`)
- Manage Routes (`/admin/routes`)
- Manage Schedules (`/admin/schedules`)

## 🎨 Design Features

- **Modern UI** dengan Tailwind CSS
- **Responsive Design** untuk mobile, tablet, desktop
- **Interactive Components** dengan Alpine.js
- **Smooth Animations** dan transitions
- **Professional Color Scheme** (Blue & Gray)

## 📝 Data yang Dibutuhkan

Untuk melihat website berfungsi penuh, Anda perlu menambahkan data dummy:

### 1. Buat Seeder untuk data dummy:
```bash
php artisan make:seeder BusSeeder
php artisan make:seeder RouteSeeder
php artisan make:seeder ScheduleSeeder
```

### 2. Atau tambahkan manual via Tinker:
```bash
php artisan tinker
```

Kemudian:
```php
// Buat Bus
$bus = \App\Models\Bus::create([
    'plate_number' => 'B 1234 XYZ',
    'bus_type' => 'Minibus Toyota Hiace',
    'total_seats' => 15,
    'rows' => 5,
    'seats_per_row' => 3,
    'status' => 'active',
    'facilities' => 'AC, WiFi, USB Port'
]);

// Buat Route
$route = \App\Models\Route::create([
    'origin_city' => 'Medan',
    'origin_terminal' => 'Terminal Amplas',
    'destination_city' => 'Berastagi',
    'destination_terminal' => 'Terminal Berastagi',
    'distance_km' => 70,
    'estimated_duration_minutes' => 150,
    'base_price' => 45000,
    'status' => 'active'
]);

// Buat Schedule
$schedule = \App\Models\Schedule::create([
    'bus_id' => $bus->id,
    'route_id' => $route->id,
    'departure_date' => today(),
    'departure_time' => '08:00:00',
    'estimated_arrival_time' => '10:30:00',
    'price' => 45000,
    'available_seats' => 15,
    'status' => 'scheduled'
]);

// Buat Seats untuk schedule
for ($i = 1; $i <= 15; $i++) {
    \App\Models\Seat::create([
        'schedule_id' => $schedule->id,
        'seat_number' => 'A' . $i,
        'row_number' => ceil($i / 3),
        'column_number' => (($i - 1) % 3) + 1,
        'status' => 'available',
        'seat_type' => 'standard',
        'extra_price' => 0
    ]);
}
```

## 🔧 Tech Stack

- **Backend**: Laravel 11
- **Frontend**: Blade Templates + Tailwind CSS v4
- **JavaScript**: Alpine.js (CDN)
- **Database**: MySQL
- **Icons**: Heroicons (inline SVG)

## 📚 Dokumentasi Lengkap

Lihat file-file dokumentasi untuk detail lengkap:
- `FITUR_WEBSITE_KBT.md` - Spesifikasi fitur lengkap
- `UI_MOCKUP_DESIGN.md` - Design system & mockups

## 🎯 Next Steps

### Priority 1: Seat Selection & Booking Flow
- Buat halaman seat selection dengan seat map interaktif
- Implement hold mechanism untuk kursi
- Buat halaman checkout dengan form penumpang
- Integration payment gateway

### Priority 2: Admin Panel
- Dashboard admin dengan statistics
- CRUD untuk Buses, Routes, Schedules
- Booking management
- Reports & analytics

### Priority 3: User Dashboard
- User authentication (Laravel Breeze)
- My bookings page
- Profile management
- Booking history

## 🐛 Troubleshooting

### Jika server tidak jalan:
```bash
# Stop server (Ctrl+C di terminal)
# Jalankan ulang
php artisan serve
```

### Jika tampilan tidak muncul:
```bash
# Build ulang assets
npm run build

# Clear cache
php artisan cache:clear
php artisan view:clear
php artisan config:clear
```

### Jika error database:
```bash
# Jalankan ulang migrations
php artisan migrate:fresh
```

## 📞 Support

Untuk pertanyaan atau bantuan, hubungi tim development.

---

**Status**: Development Phase 1 - Frontend User Interface ✅
**Last Updated**: 22 November 2025
**Version**: 1.0.0
