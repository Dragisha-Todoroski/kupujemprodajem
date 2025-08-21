<?php

namespace App\Contracts;

use App\Models\Category;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface CategoryService
{
    /** Fetch all categories (always returns a Collection) */
    public function getAll(): Collection;

    /** Fetch paginated categories for admin tables */
    public function getAllPaginated(int $perPage): LengthAwarePaginator;

    /** Get only leaf (lowest-layer) categories */
    public function getLeafCategories(): Collection;

    /** Fetch a single category by ID */
    public function getById(string $id): Category;

    /** Create a new category from validated data */
    public function create(array $data): Category;

    /** Update an existing category with validated data */
    public function update(Category $category, array $data): Category;

    /** Delete an existing category */
    public function delete(Category $category): bool;
}
