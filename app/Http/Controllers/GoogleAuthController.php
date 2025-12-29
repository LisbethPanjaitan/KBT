<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Redirect to Google for authentication
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    /**
     * Handle callback from Google
     */
    public function handleGoogleCallback()
    {
        try {
            // Configure Guzzle to work with localhost SSL
            $googleUser = Socialite::driver('google')
                ->setHttpClient(new \GuzzleHttp\Client(['verify' => false]))
                ->user();
            
            \Log::info('Google User Data:', [
                'id' => $googleUser->getId(),
                'email' => $googleUser->getEmail(),
                'name' => $googleUser->getName()
            ]);
            
            // Find or create user
            $user = User::where('google_id', $googleUser->getId())
                       ->orWhere('email', $googleUser->getEmail())
                       ->first();

            if ($user) {
                // Update existing user with Google info
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                ]);
            } else {
                // Create new user
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'role' => 'user', // Default role
                    'password' => null, // No password for Google users
                ]);
            }

            // Login user
            Auth::login($user);
            
            \Log::info('User logged in successfully:', [
                'user_id' => $user->id,
                'role' => $user->role,
                'email' => $user->email
            ]);

            // Redirect based on role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Selamat datang kembali, ' . $user->name . '!');
            }

            return redirect()->route('home')
                ->with('success', 'Login berhasil! Selamat datang, ' . $user->name . '!');

        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            \Log::error('Google OAuth State Error:', ['message' => $e->getMessage()]);
            return redirect()->route('login')->with('error', 'Login dengan Google gagal: Sesi tidak valid. Silakan coba lagi.');
            
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            \Log::error('Google OAuth Client Error:', [
                'message' => $e->getMessage(),
                'response' => $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : 'No response'
            ]);
            return redirect()->route('login')->with('error', 'Google Client Error (401): Periksa Client ID/Secret atau tambahkan test user di Google Console.');
            
        } catch (\Exception $e) {
            \Log::error('Google Login Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('login')->with('error', 'Login dengan Google gagal: ' . $e->getMessage());
        }
    }
}
