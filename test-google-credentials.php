<?php

// Test Google OAuth credentials
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "\n=== Testing Google OAuth Configuration ===\n\n";

echo "Client ID: " . env('GOOGLE_CLIENT_ID') . "\n";
echo "Client Secret: " . env('GOOGLE_CLIENT_SECRET') . "\n";
echo "Redirect URL: " . env('GOOGLE_REDIRECT_URL') . "\n\n";

// Test if Socialite can create provider
try {
    $provider = \Laravel\Socialite\Facades\Socialite::driver('google');
    echo "✅ Socialite Google driver loaded successfully\n";
    
    // Get config
    $config = config('services.google');
    echo "\n=== Config from services.php ===\n";
    echo "Client ID: " . $config['client_id'] . "\n";
    echo "Client Secret: " . substr($config['client_secret'], 0, 10) . "...\n";
    echo "Redirect: " . $config['redirect'] . "\n\n";
    
    echo "✅ Configuration looks good!\n";
    echo "\n⚠️  If you still get 401 error, please:\n";
    echo "1. Go to Google Cloud Console\n";
    echo "2. Check if Client ID and Secret are EXACTLY the same\n";
    echo "3. Make sure OAuth consent screen is published (or add test users)\n";
    echo "4. Verify redirect URIs are exactly: http://localhost:8000/auth/google/callback\n\n";
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
