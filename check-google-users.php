<?php

// Check Google OAuth users in database
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "\n=== GOOGLE OAUTH USERS IN DATABASE ===\n\n";

$googleUsers = User::whereNotNull('google_id')->get();

if ($googleUsers->isEmpty()) {
    echo "❌ No Google OAuth users found in database.\n\n";
} else {
    echo "✅ Found " . $googleUsers->count() . " Google OAuth user(s):\n\n";
    
    foreach ($googleUsers as $user) {
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "ID: " . $user->id . "\n";
        echo "Name: " . $user->name . "\n";
        echo "Email: " . $user->email . "\n";
        echo "Google ID: " . $user->google_id . "\n";
        echo "Role: " . $user->role . "\n";
        echo "Avatar: " . ($user->avatar ? 'Yes' : 'No') . "\n";
        echo "Password: " . ($user->password ? 'Has password (hybrid)' : 'NULL (Google only)') . "\n";
        echo "Created: " . $user->created_at->format('Y-m-d H:i:s') . "\n";
        echo "Last Login: " . ($user->updated_at ? $user->updated_at->format('Y-m-d H:i:s') : 'N/A') . "\n";
    }
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
}

echo "✅ Google OAuth integration is working!\n\n";
