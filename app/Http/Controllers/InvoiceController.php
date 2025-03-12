<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Consultant;
use App\Models\InvoiceItem;
use App\Services\InvoiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    protected $invoiceService;
    
    /**
     * Create a new controller instance.
     *
     * @param InvoiceService $invoiceService
     * @return void
     */
    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::with(['patient', 'items.consultant'])->latest()->paginate(10);
        return view('invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = Patient::all();
        $consultants = Consultant::all();
        $nextInvoiceNumber = $this->invoiceService->generateInvoiceNumber();
        
        return view('invoices.create', compact('patients', 'consultants', 'nextInvoiceNumber'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'patient_mrn' => 'required|string|max:50',
            'invoice_number' => 'required|string|max:50|unique:invoices',
            'payment_mode' => 'required|in:cash,gl',
            'patient_type' => 'required|in:outpatient,inpatient',
            'invoice_date' => 'required|date',
            'notes' => 'nullable|string',
            'is_foreigner' => 'sometimes|in:0,1',
            'after_office_hours' => 'sometimes|in:0,1',
            'consultant_id' => 'required|exists:consultants,id',
            'anaesthetist_id' => 'nullable|exists:consultants,id',
            'anaesthetist_percentage' => 'nullable|numeric|min:0|max:100',
            'items' => 'required|array|min:1',
            'items.*.service_type' => 'required|in:service,minor_procedure,surgical_procedure',
            'items.*.variation' => 'nullable|required_if:items.*.service_type,service|in:new,follow_up',
            'items.*.description' => 'nullable|string|max:255|required_if:items.*.service_type,minor_procedure,surgical_procedure',
            'items.*.rate' => 'required|numeric|min:0',
            'items.*.discount_percent' => 'nullable|numeric|min:0|max:100',
            'items.*.discount_amount' => 'nullable|numeric|min:0',
        ]);

        try {
            // Create invoice using service
            $invoiceData = [
                'patient_id' => $validated['patient_id'],
                'invoice_number' => $validated['invoice_number'],
                'payment_mode' => $validated['payment_mode'],
                'patient_type' => $validated['patient_type'],
                'invoice_date' => $validated['invoice_date'],
                'notes' => $validated['notes'] ?? null,
                'is_foreigner' => (bool)($request->input('is_foreigner', 0)),
                'after_office_hours' => (bool)($request->input('after_office_hours', 0)),
                'consultant_id' => $validated['consultant_id'],
                'anaesthetist_id' => $validated['anaesthetist_id'],
                'anaesthetist_percentage' => $validated['anaesthetist_percentage'] ?? 40,
                'status' => 'draft',
            ];
            
            // Prepare items
            $items = array_map(function($item) use ($validated) {
                return [
                    'consultant_id' => $validated['consultant_id'],
                    'service_type' => $item['service_type'],
                    'variation' => $item['variation'] ?? null,
                    'description' => $item['description'],
                    'rate' => $item['rate'],
                    'discount_percent' => $item['discount_percent'] ?? 0,
                    'discount_amount' => $item['discount_amount'] ?? 0,
                ];
            }, $validated['items']);
            
            // Create the invoice using the factory pattern
            $invoice = $this->invoiceService->createInvoice($invoiceData, $items);

            return redirect()->route('invoices.index')
                ->with('success', 'Invoice created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error creating invoice: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load(['patient', 'consultant', 'anaesthetist', 'items.consultant']);
        return view('invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        $patients = Patient::all();
        $consultants = Consultant::all();
        
        return view('invoices.edit', compact('invoice', 'patients', 'consultants'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'payment_mode' => 'required|in:cash,gl',
            'patient_type' => 'required|in:outpatient,inpatient',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date',
            'status' => 'required|in:draft,sent,paid,cancelled',
            'notes' => 'nullable|string',
            'is_foreigner' => 'sometimes|in:0,1',
            'after_office_hours' => 'sometimes|in:0,1',
            'consultant_id' => 'required|exists:consultants,id',
            'anaesthetist_id' => 'nullable|exists:consultants,id',
            'anaesthetist_percentage' => 'nullable|numeric|min:0|max:100',
            'items' => 'required|array|min:1',
            'items.*.id' => 'nullable|exists:invoice_items,id',
            'items.*.service_type' => 'required|in:service,minor_procedure,surgical_procedure',
            'items.*.variation' => 'nullable|required_if:items.*.service_type,service|in:new,follow_up',
            'items.*.description' => 'nullable|string|max:255|required_if:items.*.service_type,minor_procedure,surgical_procedure',
            'items.*.rate' => 'required|numeric|min:0',
            'items.*.discount_percent' => 'nullable|numeric|min:0|max:100',
            'items.*.discount_amount' => 'nullable|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();
            
            // Update invoice
            $invoiceData = [
                'patient_id' => $validated['patient_id'],
                'payment_mode' => $validated['payment_mode'],
                'patient_type' => $validated['patient_type'],
                'invoice_date' => $validated['invoice_date'],
                'due_date' => $validated['due_date'],
                'status' => $validated['status'],
                'notes' => $validated['notes'] ?? null,
                'is_foreigner' => (bool)($request->input('is_foreigner', 0)),
                'after_office_hours' => (bool)($request->input('after_office_hours', 0)),
                'consultant_id' => $validated['consultant_id'],
                'anaesthetist_id' => $validated['anaesthetist_id'] ?? null,
                'anaesthetist_percentage' => $validated['anaesthetist_percentage'] ?? 40,
            ];
            
            $invoice->update($invoiceData);
            
            // Get existing item IDs
            $existingItemIds = $invoice->items->pluck('id')->toArray();
            $updatedItemIds = [];
            
            // Update or create items
            foreach ($validated['items'] as $itemData) {
                $itemId = $itemData['id'] ?? null;
                
                $itemToSave = [
                    'consultant_id' => $validated['consultant_id'],
                    'service_type' => $itemData['service_type'],
                    'variation' => $itemData['variation'] ?? null,
                    'description' => $itemData['description'] ?? null,
                    'rate' => $itemData['rate'],
                    'discount_percent' => $itemData['discount_percent'] ?? 0,
                    'discount_amount' => $itemData['discount_amount'] ?? 0,
                ];
                
                if ($itemId) {
                    // Update existing item
                    $item = InvoiceItem::findOrFail($itemId);
                    $item->update($itemToSave);
                    $updatedItemIds[] = $itemId;
                } else {
                    // Create new item
                    $item = $invoice->items()->create($itemToSave);
                    $updatedItemIds[] = $item->id;
                }
            }
            
            // Delete items that were removed
            $itemsToDelete = array_diff($existingItemIds, $updatedItemIds);
            if (!empty($itemsToDelete)) {
                InvoiceItem::whereIn('id', $itemsToDelete)->delete();
            }
            
            // Calculate totals
            $invoice = $invoice->fresh(['items']);
            $invoice->total_discount = $invoice->items->sum('discount_amount');
            $invoice->calculateTotals();
            $invoice->save();
            
            DB::commit();
            
            return redirect()->route('invoices.show', $invoice)
                ->with('success', 'Invoice updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error updating invoice: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        
        return redirect()->route('invoices.index')
            ->with('success', 'Invoice deleted successfully.');
    }
}
