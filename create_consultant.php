<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Consultant;

// First, let's check if there are any consultants
$count = Consultant::count();
echo "Current consultant count: " . $count . "\n";

// Creating a consultant
$consultant = new Consultant();
$consultant->title = 'Dr.';
$consultant->name = 'John Smith';
$consultant->specialty = 'Cardiology';
$consultant->email = 'john.smith@example.com';
$consultant->phone = '1234567890';
$consultant->hourly_rate = 200;
$saved = $consultant->save();

echo "Consultant saved: " . ($saved ? 'Yes' : 'No') . "\n";

// Check if consultant was saved
$newCount = Consultant::count();
echo "New consultant count: " . $newCount . "\n";

// List all consultants
$consultants = Consultant::all();
echo "Consultants in database:\n";
foreach ($consultants as $c) {
    echo "- {$c->title} {$c->name} ({$c->email})\n";
} 