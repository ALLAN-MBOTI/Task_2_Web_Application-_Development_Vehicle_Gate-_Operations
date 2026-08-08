<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model class representing Driver entity.
 * Stores master records of driver credentials and contact details.
 */
class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'driver_id',
        'phone_number',
    ];

    /**
     * Get all gate operations associated with this driver.
     */
    public function gateRecords(): HasMany
    {
        return $this->hasMany(GateRecord::class);
    }
}