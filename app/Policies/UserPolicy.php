<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->role === 'supervisor_admin' || $user->role === 'supervisor_driver';
    }

    public function view(User $user, User $target): bool
    {
        // Supervisor can only view users in their region
        if ($user->role === 'supervisor_driver') {
            return $user->region_id === $target->region_id;
        }

        return $user->role === 'supervisor_admin';
    }

    public function create(User $user): bool
    {
        return $user->role === 'supervisor_admin';
    }

    public function update(User $user, User $target): bool
    {
        // Can't modify users with higher privileges
        if ($target->role === 'supervisor_admin') {
            return false;
        }

        if ($user->role === 'supervisor_driver') {
            return $user->region_id === $target->region_id &&
                $target->role === 'driver';
        }

        return $user->role === 'supervisor_admin';
    }

    public function delete(User $user, User $target): bool
    {
        return $user->role === 'supervisor_admin' &&
            $target->role !== 'supervisor_admin';
    }
}
