<?php

namespace App\Policies;

use App\Models\Ad;
use App\Models\User;

class AdPolicy
{
    /**
     * Determine whether the user can view any ads
     */
    public function viewAny(?User $user): bool
    {
        // Everyone can view ad listings (including guests)
        return true;
    }

    /**
     * Determine whether the user can view a single ad
     */
    public function view(?User $user, Ad $ad): bool
    {
        // Everyone can view individual ads (including guests)
        return true;
    }

    /**
     * Determine whether the user can create ads
     */
    public function create(User $user): bool
    {
        // Only admins and customers can create ads
        return $user->isAdmin() || $user->isCustomer();
    }

    /**
     * Determine whether the user can update ads
     */
    public function update(User $user, Ad $ad): bool
    {
        // Only admins can update any ad
        // Customers can only update their own ads
        return $user->isAdmin() || $user->getKey() === $ad->user_id;
    }

    /**
     * Determine whether the user can delete ads
     */
    public function delete(User $user, Ad $ad): bool
    {
        // Only admins can delete any ad
        // Customers can only delete their own ads
        return $user->isAdmin() || $user->getKey() === $ad->user_id;
    }
}
