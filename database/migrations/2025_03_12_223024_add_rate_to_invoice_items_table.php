<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('invoice_items', function (Blueprint $table) {
            // Check if rate column exists
            if (!Schema::hasColumn('invoice_items', 'rate')) {
                // If unit_price exists, rename it to rate
                if (Schema::hasColumn('invoice_items', 'unit_price')) {
                    $table->renameColumn('unit_price', 'rate');
                } else {
                    // Otherwise, create a new rate column
                    $table->decimal('rate', 10, 2)->after('description')->default(0);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoice_items', function (Blueprint $table) {
            if (Schema::hasColumn('invoice_items', 'rate')) {
                $table->dropColumn('rate');
            }
        });
    }
};
