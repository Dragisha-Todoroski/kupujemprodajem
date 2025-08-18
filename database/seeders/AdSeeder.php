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

        // Creates 50 ads with random categories and users
        Ad::factory(50)->create();
    }
}