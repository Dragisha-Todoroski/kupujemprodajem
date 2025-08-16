<?php

namespace App\Contracts;

use App\Models\Category;
use Illuminate\Support\Collection;

interface CategoryService
{
    /** Fetch all categories */
    public function getAll(): Collection;

    /** Create a new category from validated data */
    public function create(array $data): Category;

    /** Update an existing category with validated data */
    public function update(Category $category, array $data): Category;

    /** Delete an existing category */
    public function delete(Category $category): bool;
}
