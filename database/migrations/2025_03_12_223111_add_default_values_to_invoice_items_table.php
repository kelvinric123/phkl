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
            // Add default values to required fields
            if (Schema::hasColumn('invoice_items', 'quantity')) {
                $table->integer('quantity')->default(1)->change();
            }
            
            if (Schema::hasColumn('invoice_items', 'unit_price')) {
                $table->decimal('unit_price', 10, 2)->default(0)->change();
            }
            
            if (Schema::hasColumn('invoice_items', 'total_price')) {
                $table->decimal('total_price', 10, 2)->default(0)->change();
            }
            
            if (Schema::hasColumn('invoice_items', 'service_date')) {
                $table->date('service_date')->nullable()->default(null)->change();
            }
            
            if (Schema::hasColumn('invoice_items', 'description')) {
                $table->string('description')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoice_items', function (Blueprint $table) {
            // Revert changes if needed
        });
    }
};
