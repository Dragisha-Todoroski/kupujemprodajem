<?php

namespace App\Http\Requests\Traits\AdTraits;

use App\Models\Ad;
use App\Models\Category;
use Illuminate\Validation\Rule;

trait AdRulesTrait
{
    public function adRules(string $requirement = 'required'): array
    {
        return [
            'title' => [$requirement, 'string', 'min:1', 'max:100'],
            'description' => ['nullable', 'string', 'max:400'],
            'price' => [$requirement, 'numeric', 'gt:0'],
            'condition' => [$requirement, 'string', 'in:new,used'],
            'image_path' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'contact_phone' => [$requirement, 'string', 'min:1', 'max:15'],
            'location' => [$requirement, 'string', 'min:1', 'max:100'],

            'category_id' => [
                $requirement,
                'uuid',
                Rule::exists((new Category)->getTable(), (new Category)->getKeyName())
            ],
        ];
    }
}
