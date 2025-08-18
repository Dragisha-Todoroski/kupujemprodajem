<?php

// database/factories/CategoryFactory.php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    // Creates top-level categories
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'parent_id' => null, // default top-level
        ];
    }
}
