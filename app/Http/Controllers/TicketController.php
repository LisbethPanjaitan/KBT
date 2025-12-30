<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

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
            'phone_number' => 'required|string'
        ]);

        $code = strtoupper(trim($request->booking_code));
        $phone = trim($request->phone_number);
        
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
        
        return redirect()->route('ticket.show', $booking->booking_code);
    }
    
    public function show($bookingCode)
    {
        $booking = Booking::where('booking_code', strtoupper($bookingCode))
            ->with(['schedule.bus', 'schedule.route', 'seats', 'passengers', 'payment'])
            ->firstOrFail();
        
        return view('ticket.show', compact('booking'));
    }

    /**
     * Tampilkan Halaman Form Unggah Bukti Bayar
     */
    public function paymentForm($bookingCode)
    {
        $booking = Booking::where('booking_code', strtoupper($bookingCode))->firstOrFail();
        
        if ($booking->status !== 'pending') {
            return redirect()->route('ticket.show', $bookingCode)
                             ->with('info', 'Pesanan ini sudah tidak memerlukan konfirmasi pembayaran.');
        }

        return view('ticket.payment_confirmation', compact('booking'));
    }

    /**
     * Proses Simpan Bukti Pembayaran ke Storage
     */
    public function uploadPayment(Request $request, $bookingCode)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $booking = Booking::where('booking_code', strtoupper($bookingCode))->firstOrFail();

        if ($request->hasFile('payment_proof')) {
            // Simpan file ke folder storage/app/public/payment_proofs
            $path = $request->file('payment_proof')->store('payment_proofs', 'public');
            
            // Update atau buat data di tabel payments
            $booking->payment()->updateOrCreate(
                ['booking_id' => $booking->id],
                [
                    'proof_path' => $path,
                    'status' => 'pending', // Menunggu verifikasi admin
                    'payment_date' => now()
                ]
            );

            return redirect()->route('ticket.show', $bookingCode)
                             ->with('success', 'Bukti pembayaran berhasil diunggah. Admin akan segera memverifikasi pesanan Anda.');
        }

        return back()->with('error', 'Gagal memproses file gambar.');
    }
    
    public function download($bookingId)
    {
        $booking = Booking::with(['schedule.bus', 'schedule.route', 'seats', 'passengers'])->findOrFail($bookingId);
        return redirect()->back()->with('info', 'Fitur download PDF sedang disiapkan.');
    }
    
    public function checkin(Request $request, $bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        
        if ($booking->status !== 'confirmed') {
            return response()->json(['success' => false, 'message' => 'Gagal: Pembayaran belum dikonfirmasi.'], 400);
        }

        $booking->update(['checked_in_at' => now()]);
        return response()->json(['success' => true, 'message' => 'Check-in berhasil!']);
    }
}