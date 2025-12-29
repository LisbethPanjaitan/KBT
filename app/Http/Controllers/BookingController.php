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

class BookingController extends Controller
{
    /**
     * Helper statistik pemesanan
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

    /**
     * SIMPAN PEMESANAN MANUAL
     * FIX: Integrasi QRIS & Mapping agar tidak error CHECK constraint
     */
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

            /**
             * FIX UTAMA: Mapping untuk tabel BOOKINGS
             * Karena 'shopeepay' ditolak oleh tabel bookings, gunakan 'bank_transfer' sebagai kategori umum
             * untuk metode non-tunai.
             */
            $methodMapForBooking = [
                'cash'     => 'pay_at_counter',
                'transfer' => 'bank_transfer',
                'qris'     => 'bank_transfer' // Gunakan 'bank_transfer' agar lolos CHECK constraint bookings
            ];
            $finalBookingMethod = $methodMapForBooking[$request->payment_method] ?? 'pay_at_counter';

            // 1. Simpan ke Tabel Bookings
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
                'source'         => 'loket',
            ]);

            // 2. Simpan Penumpang & Hubungkan Kursi
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

            // 3. Simpan ke Tabel Payments (Gunakan 'shopeepay' di sini karena diizinkan)
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
            return response()->json([
                'success' => false,
                'message' => 'Gagal: ' . $e->getMessage()
            ], 500);
        }
    }
}