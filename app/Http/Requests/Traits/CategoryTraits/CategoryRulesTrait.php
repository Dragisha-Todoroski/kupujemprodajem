<?php

namespace App\Http\Requests\Traits\CategoryTraits;

use App\Models\Category;
use Illuminate\Validation\Rule;

trait CategoryRulesTrait
{
    public function categoryRules(string $requirement = 'required', Category $category = null): array
    {
        return [
            'name' => [
                $requirement,
                'string',
                'min:1',
                'max:100'
            ],

            // Filter out `null` values when used for creating categories
            'parent_id' => array_filter([
                'nullable', // nullable for top-level categories
                'uuid', // must be a valid UUID format

                // Value must exist in primary key of categories table
                // Fetch primary key column dynamically
                Rule::exists((new Category)->getTable(), (new Category)->getKeyName()),

                $category ? Rule::notIn(
                    array_merge(
                        [$category->getKey()],          // cannot assign itself
                        $category->descendantsKeys()    // cannot assign any of its descendants
                    )
                ) : null // rule doesn't get triggered on creating (only updating!) because category isn't created yet
            ]),
        ];
    }
}
