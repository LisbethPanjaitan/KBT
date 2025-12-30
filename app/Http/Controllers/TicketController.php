<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Carbon\Carbon;

class TicketController extends Controller
{
    /**
     * Menampilkan halaman form cek pesanan.
     */
    public function check()
    {
        return view('ticket.check');
    }
    
    /**
     * PROSES PENCARIAN TIKET
     * Mendukung kode booking KBT- (Online) dan LK- (Loket/Admin).
     */
    public function search(Request $request)
    {
        $request->validate([
            'booking_code' => 'required|string',
            'phone_number' => 'required|string'
        ]);

        // Bersihkan input dan paksa menjadi huruf besar (upper case)
        $code = strtoupper(trim($request->booking_code));
        $phone = trim($request->phone_number);
        
        // Cari booking berdasarkan kode DAN nomor HP salah satu penumpang
        $booking = Booking::where('booking_code', $code)
            ->whereHas('passengers', function($q) use ($phone) {
                $q->where('phone_number', 'like', "%{$phone}%");
            })
            ->first();
        
        if (!$booking) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Pesanan tidak ditemukan. Periksa kembali kode booking (KBT-/LK-) dan nomor HP Anda.');
        }
        
        // Arahkan ke halaman detail tiket menggunakan kode booking di URL
        return redirect()->route('ticket.show', $booking->booking_code);
    }
    
    /**
     * TAMPILAN DETAIL TIKET
     * Menggunakan kode booking untuk mencari data secara utuh.
     */
    public function show($bookingCode)
    {
        // Mencari berdasarkan string booking_code, bukan ID
        $booking = Booking::where('booking_code', strtoupper($bookingCode))
            ->with(['schedule.bus', 'schedule.route', 'seats', 'passengers', 'payment'])
            ->firstOrFail();
        
        return view('ticket.show', compact('booking'));
    }
    
    /**
     * Fitur download tiket dalam format PDF.
     */
    public function download($bookingId)
    {
        $booking = Booking::with(['schedule.bus', 'schedule.route', 'seats', 'passengers'])
            ->findOrFail($bookingId);
        
        // Jika nanti menggunakan DomPDF:
        // $pdf = Pdf::loadView('pdf.ticket', compact('booking'));
        // return $pdf->download('tiket-'.$booking->booking_code.'.pdf');

        return redirect()->back()
            ->with('info', 'Fitur download PDF sedang disiapkan.');
    }
    
    /**
     * Proses Check-in penumpang (Update Status di Database)
     */
    public function checkin(Request $request, $bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        
        // Logika: Hanya bisa check-in jika status sudah 'confirmed' (sudah bayar)
        if ($booking->status !== 'confirmed') {
            return response()->json([
                'success' => false,
                'message' => 'Gagal: Pembayaran belum dikonfirmasi.'
            ], 400);
        }

        // Update waktu check-in
        $booking->update([
            'checked_in_at' => now(),
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Check-in berhasil! Penumpang dipersilakan naik ke armada.'
        ]);
    }
}