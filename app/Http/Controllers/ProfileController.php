<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Booking;

class ProfileController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get user's recent bookings
        $recentBookings = Booking::where('user_id', $user->id)
            ->with(['schedule.route', 'schedule.bus'])
            ->latest()
            ->take(5)
            ->get();
        
        // Get booking statistics
        $totalBookings = Booking::where('user_id', $user->id)->count();
        $upcomingTrips = Booking::where('user_id', $user->id)
            ->whereHas('schedule', function($q) {
                $q->where('departure_date', '>=', now()->toDateString());
            })
            ->count();
        $completedTrips = Booking::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();
        
        return view('profile.dashboard', compact(
            'user', 
            'recentBookings', 
            'totalBookings', 
            'upcomingTrips', 
            'completedTrips'
        ));
    }
    
    public function bookings(Request $request)
    {
        $user = Auth::user();
        
        $query = Booking::where('user_id', $user->id)
            ->with(['schedule.route', 'schedule.bus', 'seats', 'payment']);
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Sort
        $query->orderBy('created_at', 'desc');
        
        $bookings = $query->paginate(10);
        
        return view('profile.bookings', compact('bookings'));
    }
    
    public function settings()
    {
        $user = Auth::user();
        return view('profile.settings', compact('user'));
    }
    
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
        ]);
        
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);
        
        return redirect()->back()
            ->with('success', 'Profil berhasil diperbarui!');
    }
    
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);
        
        $user = Auth::user();
        
        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->with('error', 'Password lama tidak sesuai!');
        }
        
        // Update password
        $user->update([
            'password' => Hash::make($request->password)
        ]);
        
        return redirect()->back()
            ->with('success', 'Password berhasil diubah!');
    }
}
