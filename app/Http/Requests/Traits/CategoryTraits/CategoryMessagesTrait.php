<?php

namespace App\Http\Requests\Traits\CategoryTraits;

trait CategoryMessagesTrait
{
    public function categoryMessages(): array
    {
        return [
            // `name` field
            'name.required' => 'Category name is required.',
            'name.min' => 'Category name must be at least 1 character.',
            'name.max' => 'Category name may not exceed 100 characters.',

            // `parent_id` field
            'parent_id.uuid' => 'Parent category ID must be in a valid format.',
            'parent_id.exists' => 'Selected parent category does not exist.',
            'parent_id.not_in' => 'Category cannot be its own parent or a child of its own descendants',
        ];
    }
}
