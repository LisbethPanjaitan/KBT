# Website Pemesanan Tiket Minibus KBT - Spesifikasi Fitur Lengkap

## 🚌 Overview Sistem
Website KBT adalah platform digital untuk pemesanan tiket minibus yang menggantikan sistem manual (via telepon/datang ke loket). Sistem ini memiliki 2 role utama: **User (Pelanggan)** dan **Admin (Operator)**.

---

## 👤 FITUR USER (PELANGGAN)

### 1. **Pencarian & Penemuan Tiket**
**Fungsi:**
- Mencari rute perjalanan berdasarkan kota asal, tujuan, dan tanggal keberangkatan
- Filter hasil: jam keberangkatan, harga, durasi perjalanan, tipe kendaraan, ketersediaan kursi
- Sort hasil: termurah, tercepat, keberangkatan terdekat

**UI Components:**
- Form pencarian (Asal, Tujuan, Tanggal, Jumlah penumpang)
- Filter panel (sidebar atau dropdown)
- Card list hasil dengan informasi:
  - Jam berangkat & estimasi tiba
  - Harga per kursi
  - Jumlah kursi tersedia
  - Tipe bus dan fasilitas
  - Rating perjalanan

**Acceptance Criteria:**
- Real-time availability check
- Responsive design untuk mobile
- Loading state saat fetch data

---

### 2. **Pilih Kursi (Seat Map Interaktif)**
**Fungsi:**
- Visualisasi layout kursi kendaraan
- Pilih satu atau multiple kursi sekaligus
- Indikator status kursi:
  - ✅ Tersedia (hijau)
  - ❌ Terisi (abu-abu)
  - ⏳ Di-hold (kuning)
  - 🔧 Rusak/Tidak tersedia (merah)
- Tooltip info kursi: nomor, tipe (standard/premium), harga tambahan

**UI Components:**
- Interactive seat map grid
- Legend untuk status kursi
- Selected seats summary
- Zoom/pan untuk mobile

**Technical:**
- Hold mechanism: kursi di-hold 10 menit saat proses checkout
- Auto-release kursi jika timeout
- WebSocket atau polling untuk real-time seat updates

---

### 3. **Checkout & Pembayaran**
**Fungsi:**
- Ringkasan pemesanan (kursi dipilih, harga, total)
- Form data penumpang (nama, no. HP, email, KTP)
- Pilih add-ons (bagasi ekstra, asuransi, shuttle)
- Pilih metode pembayaran:
  - Transfer Bank (BCA, Mandiri, BRI, BNI)
  - E-wallet (GoPay, OVO, DANA, ShopeePay)
  - Virtual Account
  - Kartu Kredit/Debit
  - Bayar di Loket
- Input kode promo/diskon

**UI Components:**
- Multi-step form wizard
- Order summary sidebar (sticky)
- Payment method cards
- Promo code input dengan validasi
- Countdown timer untuk payment

**Acceptance Criteria:**
- Form validation
- Booking dibuat dengan status "pending" jika pilih "Bayar di Loket"
- Integration dengan payment gateway (Midtrans/Xendit)

---

### 4. **Konfirmasi & E-Ticket**
**Fungsi:**
- Generate e-ticket digital
- E-ticket berisi:
  - Kode booking unik (KBT-XXXXX)
  - QR code untuk scan
  - Detail rute (asal-tujuan, jam, terminal)
  - Nomor kursi
  - Nama penumpang
  - Status pembayaran
- Download sebagai PDF
- Save to Google/Apple Wallet
- Share via WhatsApp/Email

**UI Components:**
- Success page dengan konfetti animation
- E-ticket preview
- Action buttons (Download, Share, Add to Wallet)
- Email notification otomatis

**Technical:**
- QR code encode: booking_code, schedule_id, seat_numbers
- PDF generation library (DomPDF/Laravel-PDF)

---

### 5. **Akun Pengguna & Riwayat Pemesanan**
**Fungsi:**
- Register/Login dengan:
  - Email & password
  - OTP via WhatsApp/SMS
  - Social login (Google, Facebook)
- Dashboard pengguna:
  - Upcoming trips
  - Past trips
  - Cancelled bookings
- Detail booking dengan status tracking
- Request cancel booking
- Simpan data penumpang favorit
- Preferensi kursi favorit

**UI Components:**
- Login/Register modal
- User dashboard layout
- Booking history table/cards
- Profile management form
- Saved passengers list

---

### 6. **Check-in Online & Boarding Pass**
**Fungsi:**
- Web check-in sebelum keberangkatan (cut-off 2 jam sebelum)
- Generate boarding pass digital
- Display QR code untuk scan di pintu masuk

**UI Components:**
- Check-in button pada e-ticket
- Boarding pass dengan QR code
- Countdown timer untuk keberangkatan

---

### 7. **Pembatalan & Refund**
**Fungsi:**
- Request pembatalan booking
- Otomatis calculate refund sesuai kebijakan:
  - >24 jam sebelum: refund 90%
  - 12-24 jam: refund 50%
  - <12 jam: no refund
- Track status refund (pending/approved/processed)
- Input rekening bank untuk refund

**UI Components:**
- Cancel request form
- Refund policy info
- Bank account form
- Status tracker

---

### 8. **Notifikasi & Reminder**
**Fungsi:**
- Booking confirmation
- Payment reminder
- Departure reminder (H-1, 3 jam sebelum)
- Boarding time notification
- Schedule changes/delays
- Refund updates

**Channels:**
- Push notification (web)
- Email
- WhatsApp
- SMS

---

### 9. **Grup Booking & Multi-kursi**
**Fungsi:**
- Pesan banyak kursi sekaligus (untuk rombongan)
- Input data penumpang per kursi
- Split payment (kirim link pembayaran ke teman)

**UI:**
- Passenger management form (dynamic fields)
- Split payment calculator
- Share payment link

---

### 10. **Add-ons & Layanan Tambahan**
**Fungsi:**
- Bagasi ekstra
- Asuransi perjalanan
- Shuttle antar-jemput
- Meal box
- Priority boarding

**UI:**
- Add-ons checkbox list
- Price calculator

---

### 11. **Rating & Review**
**Fungsi:**
- Rate perjalanan (1-5 bintang)
- Review breakdown:
  - Kebersihan bus
  - Ketepatan waktu
  - Kenyamanan
  - Sopir/pelayanan
- Submit feedback/complaint

**UI:**
- Star rating component
- Text review textarea
- Category ratings

---

### 12. **Live Chat & Help Center**
**Fungsi:**
- Live chat dengan CS
- FAQ page
- Contact form
- WhatsApp integration

**UI:**
- Chat widget (bottom-right corner)
- FAQ accordion
- Contact us page

---

## 🔧 FITUR ADMIN (OPERATOR)

### 1. **Dashboard Overview**
**Fungsi:**
- Statistics summary:
  - Total bookings hari ini
  - Revenue hari ini/bulan ini
  - Occupancy rate
  - Pending payments
  - Active schedules
- Charts & graphs:
  - Revenue trends
  - Popular routes
  - Peak booking times
- Quick actions

**UI:**
- Widget cards untuk metrics
- Line/bar charts
- Calendar untuk schedules

---

### 2. **Manajemen Armada (Bus)**
**Fungsi:**
- CRUD buses
- Data bus:
  - Nomor plat
  - Tipe bus (Minibus/Microbus)
  - Total kursi
  - Layout kursi (rows x columns)
  - Fasilitas (AC, WiFi, USB, dll)
  - Tahun pembuatan
  - Status (active/maintenance/inactive)
  - Upload foto
- View maintenance history
- Set bus availability

**UI:**
- Data table dengan search & filter
- Add/Edit bus form modal
- Seat layout configurator
- Image upload

---

### 3. **Manajemen Rute**
**Fungsi:**
- CRUD routes
- Data rute:
  - Kota asal & terminal
  - Kota tujuan & terminal
  - Jarak (km)
  - Estimasi durasi
  - Harga dasar
  - Pemberhentian (stops)
  - Status (active/inactive)

**UI:**
- Routes list table
- Add/Edit route form
- Map integration untuk visualisasi rute

---

### 4. **Manajemen Jadwal**
**Fungsi:**
- CRUD schedules
- Data jadwal:
  - Pilih bus
  - Pilih rute
  - Tanggal keberangkatan
  - Jam berangkat
  - Estimasi tiba
  - Harga (override dari base_price)
  - Status (scheduled/boarding/departed/arrived/cancelled)
- Bulk create jadwal (recurring schedules)
- Cancel schedule dengan notifikasi otomatis
- Update real-time status (departed, arrived)

**UI:**
- Calendar view
- List view dengan filter
- Add/Edit schedule form
- Quick status update buttons

---

### 5. **Manajemen Booking**
**Fungsi:**
- View all bookings dengan filter:
  - Status (pending/confirmed/completed/cancelled)
  - Date range
  - Route
  - User
- Detail booking dengan:
  - Customer info
  - Seats
  - Payment status
  - Passengers
- Actions:
  - Confirm booking
  - Cancel booking
  - Manual check-in
  - Print ticket
- Export bookings (Excel/PDF)

**UI:**
- Data table dengan advanced filter
- Booking detail modal
- Action buttons
- Export tools

---

### 6. **Manajemen Pembayaran**
**Fungsi:**
- View all payments
- Filter by status/method/date
- Manual payment confirmation (untuk bayar di loket/transfer)
- Upload bukti transfer
- Issue refund
- Payment reconciliation

**UI:**
- Payments list dengan status badges
- Payment detail modal
- Confirm payment button
- Upload proof form

---

### 7. **Manajemen Kursi per Schedule**
**Fungsi:**
- View seat map per schedule
- Manual seat assignment
- Mark seat as broken/unavailable
- Release held seats
- View seat history

**UI:**
- Interactive seat map
- Status indicators
- Seat management actions

---

### 8. **Manajemen Penumpang**
**Fungsi:**
- View passenger manifest per schedule
- Print passenger list
- Check-in passengers (scan QR or manual)
- Emergency contact access

**UI:**
- Passenger list table
- QR scanner interface
- Print manifest button

---

### 9. **Manajemen Refund**
**Fungsi:**
- View refund requests
- Approve/Reject refund
- Calculate cancellation fee
- Process refund
- Track refund status

**UI:**
- Refund requests queue
- Approve/Reject buttons
- Refund details modal

---

### 10. **Promo & Diskon**
**Fungsi:**
- Create promo codes
- Promo settings:
  - Code unik
  - Discount type (percentage/fixed)
  - Min. transaction
  - Max. discount
  - Valid date range
  - Usage limit
  - Applicable routes
- Track promo usage
- Disable/enable promo

**UI:**
- Promo codes list
- Create promo form
- Usage analytics

---

### 11. **Laporan & Analytics**
**Fungsi:**
- Sales report (daily/weekly/monthly)
- Route performance report
- Bus occupancy report
- Revenue per route
- Customer analytics
- Booking trends
- Export reports (PDF/Excel)

**UI:**
- Reports dashboard
- Date range picker
- Filter options
- Charts & graphs
- Export buttons

---

### 12. **Manajemen Add-ons**
**Fungsi:**
- CRUD add-ons
- Set prices
- Enable/disable add-ons
- View add-on sales

**UI:**
- Add-ons list
- Add/Edit form

---

### 13. **Manajemen User & Akses**
**Fungsi:**
- View all users (customers)
- View user booking history
- Block/Unblock user
- Admin user management (CRUD admin accounts)
- Role & permission management

**UI:**
- Users data table
- User profile modal
- Admin management section

---

### 14. **Notifikasi & Broadcast**
**Fungsi:**
- Send bulk notifications
- Broadcast announcements
- Schedule changes notification
- Custom message to specific booking/user

**UI:**
- Message composer
- Recipient selector
- Channel selector (Email/WA/SMS)
- Send button

---

### 15. **Settings & Configuration**
**Fungsi:**
- Company info
- Contact details
- Payment gateway settings
- Notification settings
- Booking rules (hold timeout, cancellation policy)
- Email/SMS templates
- System preferences

**UI:**
- Settings tabs
- Configuration forms
- Test buttons untuk integrations

---

## 🎨 UI/UX REQUIREMENTS

### User Interface (Public)
**Design Style:**
- Modern, clean, minimalist
- Mobile-first responsive
- Color scheme: biru (trust), hijau (success), abu-abu (neutral)
- Card-based layouts
- Smooth animations & transitions

**Key Pages:**
1. **Homepage**
   - Hero section dengan search form
   - Popular routes
   - How it works
   - Testimonials
   - Download app CTA

2. **Search Results**
   - Filter sidebar
   - Results grid/list
   - Sort options

3. **Booking Flow**
   - Step indicator
   - Seat selection
   - Passenger info
   - Payment
   - Confirmation

4. **User Dashboard**
   - Sidebar navigation
   - My Tickets tab
   - Profile tab
   - History tab

5. **E-Ticket Page**
   - Ticket card
   - QR code
   - Action buttons

---

### Admin Interface
**Design Style:**
- Professional dashboard layout
- Sidebar navigation
- Data-centric design
- Tables & charts
- Consistent color coding untuk status

**Layout:**
- Fixed sidebar (collapsible on mobile)
- Top navbar dengan user profile
- Breadcrumbs
- Content area

**Key Pages:**
1. **Dashboard**
   - Metrics widgets
   - Charts
   - Recent activities

2. **Data Management Pages**
   - Data tables dengan CRUD
   - Search & filter
   - Pagination
   - Bulk actions

3. **Detail/Form Modals**
   - Overlay modals
   - Multi-step forms
   - Validation messages

---

## 📱 RESPONSIVE DESIGN
- Desktop: Full featured
- Tablet: Adapted layout
- Mobile: Simplified UI, touch-optimized

---

## 🔐 SECURITY FEATURES
- HTTPS only
- CSRF protection
- XSS prevention
- SQL injection prevention
- Rate limiting
- OTP verification
- Secure payment gateway integration

---

## 🚀 PERFORMANCE
- Page load < 3 seconds
- Lazy loading images
- CDN untuk static assets
- Database indexing
- Caching (Redis/Memcached)

---

## 📊 TECH STACK RECOMMENDED

**Backend:**
- Laravel 11
- MySQL 8
- Redis (cache & queue)

**Frontend:**
- Blade Templates + Livewire ATAU
- Vue.js/React (SPA) + Laravel API
- Tailwind CSS + DaisyUI/Flowbite
- Alpine.js untuk interactivity

**Additional:**
- Payment Gateway: Midtrans/Xendit
- WhatsApp API: Fonnte/Wablas
- Email: Mailgun/SendGrid
- QR Code: SimpleSoftwareIO/simple-qrcode
- PDF: Barryvdh/laravel-dompdf
- Charts: Chart.js/ApexCharts

---

## 📅 DEVELOPMENT PHASES

### Phase 1: Foundation (Week 1-2)
- Database design & migrations
- Authentication system
- Basic CRUD admin panels

### Phase 2: Core Features (Week 3-4)
- Search & booking flow
- Seat selection
- Payment integration

### Phase 3: User Experience (Week 5-6)
- E-ticket & QR
- Notifications
- User dashboard

### Phase 4: Advanced Features (Week 7-8)
- Refunds
- Reviews
- Analytics & reports
- Live chat

### Phase 5: Polish & Deploy (Week 9-10)
- Testing
- Bug fixes
- Performance optimization
- Deployment

---

## ✅ ACCEPTANCE CRITERIA SUMMARY

**User Flow Success:**
1. User dapat search rute ✅
2. User dapat pilih kursi secara visual ✅
3. User dapat checkout & bayar ✅
4. User dapat download e-ticket dengan QR ✅
5. User dapat check-in online ✅
6. User dapat cancel & request refund ✅
7. User dapat review perjalanan ✅

**Admin Flow Success:**
1. Admin dapat manage buses, routes, schedules ✅
2. Admin dapat monitor bookings real-time ✅
3. Admin dapat confirm payments ✅
4. Admin dapat process refunds ✅
5. Admin dapat generate reports ✅
6. Admin dapat send notifications ✅

---

## 🎯 PROJECT SUCCESS METRICS

- Reduce booking time: < 5 minutes (vs 15-20 min manual)
- System uptime: 99.9%
- Page load: < 3 seconds
- Payment success rate: > 95%
- User satisfaction: > 4.5/5
- Booking conversion rate: > 40%

---

**Status:** Ready for Development
**Last Updated:** November 22, 2025
**Version:** 1.0
