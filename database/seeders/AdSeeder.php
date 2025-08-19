<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ad;
use App\Models\Category;

class AdSeeder extends Seeder
{
    public function run(): void
    {
        // Makes sure categories exist before ads
        if (Category::count() === 0) {
            $this->call(CategorySeeder::class);
        }

        // Gets only leaf categories (lowest-layer children)
        $categories = Category::doesntHave('children')->get();

        // Creates 50 ads and assigns each to a random leaf category
        Ad::factory(50)->make()->each(function ($ad) use ($categories) {
            $ad->category_id = $categories->random()->getKey();
            $ad->save();
        });
    }
}