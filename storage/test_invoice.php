<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Consultant;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

DB::enableQueryLog();

try {
    // Get existing records
    $patient = Patient::first();
    $consultant = Consultant::first();
    
    if (!$patient) {
        echo "Error: No patients found in the database\n";
        exit;
    }
    
    if (!$consultant) {
        echo "Error: No consultants found in the database\n";
        exit;
    }
    
    echo "Patient ID: " . $patient->id . "\n";
    echo "Consultant ID: " . $consultant->id . "\n";
    
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
        'foreigner_surcharge' => 0,
        'total_discount' => 0,
    ];
    
    echo "Creating invoice with data:\n";
    print_r($invoiceData);
    
    $invoice = Invoice::create($invoiceData);
    
    echo "Successfully created invoice with ID: " . $invoice->id . "\n";
    
    // Print the full invoice data
    echo "Invoice data:\n";
    print_r($invoice->toArray());
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Error code: " . $e->getCode() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
    
    // Print DB query log
    echo "DB Query Log:\n";
    print_r(DB::getQueryLog());
} 