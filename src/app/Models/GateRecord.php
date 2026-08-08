<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model representing individual Gate Operations transactional records.
 */
class GateRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'driver_id',
        'status',
        'date_time_in',
        'date_time_out',
        'gated_in_by_user_id',
        'gated_out_by_user_id',
    ];

    /**
     * Relationship to the registered Vehicle.
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Relationship to the Driver profile.
     */
    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    /**
     * Relationship to the user/operator who processed the Gate In.
     */
    public function gatedInUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'gated_in_by_user_id');
    }

    /**
     * Relationship to the user/operator who processed the Gate Out.
     */
    public function gatedOutUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'gated_out_by_user_id');
    }
}