<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Malaysian style patient names
        $patients = [
            [
                'name' => 'Siti Aishah binti Mohd Razali',
                'date_of_birth' => '1985-07-15',
                'gender' => 'Female',
                'email' => 'siti.aishah@example.com',
                'phone' => '+60 12-345 7891',
                'address' => '123 Jalan Bunga Raya',
                'city' => 'Kuala Lumpur',
                'state' => 'Wilayah Persekutuan',
                'zip_code' => '50300',
                'medical_record_number' => 'MRN-001',
                'medical_history' => 'Hypertension, controlled with medication',
            ],
            [
                'name' => 'Muhammad Hafiz bin Abdul Rahman',
                'date_of_birth' => '1978-03-22',
                'gender' => 'Male',
                'email' => 'hafiz.rahman@example.com',
                'phone' => '+60 13-456 7892',
                'address' => '45 Jalan Merdeka',
                'city' => 'Petaling Jaya',
                'state' => 'Selangor',
                'zip_code' => '47810',
                'medical_record_number' => 'MRN-002',
                'medical_history' => 'No significant medical history',
            ],
            [
                'name' => 'Lee Mei Hua',
                'date_of_birth' => '1990-11-08',
                'gender' => 'Female',
                'email' => 'mei.hua@example.com',
                'phone' => '+60 14-567 8923',
                'address' => '78 Jalan Masjid India',
                'city' => 'Kuala Lumpur',
                'state' => 'Wilayah Persekutuan',
                'zip_code' => '50100',
                'medical_record_number' => 'MRN-003',
                'medical_history' => 'Asthma, uses inhaler when needed',
            ],
            [
                'name' => 'Maniam a/l Krishnan',
                'date_of_birth' => '1965-09-30',
                'gender' => 'Male',
                'email' => 'maniam.k@example.com',
                'phone' => '+60 16-678 9234',
                'address' => '122 Jalan Ampang',
                'city' => 'Kuala Lumpur',
                'state' => 'Wilayah Persekutuan',
                'zip_code' => '50450',
                'medical_record_number' => 'MRN-004',
                'medical_history' => 'Type 2 diabetes, diet controlled',
            ],
            [
                'name' => 'Nor Fatimah binti Ismail',
                'date_of_birth' => '1992-05-12',
                'gender' => 'Female',
                'email' => 'nor.fatimah@example.com',
                'phone' => '+60 17-789 2345',
                'address' => '33 Jalan Sultan Ismail',
                'city' => 'Kuala Lumpur',
                'state' => 'Wilayah Persekutuan',
                'zip_code' => '50250',
                'medical_record_number' => 'MRN-005',
                'medical_history' => 'Allergic to penicillin',
            ],
            [
                'name' => 'Tan Wei Jian',
                'date_of_birth' => '1982-07-18',
                'gender' => 'Male',
                'email' => 'wei.jian@example.com',
                'phone' => '+60 18-890 3456',
                'address' => '56 Jalan Imbi',
                'city' => 'Kuala Lumpur',
                'state' => 'Wilayah Persekutuan',
                'zip_code' => '55100',
                'medical_record_number' => 'MRN-006',
                'medical_history' => 'Underwent appendectomy in 2015',
            ],
            [
                'name' => 'Devi a/p Subramaniam',
                'date_of_birth' => '1975-12-03',
                'gender' => 'Female',
                'email' => 'devi.s@example.com',
                'phone' => '+60 19-901 4567',
                'address' => '89 Jalan Brickfields',
                'city' => 'Kuala Lumpur',
                'state' => 'Wilayah Persekutuan',
                'zip_code' => '50470',
                'medical_record_number' => 'MRN-007',
                'medical_history' => 'Hypothyroidism, on medication',
            ],
            [
                'name' => 'Ali bin Hassan',
                'date_of_birth' => '1970-02-25',
                'gender' => 'Male',
                'email' => 'ali.hassan@example.com',
                'phone' => '+60 12-012 5678',
                'address' => '11 Jalan Pudu',
                'city' => 'Kuala Lumpur',
                'state' => 'Wilayah Persekutuan',
                'zip_code' => '55200',
                'medical_record_number' => 'MRN-008',
                'medical_history' => 'Hypertension and high cholesterol',
            ],
            [
                'name' => 'Wong Li Fen',
                'date_of_birth' => '1988-08-16',
                'gender' => 'Female',
                'email' => 'li.fen@example.com',
                'phone' => '+60 13-123 6789',
                'address' => '102 Jalan Bukit Bintang',
                'city' => 'Kuala Lumpur',
                'state' => 'Wilayah Persekutuan',
                'zip_code' => '55100',
                'medical_record_number' => 'MRN-009',
                'medical_history' => 'No significant medical history',
            ],
            [
                'name' => 'Ibrahim bin Abdullah',
                'date_of_birth' => '1960-04-10',
                'gender' => 'Male',
                'email' => 'ibrahim.abdullah@example.com',
                'phone' => '+60 14-234 7890',
                'address' => '27 Jalan Tun Razak',
                'city' => 'Kuala Lumpur',
                'state' => 'Wilayah Persekutuan',
                'zip_code' => '50400',
                'medical_record_number' => 'MRN-010',
                'medical_history' => 'Coronary artery disease, post bypass surgery',
            ],
        ];
        
        foreach ($patients as $patient) {
            Patient::create($patient);
        }
    }
}
