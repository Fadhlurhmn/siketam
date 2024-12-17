<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\VehicleBooking;
use App\Models\DriverSchedule;
use App\Models\FuelLog;
use App\Models\ServiceLog;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        VehicleBooking::class => \App\Policies\VehicleBookingPolicy::class,
        DriverSchedule::class => \App\Policies\DriverSchedulePolicy::class,
        FuelLog::class => \App\Policies\FuelLogPolicy::class,
        ServiceLog::class => \App\Policies\ServiceLogPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
