<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'role',
        'department_id',
        'region_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'role' => 'string'
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function vehicleBookings(): HasMany
    {
        return $this->hasMany(VehicleBooking::class, 'user_id');
    }

    public function supervisedBookings(): HasMany
    {
        return $this->hasMany(VehicleBooking::class, 'supervisor_id');
    }

    public function adminBookings(): HasMany
    {
        return $this->hasMany(VehicleBooking::class, 'admin_id');
    }

    public function driverSchedules(): HasMany
    {
        return $this->hasMany(DriverSchedule::class, 'driver_id');
    }

    public function supervisedSchedules(): HasMany
    {
        return $this->hasMany(DriverSchedule::class, 'supervisor_id');
    }

    public function usageLogs(): HasMany
    {
        return $this->hasMany(VehicleUsageLog::class, 'driver_id');
    }

    public function fuelLogs(): HasMany
    {
        return $this->hasMany(FuelLog::class, 'admin_id');
    }

    public function serviceLogs(): HasMany
    {
        return $this->hasMany(ServiceLog::class, 'admin_id');
    }
}
