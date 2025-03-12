<?php

namespace Database\Seeders;

use App\Models\SurgicalProcedure;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateAnaesthetistPercentageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update all surgical procedures to have 40% anaesthetist fee
        SurgicalProcedure::where('type', 'Surgical')
            ->update(['anaesthetist_percentage' => 40.00]);
            
        $this->command->info('Updated anaesthetist percentage for all Surgical procedures to 40%');
    }
}
