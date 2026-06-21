<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user1 = App\Models\User::where('email', 'admin@gmail.com')->first();
echo '=== Admin User ===' . PHP_EOL;
echo 'Email: ' . $user1->email . PHP_EOL;
echo 'Role: ' . $user1->role . PHP_EOL;
echo 'Password hash: ' . $user1->password . PHP_EOL;
echo 'Hash::check(admin123): ' . (Hash::check('admin123', $user1->password) ? 'OK' : 'FAIL') . PHP_EOL;
echo 'Hash::isHashed: ' . (Hash::isHashed($user1->password) ? 'true' : 'false') . PHP_EOL;

echo PHP_EOL . '=== Auth::attempt test ===' . PHP_EOL;
$result = Auth::attempt(['email' => 'admin@gmail.com', 'password' => 'admin123']);
echo 'Auth::attempt result: ' . ($result ? 'SUCCESS' : 'FAIL') . PHP_EOL;

echo PHP_EOL . '=== User attempt test ===' . PHP_EOL;
$result2 = Auth::attempt(['email' => 'user@gmail.com', 'password' => 'user1234']);
echo 'Auth::attempt result: ' . ($result2 ? 'SUCCESS' : 'FAIL') . PHP_EOL;

echo PHP_EOL . '=== Check errors ===' . PHP_EOL;
echo 'PHP Version: ' . PHP_VERSION . PHP_EOL;
echo 'Laravel Version: ' . $app::VERSION . PHP_EOL;
