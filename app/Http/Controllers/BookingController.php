<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Seat;
use App\Models\Booking;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function selectSeats($scheduleId)
    {
        $schedule = Schedule::with(['bus', 'route', 'seats'])->findOrFail($scheduleId);
        
        // Check if schedule is still bookable
        if (!$schedule->isBookable()) {
            return redirect()->route('search')
                ->with('error', 'Jadwal ini sudah tidak tersedia untuk pemesanan.');
        }
        
        // Release expired held seats
        Seat::where('schedule_id', $scheduleId)
            ->where('status', 'held')
            ->where('held_until', '<', now())
            ->update([
                'status' => 'available',
                'held_until' => null
            ]);
        
        return view('booking.seats', compact('schedule'));
    }
    
    public function holdSeats(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'seat_ids' => 'required|array|min:1',
            'seat_ids.*' => 'exists:seats,id'
        ]);
        
        $seats = Seat::whereIn('id', $request->seat_ids)
            ->where('schedule_id', $request->schedule_id)
            ->get();
        
        // Check if all seats are available
        foreach ($seats as $seat) {
            if (!$seat->isAvailable()) {
                return response()->json([
                    'success' => false,
                    'message' => "Kursi {$seat->seat_number} sudah tidak tersedia."
                ], 400);
            }
        }
        
        // Hold seats for 10 minutes
        foreach ($seats as $seat) {
            $seat->hold(10);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Kursi berhasil di-hold',
            'expires_at' => now()->addMinutes(10)->toIso8601String()
        ]);
    }
    
    public function checkout(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'seat_ids' => 'required|array|min:1',
            'seat_ids.*' => 'required|exists:seats,id'
        ]);
        
        $schedule = Schedule::with(['bus', 'route'])->findOrFail($request->schedule_id);
        $seats = Seat::whereIn('id', $request->seat_ids)
            ->where('schedule_id', $schedule->id)
            ->get();
        
        // Verify all seats are available
        foreach ($seats as $seat) {
            if ($seat->status !== 'available') {
                return redirect()->back()
                    ->with('error', "Kursi {$seat->seat_number} sudah tidak tersedia.");
            }
        }
        
        $addons = \App\Models\Addon::where('status', 'active')->get();
        
        return view('booking.checkout', compact('schedule', 'seats', 'addons'));
    }
    
    public function store(Request $request)
    {
        // Implementation for storing booking
        // This will be completed later with payment integration
        
        return redirect()->route('home')
            ->with('info', 'Fitur booking akan segera tersedia.');
    }
    
    public function confirmation($bookingId)
    {
        $booking = Booking::with(['schedule.bus', 'schedule.route', 'seats', 'passengers'])
            ->findOrFail($bookingId);
        
        return view('booking.confirmation', compact('booking'));
    }
}
