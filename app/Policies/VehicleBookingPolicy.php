<?php

namespace App\Policies;

use App\Models\User;
use App\Models\VehicleBooking;

class VehicleBookingPolicy
{
    /**
     * Determine whether the user can view all bookings.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['vehicle_admin', 'supervisor_driver', 'supervisor_admin']);
    }

    /**
     * Determine whether the user can view a specific booking.
     */
    public function view(User $user, VehicleBooking $booking): bool
    {
        return $user->role === 'vehicle_admin' ||
            $user->id === $booking->user_id ||
            $user->id === $booking->supervisor_id ||
            $user->region_id === $booking->vehicle->region_id;
    }

    /**
     * Determine whether the user can create a new booking.
     */
    public function create(User $user): bool
    {
        return $user->role === 'driver' || $user->role === 'vehicle_admin';
    }

    /**
     * Determine whether the user can update the booking.
     */
    public function update(User $user, VehicleBooking $booking): bool
    {
        return $user->id === $booking->user_id || $user->role === 'vehicle_admin';
    }

    /**
     * Determine whether the user can delete the booking.
     */
    public function delete(User $user, VehicleBooking $booking): bool
    {
        return $user->role === 'vehicle_admin';
    }

    /**
     * Determine whether the user can approve bookings.
     */
    public function approve(User $user, VehicleBooking $booking): bool
    {
        return ($user->role === 'supervisor_driver' && $user->id === $booking->supervisor_id) ||
            ($user->role === 'supervisor_admin' && $user->region_id === $booking->vehicle->region_id);
    }
}
