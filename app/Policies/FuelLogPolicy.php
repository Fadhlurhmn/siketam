<?php

namespace App\Policies;

use App\Models\FuelLog;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FuelLogPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === 'vehicle_admin';
    }

    public function view(User $user, FuelLog $log): bool
    {
        return $user->role === 'vehicle_admin' && $user->region_id === $log->vehicle->region_id;
    }

    public function create(User $user): bool
    {
        return $user->role === 'vehicle_admin';
    }

    public function update(User $user, FuelLog $log): bool
    {
        return $user->role === 'vehicle_admin' && $user->region_id === $log->vehicle->region_id;
    }

    public function delete(User $user, FuelLog $log): bool
    {
        return $user->role === 'vehicle_admin';
    }
}
