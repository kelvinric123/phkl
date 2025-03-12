<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Consultant;
use Carbon\Carbon;

class InvoiceTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * Test invoice creation.
     */
    public function test_create_simple_invoice(): void
    {
        // Create a patient and consultant first
        $patient = Patient::factory()->create();
        $consultant = Consultant::factory()->create();
        
        // Create a simple invoice
        $invoiceData = [
            'patient_id' => $patient->id,
            'consultant_id' => $consultant->id,
            'invoice_number' => 'TEST-' . date('Ymd') . rand(1000, 9999),
            'payment_mode' => 'cash',
            'patient_type' => 'outpatient',
            'invoice_date' => Carbon::now()->format('Y-m-d'),
            'due_date' => Carbon::now()->addDays(30)->format('Y-m-d'),
            'is_foreigner' => false,
            'after_office_hours' => false,
            'status' => 'draft',
            'subtotal' => 0,
            'tax' => 0, 
            'total' => 0,
            'amount' => 0,
            'tax_amount' => 0,
            'total_amount' => 0,
            'foreigner_surcharge' => 0,
            'total_discount' => 0,
        ];
        
        try {
            $invoice = Invoice::create($invoiceData);
            $this->assertNotNull($invoice->id);
            $this->assertEquals($invoiceData['invoice_number'], $invoice->invoice_number);
            echo "✅ Invoice created successfully with ID: " . $invoice->id;
        } catch (\Exception $e) {
            $this->fail("Failed to create invoice: " . $e->getMessage());
        }
    }
}
