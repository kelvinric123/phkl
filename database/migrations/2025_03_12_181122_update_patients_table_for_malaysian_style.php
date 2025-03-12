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
        Schema::table('patients', function (Blueprint $table) {
            // Add the new 'name' field
            $table->string('name')->nullable();
            
            // Copy data from first_name and last_name to name if needed
            // This will happen through seeding since we're going to create new data
        });
        
        // If the migration is run on an existing table with data, 
        // we might need to remove old columns. In our case, we're assuming 
        // we'll reseed the data, so we'll drop the old columns.
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            // Add back the original columns
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            
            // Drop the new column
            $table->dropColumn('name');
        });
    }
};
