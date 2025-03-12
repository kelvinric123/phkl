<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Consultant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'name',
        'specialty_id',
        'specialty',  // We'll keep this for backward compatibility
        'email',
        'phone',
        'hourly_rate',
        'notes',
    ];

    /**
     * Get the invoices for the consultant.
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Get the full name of the consultant.
     */
    public function getFullNameAttribute(): string
    {
        return $this->title ? "{$this->title} {$this->name}" : $this->name;
    }

    /**
     * Get the invoice items for the consultant.
     */
    public function invoiceItems(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }
    
    /**
     * Get the specialty that the consultant belongs to.
     */
    public function specialty(): BelongsTo
    {
        return $this->belongsTo(Specialty::class);
    }
}
