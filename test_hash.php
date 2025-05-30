<?php

require 'vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Hash;

// Generate three different hashes for the same password
$hash1 = Hash::make('Admin123!');
$hash2 = Hash::make('Admin123!');
$hash3 = Hash::make('Admin123!');

echo "Hash 1: " . $hash1 . "\n";
echo "Hash 2: " . $hash2 . "\n";
echo "Hash 3: " . $hash3 . "\n\n";

// Verify all hashes against the original password
echo "Verifying Hash 1: " . (Hash::check('Admin123!', $hash1) ? "Correct" : "Wrong") . "\n";
echo "Verifying Hash 2: " . (Hash::check('Admin123!', $hash2) ? "Correct" : "Wrong") . "\n";
echo "Verifying Hash 3: " . (Hash::check('Admin123!', $hash3) ? "Correct" : "Wrong") . "\n"; 