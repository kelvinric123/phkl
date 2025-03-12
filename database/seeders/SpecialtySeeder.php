<?php

namespace Database\Seeders;

use App\Models\Specialty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecialtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specialties = [
            [
                'name' => 'Cardiology',
                'description' => 'Deals with disorders of the heart and blood vessels.'
            ],
            [
                'name' => 'Dermatology',
                'description' => 'Focuses on the diagnosis and treatment of skin disorders.'
            ],
            [
                'name' => 'Endocrinology',
                'description' => 'Specializes in hormone-related diseases.'
            ],
            [
                'name' => 'Gastroenterology',
                'description' => 'Focuses on the digestive system and its disorders.'
            ],
            [
                'name' => 'Hematology',
                'description' => 'Deals with blood disorders and diseases.'
            ],
            [
                'name' => 'Infectious Disease',
                'description' => 'Focuses on diseases caused by infectious agents.'
            ],
            [
                'name' => 'Nephrology',
                'description' => 'Deals with kidney function and diseases.'
            ],
            [
                'name' => 'Neurology',
                'description' => 'Focuses on disorders of the nervous system.'
            ],
            [
                'name' => 'Obstetrics and Gynecology',
                'description' => 'Focuses on female reproductive health.'
            ],
            [
                'name' => 'Oncology',
                'description' => 'Deals with the prevention, diagnosis, and treatment of cancer.'
            ],
            [
                'name' => 'Ophthalmology',
                'description' => 'Focuses on eye and vision care.'
            ],
            [
                'name' => 'Orthopedics',
                'description' => 'Focuses on the musculoskeletal system.'
            ],
            [
                'name' => 'Otolaryngology',
                'description' => 'Deals with ear, nose, and throat disorders.'
            ],
            [
                'name' => 'Pediatrics',
                'description' => 'Focuses on the health of infants, children, and adolescents.'
            ],
            [
                'name' => 'Psychiatry',
                'description' => 'Focuses on the diagnosis, treatment, and prevention of mental illness.'
            ],
            [
                'name' => 'Pulmonology',
                'description' => 'Deals with diseases of the respiratory system.'
            ],
            [
                'name' => 'Radiology',
                'description' => 'Uses imaging technologies for diagnosis and treatment.'
            ],
            [
                'name' => 'Rheumatology',
                'description' => 'Focuses on autoimmune diseases and joint disorders.'
            ],
            [
                'name' => 'Urology',
                'description' => 'Focuses on the urinary tract and male reproductive system.'
            ],
        ];

        foreach ($specialties as $specialty) {
            Specialty::create($specialty);
        }
    }
}
