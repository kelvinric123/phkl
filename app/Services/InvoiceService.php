<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Support\Facades\DB;
use DateTime;
use Exception;

class InvoiceService
{
    /**
     * Create a new invoice with the given data using a factory pattern
     *
     * @param array $invoiceData The validated invoice data
     * @param array $items The invoice items
     * @return Invoice The created invoice
     * @throws Exception
     */
    public function createInvoice(array $invoiceData, array $items): Invoice
    {
        try {
            DB::beginTransaction();

            // Calculate due date if not provided (30 days after invoice date)
            if (!isset($invoiceData['due_date'])) {
                $invoiceDate = new DateTime($invoiceData['invoice_date']);
                $dueDate = clone $invoiceDate;
                $dueDate->modify('+30 days');
                $invoiceData['due_date'] = $dueDate->format('Y-m-d');
            }

            // Set default values if not provided
            $invoiceData['status'] = $invoiceData['status'] ?? 'draft';
            $invoiceData['subtotal'] = $invoiceData['subtotal'] ?? 0;
            $invoiceData['tax'] = $invoiceData['tax'] ?? 0;
            $invoiceData['total'] = $invoiceData['total'] ?? 0;
            $invoiceData['foreigner_surcharge'] = $invoiceData['foreigner_surcharge'] ?? 0;
            $invoiceData['total_discount'] = $invoiceData['total_discount'] ?? 0;
            
            // Convert boolean fields
            $invoiceData['is_foreigner'] = filter_var($invoiceData['is_foreigner'] ?? false, FILTER_VALIDATE_BOOLEAN);
            $invoiceData['after_office_hours'] = filter_var($invoiceData['after_office_hours'] ?? false, FILTER_VALIDATE_BOOLEAN);

            // Create the invoice
            $invoice = Invoice::create($invoiceData);

            // Create the invoice items
            $totalDiscount = 0;
            foreach ($items as $item) {
                // Calculate discount amount if percentage is provided
                if (isset($item['discount_percent']) && !isset($item['discount_amount'])) {
                    $item['discount_amount'] = ($item['rate'] * $item['discount_percent']) / 100;
                }
                
                $discountAmount = isset($item['discount_amount']) ? $item['discount_amount'] : 0;
                $totalDiscount += $discountAmount;
                
                // Add invoice_id to item
                $item['invoice_id'] = $invoice->id;
                
                InvoiceItem::create($item);
            }
            
            // Set the total discount
            $invoice->total_discount = $totalDiscount;

            // Calculate totals
            $invoice->calculateTotals()->save();

            DB::commit();

            return $invoice;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    
    /**
     * Create a simple invoice with minimal data
     *
     * @param int $patientId The patient ID
     * @param int $consultantId The consultant ID
     * @param string $invoiceNumber The invoice number
     * @param array $items Optional items to add to the invoice
     * @return Invoice The created invoice
     * @throws Exception
     */
    public function createSimpleInvoice(int $patientId, int $consultantId, string $invoiceNumber, array $items = []): Invoice
    {
        $invoiceData = [
            'patient_id' => $patientId,
            'consultant_id' => $consultantId,
            'invoice_number' => $invoiceNumber,
            'payment_mode' => 'cash',
            'patient_type' => 'outpatient',
            'invoice_date' => date('Y-m-d'),
            'is_foreigner' => false,
            'after_office_hours' => false,
        ];
        
        return $this->createInvoice($invoiceData, $items);
    }
    
    /**
     * Generate a unique invoice number
     *
     * @return string The generated invoice number
     */
    public function generateInvoiceNumber(): string
    {
        return 'PHKL250P' . date('ymd') . sprintf('%04d', Invoice::count() + 1);
    }
} 