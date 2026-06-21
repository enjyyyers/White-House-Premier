<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Get app instance
$app = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Create a request to simulate POST login
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Test 1: Direct Auth::attempt
echo "=== Direct Auth::attempt ===\n";
$r1 = Auth::attempt(['email' => 'admin@gmail.com', 'password' => 'admin123']);
echo "Admin: " . ($r1 ? 'SUCCESS' : 'FAIL') . "\n";
$r2 = Auth::attempt(['email' => 'user@gmail.com', 'password' => 'user1234']);
echo "User: " . ($r2 ? 'SUCCESS' : 'FAIL') . "\n";

echo "\n=== Check User Model ===\n";
$admin = App\Models\User::where('email', 'admin@gmail.com')->first();
echo 'Admin password cast: ' . gettype($admin->password) . "\n";
echo 'Admin password length: ' . strlen($admin->password) . "\n";
echo 'Admin role: ' . $admin->role . "\n";

// Test validation rules
echo "\n=== Validation Test ===\n";
$v = Illuminate\Support\Facades\Validator::make(
    ['email' => 'admin@gmail.com', 'password' => 'admin123'],
    ['email' => 'required|email', 'password' => 'required|min:8']
);
echo 'Validation passes: ' . ($v->passes() ? 'YES' : 'NO') . "\n";
if ($v->fails()) {
    echo 'Errors: ' . json_encode($v->errors()->all()) . "\n";
}

echo "\n=== All good! ===\n";
