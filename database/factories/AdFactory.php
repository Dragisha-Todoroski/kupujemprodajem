<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Ad;
use App\Models\User;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ad>
 */
class AdFactory extends Factory
{
    protected $model = Ad::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 10, 2000),
            'location' => $this->faker->city,
            'condition' => $this->faker->randomElement(['new', 'used']),
            'contact_phone' => $this->faker->phoneNumber,
            'user_id' => User::inRandomOrder()->first()->getKey() ?? User::factory()->create()->getKey(),
            'category_id' => Category::inRandomOrder()->first()->getKey() ?? Category::factory()->create()->getKey(),
        ];
    }
}