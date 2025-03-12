<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'patient_id',
        'invoice_number',
        'payment_mode',
        'patient_type',
        'invoice_date',
        'due_date',
        'status',
        'notes',
        'subtotal',
        'tax',
        'total',
        'is_foreigner',
        'foreigner_surcharge',
        'after_office_hours',
        'consultant_id',
        'anaesthetist_id',
        'anaesthetist_percentage',
        'total_discount',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
        'foreigner_surcharge' => 'decimal:2',
        'total_discount' => 'decimal:2',
        'anaesthetist_percentage' => 'decimal:2',
        'is_foreigner' => 'boolean',
        'after_office_hours' => 'boolean',
    ];

    /**
     * Get the patient that owns the invoice.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the consultant that owns the invoice.
     */
    public function consultant(): BelongsTo
    {
        return $this->belongsTo(Consultant::class);
    }

    /**
     * Get the anaesthetist for the invoice.
     */
    public function anaesthetist(): BelongsTo
    {
        return $this->belongsTo(Consultant::class, 'anaesthetist_id');
    }

    /**
     * Get the items for the invoice.
     */
    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }

    /**
     * Calculate the invoice totals.
     *
     * @return void
     */
    public function calculateTotals()
    {
        // Calculate raw subtotal before discounts
        $rawSubtotal = $this->items->sum(function ($item) {
            return $item->rate;
        });
        
        // Subtract discounts if any
        $this->subtotal = $rawSubtotal - $this->total_discount;
        
        // Calculate anaesthetist fee if applicable
        $anaesthetistFee = $this->getAnaesthetistFee();
        // Store the anaesthetist fee for display purposes (even if there's no anaesthetist_fee column)
        $this->anaesthetist_fee = $anaesthetistFee;
        
        $this->tax = $this->subtotal * 0.10; // Applying 10% tax after discounts
        
        // Add foreigner surcharge if applicable
        $this->foreigner_surcharge = 0;
        if ($this->is_foreigner) {
            $this->foreigner_surcharge = $this->subtotal * 0.25; // 25% surcharge for foreigners
        }
        
        // The total should be subtotal + tax + foreigner surcharge
        // Anaesthetist fee is already included in the subtotal and shouldn't be added separately
        $this->total = $this->subtotal + $this->tax + $this->foreigner_surcharge;
        
        return $this;
    }
    
    /**
     * Calculate the anaesthetist fee if applicable.
     *
     * @return float
     */
    public function getAnaesthetistFee()
    {
        // Only calculate anaesthetist fee if an anaesthetist is assigned
        if (!$this->anaesthetist_id) {
            return 0;
        }
        
        // Calculate fee based on surgical procedures
        $surgicalItems = $this->items->where('service_type', 'surgical_procedure');
        
        if ($surgicalItems->isEmpty()) {
            return 0;
        }
        
        // Use the anaesthetist_percentage from the invoice if available, otherwise default to 40%
        $defaultPercentage = $this->anaesthetist_percentage ?? 40;
        
        // Calculate anaesthetist fee based on each procedure's specific percentage
        $anaesthetistFee = 0;
        
        foreach ($surgicalItems as $item) {
            $itemTotal = $item->rate - $item->discount_amount;
            
            // Always use the invoice-level anaesthetist percentage rather than procedure-specific
            $anaesthetistFee += $itemTotal * ($defaultPercentage / 100);
        }
        
        return $anaesthetistFee;
    }
}
