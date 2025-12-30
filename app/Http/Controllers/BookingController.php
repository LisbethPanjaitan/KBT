<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Seat;
use App\Models\Booking;
use App\Models\Passenger;
use App\Models\Route as BusRoute;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * ==========================================
     * BAGIAN ADMIN & STATISTIK
     * ==========================================
     */

    private function getStats()
    {
        return [
            'total'     => Booking::count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'pending'   => Booking::where('status', 'pending')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
            'refunded'  => Booking::where('status', 'refunded')->count(),
        ];
    }

    public function index(Request $request)
    {
        $query = Booking::with(['passengers', 'schedule.route']);

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('booking_code', 'like', "%{$search}%")
                  ->orWhereHas('passengers', function ($p) use ($search) {
                      $p->where('full_name', 'like', "%{$search}%")
                        ->orWhere('phone_number', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', strtolower($request->status));
        }

        $bookings = $query->latest()->paginate(10)->withQueryString();
        $stats = $this->getStats();

        return view('admin.bookings.index', compact('bookings', 'stats'));
    }

    public function pending()
    {
        $bookings = Booking::with(['passengers', 'schedule.route'])->where('status', 'pending')->latest()->paginate(10);
        $stats = $this->getStats();
        return view('admin.bookings.index', compact('bookings', 'stats'));
    }

    /**
     * ==========================================
     * BAGIAN PEMESANAN LOKET (ADMIN)
     * ==========================================
     */

    public function manualCreate(Request $request)
    {
        $origins = BusRoute::distinct()->pluck('origin_city');
        $destinations = BusRoute::distinct()->pluck('destination_city');
        $schedules = [];

        if ($request->filled(['origin', 'destination', 'date'])) {
            $schedules = Schedule::with('route')
                ->whereHas('route', function ($q) use ($request) {
                    $q->where('origin_city', $request->origin)->where('destination_city', $request->destination);
                })
                ->whereDate('departure_date', $request->date)
                ->get();
        }

        return view('admin.loket.create', compact('origins', 'destinations', 'schedules'));
    }

    public function getSeats($scheduleId)
    {
        return response()->json(Seat::where('schedule_id', $scheduleId)->orderBy('seat_number')->get());
    }

    public function manualStore(Request $request)
    {
        $request->validate([
            'schedule_id'    => 'required|exists:schedules,id',
            'payment_method' => 'required',
            'passengers'     => 'required|array|min:1',
        ]);

        DB::beginTransaction();

        try {
            $schedule = Schedule::findOrFail($request->schedule_id);
            $totalSeatsCount = count($request->passengers);
            $subtotal = $schedule->price * $totalSeatsCount;

            $methodMapForBooking = [
                'cash'     => 'pay_at_counter',
                'transfer' => 'bank_transfer',
                'qris'     => 'bank_transfer'
            ];
            $finalBookingMethod = $methodMapForBooking[$request->payment_method] ?? 'pay_at_counter';

            $booking = Booking::create([
                'user_id'        => auth()->id(),
                'schedule_id'    => $schedule->id,
                'booking_code'   => 'LK-' . strtoupper(Str::random(8)),
                'payment_method' => $finalBookingMethod, 
                'status'         => 'confirmed',
                'total_seats'    => $totalSeatsCount,
                'subtotal'       => $subtotal,      
                'total_amount'   => $subtotal, 
                'qr_code'        => (string) Str::uuid(),
            ]);

            foreach ($request->passengers as $p) {
                $passenger = Passenger::create([
                    'booking_id'   => $booking->id,
                    'full_name'    => $p['name'],
                    'phone_number' => $p['phone'],
                    'passenger_type'=> 'adult'
                ]);

                Seat::where('id', $p['seat_id'])->update(['status' => 'booked']);
                
                $booking->seats()->attach($p['seat_id'], [
                    'passenger_id' => $passenger->id,
                    'seat_price'   => $schedule->price,
                ]);
            }

            // Update Kapasitas Jadwal
            $schedule->decrement('available_seats', $totalSeatsCount);

            DB::table('payments')->insert([
                'booking_id'     => $booking->id,
                'payment_code'   => 'PAY-' . strtoupper(Str::random(10)),
                'payment_method' => ($request->payment_method == 'qris') ? 'shopeepay' : $finalBookingMethod,
                'amount'         => $subtotal,
                'status'         => 'paid',
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);

            DB::commit();

            return response()->json([
                'success'  => true,
                'message'  => 'Pemesanan Berhasil disimpan!',
                'redirect' => route('admin.bookings.index')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Gagal: ' . $e->getMessage()], 500);
        }
    }

    /**
     * ==========================================
     * BAGIAN PEMESANAN ONLINE (USER)
     * ==========================================
     */

    /**
     * TAMPILAN PILIH KURSI (USER)
     */
    public function selectSeats($scheduleId)
    {
        $schedule = Schedule::with(['bus', 'route', 'seats'])->findOrFail($scheduleId);
        
        if (!$schedule->isBookable()) {
            return redirect()->route('search')->with('error', 'Jadwal ini sudah tidak tersedia.');
        }
        
        return view('booking.seats', compact('schedule'));
    }

    /**
     * TAMPILAN CHECKOUT (USER)
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'seat_ids' => 'required|array|min:1',
        ]);
        
        $schedule = Schedule::with(['bus', 'route'])->findOrFail($request->schedule_id);
        $seats = Seat::whereIn('id', $request->seat_ids)->get();
        
        foreach ($seats as $seat) {
            if ($seat->status !== 'available') {
                return redirect()->back()->with('error', "Kursi {$seat->seat_number} sudah tidak tersedia.");
            }
        }
        
        $addons = \App\Models\Addon::where('status', 'active')->get();
        
        return view('booking.checkout', compact('schedule', 'seats', 'addons'));
    }

    /**
     * PROSES SIMPAN PEMESANAN (USER)
     * Menghubungkan pesanan user ke database agar muncul di Admin
     */
    public function store(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'seat_ids' => 'required|array|min:1',
            'passengers' => 'required|array',
            'passengers.*.name' => 'required|string',
            'passengers.*.phone' => 'required|string',
            'payment_method' => 'required|string'
        ]);

        DB::beginTransaction();

        try {
            $schedule = Schedule::findOrFail($request->schedule_id);
            $totalSeatsCount = count($request->seat_ids);
            $subtotal = $schedule->price * $totalSeatsCount;

            // Mapping metode pembayaran
            $methodMap = ['cash' => 'pay_at_counter', 'transfer' => 'bank_transfer', 'qris' => 'bank_transfer'];
            $finalMethod = $methodMap[$request->payment_method] ?? 'bank_transfer';

            // 1. BUAT DATA BOOKING
            $booking = Booking::create([
                'user_id'        => auth()->id(), 
                'schedule_id'    => $schedule->id,
                'booking_code'   => 'KBT-' . strtoupper(Str::random(8)),
                'total_seats'    => $totalSeatsCount,
                'subtotal'       => $subtotal,
                'total_amount'   => $subtotal,
                'payment_method' => $finalMethod,
                'status'         => 'pending', // User perlu konfirmasi bayar
                'qr_code'        => (string) Str::uuid(),
            ]);

            // 2. SIMPAN PENUMPANG & UPDATE STATUS KURSI
            foreach ($request->seat_ids as $index => $seatId) {
                $pData = $request->passengers[$index];

                $passenger = Passenger::create([
                    'booking_id'   => $booking->id,
                    'full_name'    => $pData['name'],
                    'phone_number' => $pData['phone'],
                    'passenger_type' => 'adult'
                ]);

                // Update Kursi jadi 'booked'
                Seat::where('id', $seatId)->update(['status' => 'booked']);

                // Hubungkan kursi ke booking di tabel pivot
                $booking->seats()->attach($seatId, [
                    'passenger_id' => $passenger->id,
                    'seat_price'   => $schedule->price,
                ]);
            }

            // 3. KURANGI KAPASITAS TERSEDIA DI JADWAL
            $schedule->decrement('available_seats', $totalSeatsCount);

            // 4. BUAT RECORD PEMBAYARAN PENDING
            DB::table('payments')->insert([
                'booking_id'     => $booking->id,
                'payment_code'   => 'PAY-' . strtoupper(Str::random(10)),
                'payment_method' => ($request->payment_method == 'qris') ? 'shopeepay' : $finalMethod,
                'amount'         => $subtotal,
                'status'         => 'pending',
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);

            DB::commit();

            return redirect()->route('booking.confirmation', $booking->id)
                ->with('success', 'Pemesanan berhasil! Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
        }
    }

    /**
     * HALAMAN KONFIRMASI (USER)
     */
    public function confirmation($bookingId)
    {
        $booking = Booking::with(['schedule.bus', 'schedule.route', 'seats', 'passengers'])
            ->findOrFail($bookingId);
        
        return view('booking.confirmation', compact('booking'));
    }
}