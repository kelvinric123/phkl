<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurgicalProcedure extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'code',
        'type',
        'description',
        'charge',
        'anaesthetist_percentage',
        'is_active'
    ];
    
    protected $casts = [
        'charge' => 'decimal:2',
        'anaesthetist_percentage' => 'decimal:2',
        'is_active' => 'boolean'
    ];
}
