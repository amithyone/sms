<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CustomizeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Jewelry',
                'icon' => '💎',
                'description' => 'Rings, Necklaces, Bracelets, Watches',
                'sort_order' => 1,
            ],
            [
                'name' => 'Frames',
                'icon' => '🖼️',
                'description' => 'Photo Frames & Picture Frames',
                'sort_order' => 2,
            ],
            [
                'name' => 'Wears',
                'icon' => '👕',
                'description' => 'Hoodies, T-shirts, Caps',
                'sort_order' => 3,
            ],
            [
                'name' => 'Drinkware',
                'icon' => '☕',
                'description' => 'Cups, Mugs, Bottles',
                'sort_order' => 4,
            ],
            [
                'name' => 'Cards',
                'icon' => '💳',
                'description' => 'Fan Cards, ATM Cards',
                'sort_order' => 5,
            ],
            [
                'name' => 'Home & Living',
                'icon' => '🏠',
                'description' => 'Pillows, Blankets, Decor',
                'sort_order' => 6,
            ],
        ];

        foreach ($categories as $category) {
            // Check if category already exists
            $existingCategory = Category::where('slug', Str::slug($category['name']))->first();
            
            if (!$existingCategory) {
                Category::create([
                    'name' => $category['name'],
                    'slug' => Str::slug($category['name']),
                    'icon' => $category['icon'],
                    'description' => $category['description'],
                    'sort_order' => $category['sort_order'],
                    'is_active' => true,
                ]);
            }
        }
    }
}
