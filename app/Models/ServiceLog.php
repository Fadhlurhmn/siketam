<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceLog extends Model
{
    protected $fillable = [
        'vehicle_id',
        'admin_id',
        'service_type',
        'description',
        'cost',
        'odometer',
        'service_date',
        'next_service_date'
    ];

    protected $casts = [
        'cost' => 'decimal:2',
        'service_date' => 'datetime',
        'next_service_date' => 'datetime'
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
