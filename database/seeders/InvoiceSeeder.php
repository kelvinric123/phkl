<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Patient;
use App\Models\Consultant;
use App\Services\InvoiceService;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get an instance of the InvoiceService
        $invoiceService = app(InvoiceService::class);
        
        // Get existing patients and consultants
        $patients = Patient::all();
        $consultants = Consultant::all();
        
        // If we don't have patients or consultants, create some
        if ($patients->isEmpty()) {
            $patients = Patient::factory()->count(5)->create();
        }
        
        if ($consultants->isEmpty()) {
            $consultants = Consultant::factory()->count(3)->create();
        }
        
        // Create 10 sample invoices
        for ($i = 0; $i < 10; $i++) {
            $patient = $patients->random();
            $consultant = $consultants->random();
            
            // Invoice data
            $invoiceData = [
                'patient_id' => $patient->id,
                'consultant_id' => $consultant->id,
                'invoice_number' => $invoiceService->generateInvoiceNumber(),
                'payment_mode' => rand(0, 1) ? 'cash' : 'gl',
                'patient_type' => rand(0, 1) ? 'outpatient' : 'inpatient',
                'invoice_date' => now()->subDays(rand(0, 30))->format('Y-m-d'),
                'is_foreigner' => rand(0, 4) === 0, // 20% chance of being foreigner
                'after_office_hours' => rand(0, 3) === 0, // 25% chance of being after hours
                'status' => ['draft', 'sent', 'paid', 'cancelled'][rand(0, 3)],
                'notes' => rand(0, 1) ? 'Sample invoice notes generated for testing.' : null,
            ];
            
            // Create 1-3 items per invoice
            $items = [];
            for ($j = 0; $j < rand(1, 3); $j++) {
                $serviceType = ['service', 'minor_procedure', 'surgical_procedure'][rand(0, 2)];
                $rate = 0;
                $description = '';
                $variation = null;
                
                if ($serviceType === 'service') {
                    $variation = rand(0, 1) ? 'new' : 'follow_up';
                    $rate = $variation === 'new' ? 200 : 100;
                    $description = $variation === 'new' ? 'Initial consultation' : 'Follow-up consultation';
                } elseif ($serviceType === 'minor_procedure') {
                    $procedures = ['Dressing', 'Injection', 'Minor wound treatment', 'Suture removal'];
                    $description = $procedures[rand(0, count($procedures) - 1)];
                    $rate = rand(300, 800);
                } else {
                    $procedures = ['Appendectomy', 'Hernia repair', 'Cholecystectomy'];
                    $description = $procedures[rand(0, count($procedures) - 1)];
                    $rate = rand(1000, 5000);
                }
                
                // Add discount in 30% of cases
                $discountPercent = rand(0, 9) < 3 ? rand(5, 20) : 0;
                $discountAmount = ($rate * $discountPercent) / 100;
                
                $items[] = [
                    'consultant_id' => $consultant->id,
                    'service_type' => $serviceType,
                    'variation' => $variation,
                    'description' => $description,
                    'rate' => $rate,
                    'discount_percent' => $discountPercent,
                    'discount_amount' => $discountAmount,
                ];
            }
            
            // Create the invoice with its items
            $invoice = $invoiceService->createInvoice($invoiceData, $items);
            
            $this->command->info("Created invoice #{$invoice->invoice_number} with " . count($items) . " items.");
        }
    }
} 