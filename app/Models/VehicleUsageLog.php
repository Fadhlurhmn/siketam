<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VehicleUsageLog extends Model
{
    protected $fillable = [
        'booking_id',
        'driver_id',
        'start_km',
        'end_km',
        'start_time',
        'end_time',
        'notes',
        'status'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'status' => 'string'
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(VehicleBooking::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'driver_id');
    }
}
