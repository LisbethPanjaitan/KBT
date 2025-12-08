<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    /**
     * Redirect user to Google OAuth page
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->scopes(['email', 'profile'])
            ->redirect();
    }

    /**
     * Handle Google OAuth callback
     */
    public function handleGoogleCallback()
    {
        try {
            // Get user info from Google
            $googleUser = Socialite::driver('google')->user();
            
            // Check if user exists by email
            $user = User::where('email', $googleUser->getEmail())->first();
            
            if ($user) {
                // Update existing user with Google ID if not set
                if (!$user->google_id) {
                    $user->update([
                        'google_id' => $googleUser->getId(),
                        'avatar' => $googleUser->getAvatar(),
                    ]);
                }
            } else {
                // Create new user
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'email_verified_at' => now(),
                    'password' => Hash::make(Str::random(24)), // Random password
                    'role' => 'user', // Default role
                ]);
            }
            
            // Login user
            Auth::login($user, true);
            
            // Redirect to intended page or home
            return redirect()->intended(route('home'))
                ->with('success', 'Berhasil login dengan Google!');
                
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Gagal login dengan Google: ' . $e->getMessage());
        }
    }

    /**
     * Admin Google OAuth redirect
     */
    public function redirectToGoogleAdmin()
    {
        return Socialite::driver('google')
            ->scopes(['email', 'profile'])
            ->with(['prompt' => 'select_account']) // Force account selection
            ->redirect();
    }

    /**
     * Handle Admin Google OAuth callback
     */
    public function handleGoogleCallbackAdmin()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Check if user exists and is admin
            $user = User::where('email', $googleUser->getEmail())
                ->where('role', 'admin')
                ->first();
            
            if (!$user) {
                return redirect()->route('admin.login')
                    ->with('error', 'Email tidak terdaftar sebagai admin atau tidak memiliki akses.');
            }
            
            // Update Google ID if not set
            if (!$user->google_id) {
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                ]);
            }
            
            // Login admin
            Auth::login($user, true);
            
            return redirect()->route('admin.dashboard')
                ->with('success', 'Selamat datang kembali, ' . $user->name . '!');
                
        } catch (\Exception $e) {
            return redirect()->route('admin.login')
                ->with('error', 'Gagal login dengan Google: ' . $e->getMessage());
        }
    }

    /**
     * Unlink Google account
     */
    public function unlinkGoogle(Request $request)
    {
        $user = $request->user();
        
        if (!$user->password || Hash::check('', $user->password)) {
            return back()->with('error', 'Tidak dapat unlink Google. Silakan set password terlebih dahulu.');
        }
        
        $user->update([
            'google_id' => null,
            'avatar' => null,
        ]);
        
        return back()->with('success', 'Akun Google berhasil di-unlink.');
    }
}
