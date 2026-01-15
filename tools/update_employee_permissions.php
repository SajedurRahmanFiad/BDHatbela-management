<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Auth\Permission;

$role = role_model_class()::where('name','employee')->first();
if (empty($role)) {
    echo "employee role not found\n";
    exit(1);
}

// Ensure create-sales-invoices exists and is attached
$createSales = Permission::firstOrCreate(['name' => 'create-sales-invoices'], ['display_name' => 'Create Sales Invoices']);
if (!$role->hasPermission('create-sales-invoices')) {
    $role->attachPermission($createSales);
    echo "attached create-sales-invoices\n";
} else {
    echo "already has create-sales-invoices\n";
}

// Remove create-purchases-vendors if present
$createPurchasesVendors = Permission::where('name','create-purchases-vendors')->first();
if ($createPurchasesVendors && $role->hasPermission('create-purchases-vendors')) {
    $role->detachPermission($createPurchasesVendors);
    echo "detached create-purchases-vendors\n";
} else {
    echo "no create-purchases-vendors to detach\n";
}

// Remove read-purchases-vendors (optionally)
$readPurchasesVendors = Permission::where('name','read-purchases-vendors')->first();
if ($readPurchasesVendors && $role->hasPermission('read-purchases-vendors')) {
    $role->detachPermission($readPurchasesVendors);
    echo "detached read-purchases-vendors\n";
} else {
    echo "no read-purchases-vendors to detach\n";
}
