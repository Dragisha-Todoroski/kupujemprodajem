<?php

namespace App\Services;

use App\Contracts\CategoryService;
use App\Models\Category;
use Illuminate\Support\Collection;

class EloquentCategoryService implements CategoryService
{
    /** Fetch all categories */
    public function getAll(): Collection
    {
        // Returns multi-level categories
        return Category::with('allDescendantsRecursive') // each nested child is included automatically
            ->whereNull('parent_id') // fetches only top-level categories as starting point
            ->get();
    }

    /** Create a new category from validated data */
    public function create(array $data): Category
    {
        return Category::create($data);
    }

    /** Update an existing category with validated data */
    public function update(Category $category, array $data): Category
    {
        $category->update($data);
        return $category;
    }

    /** Delete an existing category */
    public function delete(Category $category): bool
    {
        return $category->delete();
    }
}
