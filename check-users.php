<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== DAFTAR USER TERDAFTAR ===\n\n";
echo "Total Users: " . App\Models\User::count() . "\n\n";

$users = App\Models\User::all();

echo str_pad("ID", 5) . str_pad("Name", 20) . str_pad("Email", 30) . str_pad("Role", 10) . "Created At\n";
echo str_repeat("-", 90) . "\n";

foreach ($users as $user) {
    echo str_pad($user->id, 5) 
        . str_pad($user->name, 20) 
        . str_pad($user->email, 30) 
        . str_pad($user->role, 10) 
        . $user->created_at->format('Y-m-d H:i') . "\n";
}

echo "\n";
