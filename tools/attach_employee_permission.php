<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Auth\Permission;

$p = Permission::firstOrCreate(['name' => 'read-sales-invoices'], ['display_name' => 'Read Sales Invoices']);
$role = role_model_class()::where('name','employee')->first();

if (empty($role)) {
    echo "employee role not found\n";
    exit(1);
}

if (!$role->hasPermission('read-sales-invoices')) {
    $role->attachPermission($p);
    echo "attached\n";
} else {
    echo "already attached\n";
}
