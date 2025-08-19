<?php

namespace App\Policies;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Auth\Access\Response;

class CustomerPolicy
{
    /**
     * Determine whether the user can view any customers (admin list)
     */
    public function viewAny(User $user): bool
    {
        // Only admins can view all customers in bulk (for admin dashboard)
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view a single customer
     */
    public function view(User $user, User $customer): bool
    {
        // Only if the user is an admin and the target user is a customer
        return $user->isAdmin() && $customer->isCustomer();
    }

    /**
     * Determine whether the user can create customers
     */
    public function create(User $user): bool
    {
        // Only if the user is an admin
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update customers
     */
    public function update(User $user, User $customer): bool
    {
        // Only if the user is an admin and the target user is a customer
        return $user->isAdmin() && $customer->isCustomer();
    }

    /**
     * Determine whether the user can delete customers
     */
    public function delete(User $user, User $customer): bool
    {
        // Only allows deleting if the current user is admin and the target is a customer
        return $user->isAdmin() && $customer->isCustomer();
    }
}