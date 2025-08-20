<?php

namespace App\Services;

use App\Contracts\CategoryService;
use App\Models\Category;
use Illuminate\Support\Collection;

class EloquentCategoryService implements CategoryService
{
    /** Fetch all categories */
    public function getAll(?int $perPage = null): Collection
    {
        // Returns multi-level categories
        $query = Category::with('allDescendantsRecursive') // each nested child is included automatically
            ->whereNull('parent_id'); // fetches only top-level categories as starting point

        if ($perPage) {
            return $query->paginate($perPage);
        }

        return $query->get();
    }

    /** Get only leaf (lowest-layer) categories */
    public function getLeafCategories(): Collection
    {
        $categories = $this->getAll();

        $getLeafCategories = function ($categories) use (&$getLeafCategories) {
            $leaves = collect();
            foreach ($categories as $category) {
                if ($category->children->count() === 0) {
                    $leaves->push($category);
                } else {
                    $leaves = $leaves->merge($getLeafCategories($category->children));
                }
            }
            return $leaves;
        };

        return $getLeafCategories($categories);
    }

    public function getById(string $id): Category
    {
        // Throws ModelNotFoundException if not found
        return Category::findOrFail($id);
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
