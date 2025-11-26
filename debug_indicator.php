<?php

use App\Models\Indicator;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$indicator = Indicator::with('changes')->first();

if ($indicator) {
    echo "Indicator ID: " . $indicator->id . "\n";
    echo "Original Name: " . $indicator->name . "\n";
    echo "Changes Count: " . $indicator->changes->count() . "\n";
    
    foreach ($indicator->changes as $change) {
        echo "Change ID: " . $change->id . "\n";
        echo "Revision Name: " . $change->revision_name . "\n";
        echo "Status: " . ($change->status ? 'true' : 'false') . "\n";
        echo "Revision Date: " . $change->revision_date->format('Y-m-d') . "\n";
    }

    $latestChange = $indicator->changes()->where('status', true)->latest('revision_date')->first();
    echo "Latest Active Change: " . ($latestChange ? $latestChange->revision_name : 'None') . "\n";
} else {
    echo "No indicators found.\n";
}
