<?php

namespace App\Contracts;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface CustomerService
{
    /** Fetch all customers, optionally paginated */
    public function getAll(?int $perPage = null) : LengthAwarePaginator;

    /** Create a new customer from validated data */
    public function create(array $data): User;

    /** Update an existing customer with validated data */
    public function update(User $customers, array $data): User;

    /** Delete an existing customer */
    public function delete(User $customers): bool;
}
