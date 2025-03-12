<?php

namespace Database\Seeders;

use App\Models\SurgicalProcedure;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SurgicalProcedureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some surgical procedures
        $surgicalProcedures = [
            [
                'name' => 'Appendectomy',
                'code' => 'SURG001',
                'type' => 'Surgical',
                'description' => 'Surgical removal of the appendix',
                'charge' => 2500.00,
                'is_active' => true,
            ],
            [
                'name' => 'Cholecystectomy',
                'code' => 'SURG002',
                'type' => 'Surgical',
                'description' => 'Surgical removal of the gallbladder',
                'charge' => 3500.00,
                'is_active' => true,
            ],
            [
                'name' => 'Hernia Repair',
                'code' => 'SURG003',
                'type' => 'Surgical',
                'description' => 'Surgical repair of a hernia',
                'charge' => 2000.00,
                'is_active' => true,
            ],
            [
                'name' => 'Skin Biopsy',
                'code' => 'MIN001',
                'type' => 'Minor',
                'description' => 'Removal of a small piece of skin for examination',
                'charge' => 500.00,
                'is_active' => true,
            ],
            [
                'name' => 'Wound Debridement',
                'code' => 'MIN002',
                'type' => 'Minor',
                'description' => 'Removal of dead tissue from a wound',
                'charge' => 350.00,
                'is_active' => true,
            ],
            [
                'name' => 'Incision and Drainage',
                'code' => 'MIN003',
                'type' => 'Minor',
                'description' => 'Drainage of an abscess or cyst',
                'charge' => 450.00,
                'is_active' => true,
            ],
        ];

        foreach ($surgicalProcedures as $procedure) {
            SurgicalProcedure::create($procedure);
        }
    }
}
