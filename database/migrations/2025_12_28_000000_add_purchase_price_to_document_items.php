<?php

use Doctrine\DBAL\Types\FloatType;
use Doctrine\DBAL\Types\Type;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Type::hasType('double')) {
            Type::addType('double', FloatType::class);
        }

        if (! Schema::hasColumn('document_items', 'purchase_price')) {
            Schema::table('document_items', function (Blueprint $table) {
                $table->double('purchase_price', 12, 2)->default(0)->after('price');
            });
        }

        // Backfill existing document items with the current item purchase_price (best-effort snapshot)
        if (Schema::hasTable('document_items') && Schema::hasTable('items')) {
            try {
                DB::statement('UPDATE document_items di JOIN items i ON di.item_id = i.id SET di.purchase_price = i.purchase_price WHERE i.purchase_price IS NOT NULL');
            } catch (\Exception $e) {
                // best-effort backfill failed (e.g., missing table/permissions) — skip silently
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('document_items', 'purchase_price')) {
            Schema::table('document_items', function (Blueprint $table) {
                $table->dropColumn('purchase_price');
            });
        }
    }
};
