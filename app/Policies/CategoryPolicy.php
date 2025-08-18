<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    /**
     * Determine whether the user can view any categories (admin list)
     */
    public function viewAny(User $user): bool
    {
        // Only admins can view all categories in bulk (for admin dashboard)
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view a single category
     */
    public function view(?User $user, Category $category): bool
    {
        // Everyone who is logged in can view a single category
        // Guests can be handled in controllers separately for frontend browsing
        return true;
    }

    /**
     * Determine whether the user can create categories
     */
    public function create(User $user): bool
    {
        // Only admins can create categories
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update categories
     */
    public function update(User $user, Category $category): bool
    {
        // Only admins can update categories
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete categories
     */
    public function delete(User $user, Category $category): bool
    {
        // Only admins can delete categories
        return $user->isAdmin();
    }
}
