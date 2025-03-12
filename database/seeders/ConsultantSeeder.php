<?php

namespace Database\Seeders;

use App\Models\Consultant;
use App\Models\Specialty;
use Illuminate\Database\Seeder;

class ConsultantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all specialties for random assignment
        $specialties = Specialty::all();
        
        // Malaysian style consultant names with titles
        $consultants = [
            [
                'title' => 'Dr.',
                'name' => 'Ahmad bin Abdullah',
                'email' => 'ahmad.abdullah@example.com',
                'phone' => '+60 12-345 6789',
                'hourly_rate' => 250.00,
                'notes' => 'Experienced in complex cardiology cases',
            ],
            [
                'title' => 'Dr.',
                'name' => 'Nurul Huda binti Ibrahim',
                'email' => 'nurul.ibrahim@example.com',
                'phone' => '+60 13-987 6543',
                'hourly_rate' => 275.00,
                'notes' => 'Specializes in pediatric neurology',
            ],
            [
                'title' => 'Dr.',
                'name' => 'Rajesh Kumar a/l Subramaniam',
                'email' => 'rajesh.kumar@example.com',
                'phone' => '+60 16-789 4561',
                'hourly_rate' => 230.00,
                'notes' => 'Expert in gastroenterology',
            ],
            [
                'title' => 'Dr.',
                'name' => 'Li Wei Hong',
                'email' => 'liwei.hong@example.com',
                'phone' => '+60 17-234 5678',
                'hourly_rate' => 260.00,
                'notes' => 'Specializes in dermatology for all skin types',
            ],
            [
                'title' => 'Dr.',
                'name' => 'Aminah binti Hassan',
                'email' => 'aminah.hassan@example.com',
                'phone' => '+60 18-456 7890',
                'hourly_rate' => 240.00,
                'notes' => 'Expertise in obstetrics and gynecology',
            ],
            [
                'title' => 'Dr.',
                'name' => 'Tan Mei Ling',
                'email' => 'tanmei.ling@example.com',
                'phone' => '+60 19-567 8901',
                'hourly_rate' => 280.00,
                'notes' => 'Specializes in nephrology',
            ],
            [
                'title' => 'Dr.',
                'name' => 'Muhammad Ismail bin Yusof',
                'email' => 'muhammad.ismail@example.com',
                'phone' => '+60 14-678 9012',
                'hourly_rate' => 265.00,
                'notes' => 'Expert in endocrinology',
            ],
            [
                'title' => 'Prof.',
                'name' => 'Wong Siew Mei',
                'email' => 'wong.siewmei@example.com',
                'phone' => '+60 15-789 0123',
                'hourly_rate' => 300.00,
                'notes' => 'Specializes in oncology research and treatment',
            ],
            [
                'title' => 'Dr.',
                'name' => 'Kavitha a/p Ramachandran',
                'email' => 'kavitha.ramachandran@example.com',
                'phone' => '+60 12-890 1234',
                'hourly_rate' => 255.00,
                'notes' => 'Specializes in rheumatology',
            ],
            [
                'title' => 'Dr.',
                'name' => 'Zulkifli bin Omar',
                'email' => 'zulkifli.omar@example.com',
                'phone' => '+60 13-901 2345',
                'hourly_rate' => 245.00,
                'notes' => 'Expert in pulmonology',
            ]
        ];
        
        foreach ($consultants as $consultant) {
            // Add random specialty ID to each consultant
            $specialty = $specialties->random();
            $consultant['specialty_id'] = $specialty->id;
            // Also add the specialty name to match the schema requirement
            $consultant['specialty'] = $specialty->name;
            
            Consultant::create($consultant);
        }
    }
}
