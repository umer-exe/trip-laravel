<?php

// Load Laravel
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Laravel Bootstrapped.\n";

try {
    // 1. Check User
    $user = App\Models\User::first();
    if (!$user) {
        die("Error: No user found in database. Seed the database first.\n");
    }
    echo "User found: {$user->email} (ID: {$user->id})\n";

    // 2. Check Oauth Clients
    $clients = \Illuminate\Support\Facades\DB::table('oauth_clients')->get();
    echo "OAuth Clients found: " . $clients->count() . "\n";
    // foreach ($clients as $client) {
    //     echo " - Client: {$client->name} (Personal: {$client->personal_access_client})\n";
    // }

    // 3. Try to Create Token
    echo "Attempting to create token...\n";
    $token = $user->createToken('DebugToken')->accessToken;
    echo "SUCCESS! Token created: " . substr($token, 0, 50) . "...\n";

} catch (\Throwable $e) {
    echo "CRITICAL ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
