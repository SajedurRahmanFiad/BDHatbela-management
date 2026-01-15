<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$rows = DB::table('reports')->where('name', 'like', 'Tmp %')->get();

if ($rows->isEmpty()) {
    echo "No matching reports found\n";
    exit;
}

$timestamp = date('Ymd_His');
$backupFile = __DIR__ . "/tmp_reports_backup_{$timestamp}.json";
file_put_contents($backupFile, json_encode($rows, JSON_PRETTY_PRINT));

echo "Backed up " . $rows->count() . " rows to {$backupFile}\n";

echo "Will delete the following IDs: ";
$ids = $rows->pluck('id')->toArray();
echo implode(', ', $ids) . "\n";

$deleted = DB::table('reports')->whereIn('id', $ids)->delete();

echo "Deleted {$deleted} rows.\n";

// Show remaining matches
$remaining = DB::table('reports')->where('name', 'like', 'Tmp %')->get();
if ($remaining->isEmpty()) {
    echo "No remaining 'Tmp' reports found.\n";
} else {
    echo "Remaining 'Tmp' reports:\n";
    foreach ($remaining as $r) {
        echo "{$r->id} | {$r->name} | {$r->class} | created_from={$r->created_from}\n";
    }
}
