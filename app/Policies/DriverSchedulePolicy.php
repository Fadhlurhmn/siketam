<?php

namespace App\Policies;

use App\Models\User;
use App\Models\DriverSchedule;

class DriverSchedulePolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['supervisor_driver', 'vehicle_admin']);
    }

    public function view(User $user, DriverSchedule $schedule): bool
    {
        return $user->id === $schedule->driver_id ||
            $user->id === $schedule->supervisor_id ||
            $user->region_id === $schedule->vehicle->region_id;
    }

    public function create(User $user): bool
    {
        return $user->role === 'vehicle_admin';
    }

    public function update(User $user, DriverSchedule $schedule): bool
    {
        return $user->role === 'vehicle_admin' || $user->id === $schedule->supervisor_id;
    }

    public function delete(User $user, DriverSchedule $schedule): bool
    {
        return $user->role === 'vehicle_admin';
    }
}
