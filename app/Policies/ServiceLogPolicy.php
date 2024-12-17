<?php

namespace App\Policies;

use App\Models\ServiceLog;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ServiceLogPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === 'vehicle_admin';
    }

    public function view(User $user, ServiceLog $log): bool
    {
        return $user->role === 'vehicle_admin' && $user->region_id === $log->vehicle->region_id;
    }

    public function create(User $user): bool
    {
        return $user->role === 'vehicle_admin';
    }

    public function update(User $user, ServiceLog $log): bool
    {
        return $user->role === 'vehicle_admin' && $user->region_id === $log->vehicle->region_id;
    }

    public function delete(User $user, ServiceLog $log): bool
    {
        return $user->role === 'vehicle_admin';
    }
}
