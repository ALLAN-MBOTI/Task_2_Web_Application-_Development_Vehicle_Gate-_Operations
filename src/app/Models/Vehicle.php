<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model class representing Vehicle entity.
 * Stores license plate details and vehicle classifications.
 */
class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_number',
        'vehicle_type',
    ];

    /**
     * Get all gate entry/exit transactions for this vehicle.
     */
    public function gateRecords(): HasMany
    {
        return $this->hasMany(GateRecord::class);
    }
}