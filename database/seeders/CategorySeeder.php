<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Creates 7 random top-level categories
        $parents = Category::factory(7)->create();

        foreach ($parents as $parent) {
            // Each parent gets between 0–4 random children
            $children = Category::factory(rand(0, 4))
                ->create(['parent_id' => $parent->getKey()]);

            foreach ($children as $child) {
                // Each child gets 0–3 grandchildren
                Category::factory(rand(0, 3))
                    ->create(['parent_id' => $child->getKey()]);
            }
        }

        // Manual categories:
        // Top-level categories
        $computers = Category::firstOrCreate(['name' => 'Computers']);
        $electronics = Category::firstOrCreate(['name' => 'Electronics']);
        $furniture = Category::firstOrCreate(['name' => 'Furniture']);

        // Second-level under Computers
        $components = Category::firstOrCreate(['name' => 'Components', 'parent_id' => $computers->getKey()]);
        $laptops = Category::firstOrCreate(['name' => 'Laptops', 'parent_id' => $computers->getKey()]);

        // Second-level under Electronics
        $smartphones = Category::firstOrCreate(['name' => 'Smartphones', 'parent_id' => $electronics->getKey()]);
        $tablets = Category::firstOrCreate(['name' => 'Tablets', 'parent_id' => $electronics->getKey()]);

        // Second-level under Furniture
        $chairs = Category::firstOrCreate(['name' => 'Chairs', 'parent_id' => $furniture->getKey()]);
        $tables = Category::firstOrCreate(['name' => 'Tables', 'parent_id' => $furniture->getKey()]);

        // Third-level under Computers->Components
        $graphicsCards = Category::firstOrCreate(['name' => 'Graphics Cards', 'parent_id' => $components->getKey()]);
    }
}
