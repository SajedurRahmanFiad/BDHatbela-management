<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$rows = DB::table('reports')->where('name', 'like', '%tmp%')->orWhere('created_from', 'like', '%tmp%')->get();

if ($rows->isEmpty()) {
    echo "No matching reports found\n";
    exit;
}

foreach ($rows as $r) {
    echo "{$r->id} | {$r->name} | {$r->class} | created_from={$r->created_from}\n";
}
