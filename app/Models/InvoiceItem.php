<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'invoice_id',
        'consultant_id',
        'service_type',
        'variation',
        'description',
        'rate',
        'discount_percent',
        'discount_amount',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'rate' => 'decimal:2',
        'discount_percent' => 'decimal:2',
        'discount_amount' => 'decimal:2',
    ];

    /**
     * Get the invoice that owns the item.
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Get the consultant that owns the item.
     */
    public function consultant(): BelongsTo
    {
        return $this->belongsTo(Consultant::class);
    }

    /**
     * Calculate the original subtotal for this item (before discount).
     *
     * @return float
     */
    public function getOriginalSubtotalAttribute()
    {
        return $this->rate;
    }
    
    /**
     * Calculate the final subtotal for this item (after discount).
     *
     * @return float
     */
    public function getSubtotalAttribute()
    {
        return $this->original_subtotal - $this->discount_amount;
    }
}
