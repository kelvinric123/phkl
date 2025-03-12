<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Patient;
use App\Models\Consultant;
use App\Services\InvoiceService;
use Exception;

class InvoiceFactoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    
    protected $invoiceService;
    
    public function setUp(): void
    {
        parent::setUp();
        $this->invoiceService = new InvoiceService();
    }
    
    /**
     * Test invoice creation with factory service.
     */
    public function test_create_invoice_with_factory_service(): void
    {
        // Create a patient and consultant first
        $patient = Patient::factory()->create();
        $consultant = Consultant::factory()->create();
        
        // Create invoice data
        $invoiceNumber = $this->invoiceService->generateInvoiceNumber();
        $invoiceData = [
            'patient_id' => $patient->id,
            'consultant_id' => $consultant->id,
            'invoice_number' => $invoiceNumber,
            'payment_mode' => 'cash',
            'patient_type' => 'outpatient',
            'invoice_date' => now()->format('Y-m-d'),
            'is_foreigner' => false,
            'after_office_hours' => false,
        ];
        
        // Create items
        $items = [
            [
                'consultant_id' => $consultant->id,
                'service_type' => 'service',
                'variation' => 'new',
                'description' => 'Initial consultation',
                'rate' => 200,
                'discount_percent' => 0,
                'discount_amount' => 0,
            ],
            [
                'consultant_id' => $consultant->id,
                'service_type' => 'minor_procedure',
                'description' => 'Dressing',
                'rate' => 300,
                'discount_percent' => 10,
                'discount_amount' => 30,
            ],
        ];
        
        // Create invoice using service
        $invoice = $this->invoiceService->createInvoice($invoiceData, $items);
        
        // Assert invoice created
        $this->assertNotNull($invoice->id);
        $this->assertEquals($invoiceNumber, $invoice->invoice_number);
        $this->assertEquals($patient->id, $invoice->patient_id);
        $this->assertEquals($consultant->id, $invoice->consultant_id);
        
        // Assert items created
        $this->assertEquals(2, $invoice->items->count());
        
        // Assert totals calculated
        $this->assertEquals(500, $invoice->items->sum('rate'));
        $this->assertEquals(30, $invoice->total_discount);
        $this->assertEquals(470, $invoice->subtotal);
        $this->assertEquals(47, $invoice->tax);
        $this->assertEquals(517, $invoice->total);
    }
    
    /**
     * Test creating a simple invoice with the simplified factory method.
     */
    public function test_create_simple_invoice_with_factory(): void
    {
        // Create a patient and consultant
        $patient = Patient::factory()->create();
        $consultant = Consultant::factory()->create();
        
        // Generate invoice number
        $invoiceNumber = $this->invoiceService->generateInvoiceNumber();
        
        // Create simple invoice
        $invoice = $this->invoiceService->createSimpleInvoice(
            $patient->id,
            $consultant->id,
            $invoiceNumber
        );
        
        // Assert invoice created
        $this->assertNotNull($invoice->id);
        $this->assertEquals($invoiceNumber, $invoice->invoice_number);
        $this->assertEquals('draft', $invoice->status);
        $this->assertEquals(0, $invoice->total);
        
        // Add items after creation
        $item = InvoiceItem::create([
            'invoice_id' => $invoice->id,
            'consultant_id' => $consultant->id,
            'service_type' => 'service',
            'variation' => 'new',
            'description' => 'Initial consultation',
            'rate' => 200,
            'discount_percent' => 0,
            'discount_amount' => 0,
        ]);
        
        // Recalculate totals
        $invoice->refresh();
        $invoice->calculateTotals()->save();
        
        // Assert totals updated
        $this->assertEquals(200, $invoice->subtotal);
        $this->assertEquals(20, $invoice->tax);
        $this->assertEquals(220, $invoice->total);
    }
    
    /**
     * Test invoice creation with different configurations.
     */
    public function test_create_invoice_with_different_configurations(): void
    {
        // Create a patient and consultant first
        $patient = Patient::factory()->create();
        $consultant = Consultant::factory()->create();
        
        // 1. Create a foreigner invoice
        $foreignerInvoiceData = [
            'patient_id' => $patient->id,
            'consultant_id' => $consultant->id,
            'invoice_number' => $this->invoiceService->generateInvoiceNumber(),
            'payment_mode' => 'cash',
            'patient_type' => 'outpatient',
            'invoice_date' => now()->format('Y-m-d'),
            'is_foreigner' => true,
            'after_office_hours' => false,
        ];
        
        $items = [
            [
                'consultant_id' => $consultant->id,
                'service_type' => 'service',
                'variation' => 'new',
                'description' => 'Initial consultation',
                'rate' => 200,
                'discount_percent' => 0,
                'discount_amount' => 0,
            ],
        ];
        
        $foreignerInvoice = $this->invoiceService->createInvoice($foreignerInvoiceData, $items);
        
        // Check foreigner surcharge (25% of subtotal)
        $this->assertEquals(200, $foreignerInvoice->subtotal);
        $this->assertEquals(50, $foreignerInvoice->foreigner_surcharge);
        $this->assertEquals(270, $foreignerInvoice->total); // 200 + 20 (tax) + 50 (surcharge)
        
        // 2. Create an after hours invoice
        $afterHoursInvoiceData = [
            'patient_id' => $patient->id,
            'consultant_id' => $consultant->id,
            'invoice_number' => $this->invoiceService->generateInvoiceNumber(),
            'payment_mode' => 'cash',
            'patient_type' => 'outpatient',
            'invoice_date' => now()->format('Y-m-d'),
            'is_foreigner' => false,
            'after_office_hours' => true,
        ];
        
        $afterHoursInvoice = $this->invoiceService->createInvoice($afterHoursInvoiceData, $items);
        
        // Check no foreigner surcharge
        $this->assertEquals(200, $afterHoursInvoice->subtotal);
        $this->assertEquals(0, $afterHoursInvoice->foreigner_surcharge);
        $this->assertEquals(220, $afterHoursInvoice->total); // 200 + 20 (tax)
    }
} 