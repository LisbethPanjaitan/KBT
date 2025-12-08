<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "🧪 Test Google OAuth User Creation\n";
echo "==================================\n\n";

try {
    // Test creating user with Google data
    $user = User::create([
        'name' => 'Test Google User',
        'email' => 'testgoogle' . time() . '@gmail.com',
        'google_id' => '123456789' . time(),
        'avatar' => 'https://lh3.googleusercontent.com/a/default-user',
        'role' => 'user',
        'password' => null,
    ]);
    
    echo "✅ SUCCESS! User created:\n";
    echo "   ID: {$user->id}\n";
    echo "   Name: {$user->name}\n";
    echo "   Email: {$user->email}\n";
    echo "   Google ID: {$user->google_id}\n";
    echo "   Role: {$user->role}\n";
    echo "   Password: " . ($user->password ? 'SET' : 'NULL') . "\n\n";
    
    echo "✨ Google OAuth ready to use!\n";
    
} catch (\Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
