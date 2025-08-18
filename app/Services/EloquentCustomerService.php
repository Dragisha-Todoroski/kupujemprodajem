<?php

namespace App\Services;

use App\Contracts\CustomerService;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentUserService implements CustomerService
{
    /**
     * Fetch all customers, optionally paginated
     */
    public function getAll(?int $perPage = null)
    {
        $query = User::where('role', UserRole::CUSTOMER->value);

        if ($perPage) {
            return $query->paginate($perPage);
        }

        return $query->get();
    }

    /**
     * Create a new customer
     */
    public function create(array $data): User
    {
        // Forces role to customer
        $data['role'] = UserRole::CUSTOMER->value;

        // Hashes password if provided
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return User::create($data);
    }

    /**
     * Update an existing customer
     */
    public function update(User $customer, array $data): User
    {
        if ($customer->role !== UserRole::CUSTOMER->value) {
            throw new \Exception("Cannot update admin users.");
        }

        // Prevents role change
        unset($data['role']);

        // Hashes password if provided
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']); // avoids overwriting with null
        }

        $customer->update($data);
        return $customer;
    }

    /**
     * Delete a customer
     */
    public function delete(User $customer): bool
    {
        // Never deletes admins
        if ($customer->role !== UserRole::CUSTOMER->value) {
            return false;
        }

        return $customer->delete();
    }
}
