<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add fields to invoices table if they don't exist
        if (Schema::hasTable('invoices')) {
            if (!Schema::hasColumn('invoices', 'total_discount')) {
                Schema::table('invoices', function (Blueprint $table) {
                    $table->decimal('total_discount', 10, 2)->default(0);
                });
            }
            
            if (!Schema::hasColumn('invoices', 'consultant_id')) {
                Schema::table('invoices', function (Blueprint $table) {
                    $table->foreignId('consultant_id')->nullable()->constrained('consultants');
                });
            }
        }
        
        // Add discount fields to invoice_items table if it exists
        if (Schema::hasTable('invoice_items')) {
            if (!Schema::hasColumn('invoice_items', 'discount_percent')) {
                Schema::table('invoice_items', function (Blueprint $table) {
                    $table->decimal('discount_percent', 5, 2)->default(0);
                });
            }
            
            if (!Schema::hasColumn('invoice_items', 'discount_amount')) {
                Schema::table('invoice_items', function (Blueprint $table) {
                    $table->decimal('discount_amount', 10, 2)->default(0);
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove fields from invoices table if they exist
        if (Schema::hasTable('invoices')) {
            if (Schema::hasColumn('invoices', 'consultant_id')) {
                Schema::table('invoices', function (Blueprint $table) {
                    $table->dropForeign(['consultant_id']);
                    $table->dropColumn('consultant_id');
                });
            }
            
            if (Schema::hasColumn('invoices', 'total_discount')) {
                Schema::table('invoices', function (Blueprint $table) {
                    $table->dropColumn('total_discount');
                });
            }
        }
        
        // Remove fields from invoice_items table if they exist
        if (Schema::hasTable('invoice_items')) {
            Schema::table('invoice_items', function (Blueprint $table) {
                $columns = ['discount_percent', 'discount_amount'];
                $existingColumns = [];
                
                foreach ($columns as $column) {
                    if (Schema::hasColumn('invoice_items', $column)) {
                        $existingColumns[] = $column;
                    }
                }
                
                if (!empty($existingColumns)) {
                    $table->dropColumn($existingColumns);
                }
            });
        }
    }
};
