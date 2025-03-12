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
        Schema::table('invoices', function (Blueprint $table) {
            // Check if amount column exists and rename it to subtotal if it does
            if (Schema::hasColumn('invoices', 'amount') && !Schema::hasColumn('invoices', 'subtotal')) {
                $table->renameColumn('amount', 'subtotal');
            } elseif (!Schema::hasColumn('invoices', 'subtotal')) {
                $table->decimal('subtotal', 10, 2)->default(0);
            }
            
            // Check if tax_amount column exists and rename it to tax if it does
            if (Schema::hasColumn('invoices', 'tax_amount') && !Schema::hasColumn('invoices', 'tax')) {
                $table->renameColumn('tax_amount', 'tax');
            } elseif (!Schema::hasColumn('invoices', 'tax')) {
                $table->decimal('tax', 10, 2)->default(0);
            }
            
            // Check if total_amount column exists and rename it to total if it does
            if (Schema::hasColumn('invoices', 'total_amount') && !Schema::hasColumn('invoices', 'total')) {
                $table->renameColumn('total_amount', 'total');
            } elseif (!Schema::hasColumn('invoices', 'total')) {
                $table->decimal('total', 10, 2)->default(0);
            }
            
            // Add other possible missing fields
            if (!Schema::hasColumn('invoices', 'total_discount')) {
                $table->decimal('total_discount', 10, 2)->default(0);
            }
            
            if (!Schema::hasColumn('invoices', 'foreigner_surcharge')) {
                $table->decimal('foreigner_surcharge', 10, 2)->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Only drop columns that were added, not renamed
            if (Schema::hasColumn('invoices', 'subtotal') && !Schema::hasColumn('invoices', 'amount')) {
                $table->renameColumn('subtotal', 'amount');
            }
            
            if (Schema::hasColumn('invoices', 'tax') && !Schema::hasColumn('invoices', 'tax_amount')) {
                $table->renameColumn('tax', 'tax_amount');
            }
            
            if (Schema::hasColumn('invoices', 'total') && !Schema::hasColumn('invoices', 'total_amount')) {
                $table->renameColumn('total', 'total_amount');
            }
            
            // Drop other columns that may have been added
            $columns = ['total_discount', 'foreigner_surcharge'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('invoices', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
