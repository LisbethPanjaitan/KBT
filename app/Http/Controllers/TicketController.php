<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class TicketController extends Controller
{
    public function check()
    {
        return view('ticket.check');
    }
    
    public function search(Request $request)
    {
        $request->validate([
            'booking_code' => 'required|string',
            'email' => 'required|email'
        ]);
        
        $booking = Booking::where('booking_code', $request->booking_code)
            ->whereHas('passengers', function($q) use ($request) {
                $q->where('email', $request->email);
            })
            ->with(['schedule.bus', 'schedule.route', 'seats', 'passengers', 'payment'])
            ->first();
        
        if (!$booking) {
            return redirect()->back()
                ->with('error', 'Pesanan tidak ditemukan. Periksa kembali kode booking dan email Anda.');
        }
        
        return view('ticket.show', compact('booking'));
    }
    
    public function show($bookingId)
    {
        $booking = Booking::with(['schedule.bus', 'schedule.route', 'seats', 'passengers', 'payment'])
            ->findOrFail($bookingId);
        
        return view('ticket.show', compact('booking'));
    }
    
    public function download($bookingId)
    {
        $booking = Booking::with(['schedule.bus', 'schedule.route', 'seats', 'passengers'])
            ->findOrFail($bookingId);
        
        // TODO: Generate PDF ticket
        return redirect()->back()
            ->with('info', 'Fitur download PDF akan segera tersedia.');
    }
    
    public function checkin(Request $request, $bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        
        // TODO: Implement QR code scanning and check-in
        return response()->json([
            'success' => true,
            'message' => 'Check-in berhasil'
        ]);
    }
}
