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
        Schema::table('surgical_procedures', function (Blueprint $table) {
            $table->decimal('anaesthetist_percentage', 5, 2)->default(40.00)->after('charge');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surgical_procedures', function (Blueprint $table) {
            $table->dropColumn('anaesthetist_percentage');
        });
    }
};
