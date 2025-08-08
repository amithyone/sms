<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get Fashion category for subcategories
        $fashionCategory = Category::where('slug', 'fashion-apparel')->first();

        if ($fashionCategory) {
            $fashionSubcategories = [
                [
                    'name' => 'T-Shirts',
                    'icon' => '👕',
                    'description' => 'Comfortable and stylish t-shirts',
                    'sort_order' => 1,
                ],
                [
                    'name' => 'Hoodies',
                    'icon' => '🧥',
                    'description' => 'Warm and cozy hoodies',
                    'sort_order' => 2,
                ],
                [
                    'name' => 'Dresses',
                    'icon' => '👗',
                    'description' => 'Elegant dresses for all occasions',
                    'sort_order' => 3,
                ],
                [
                    'name' => 'Jeans',
                    'icon' => '👖',
                    'description' => 'Classic and trendy jeans',
                    'sort_order' => 4,
                ],
                [
                    'name' => 'Shoes',
                    'icon' => '👟',
                    'description' => 'Comfortable and stylish footwear',
                    'sort_order' => 5,
                ],
                [
                    'name' => 'Accessories',
                    'icon' => '👜',
                    'description' => 'Bags, belts, and other accessories',
                    'sort_order' => 6,
                ],
            ];

            foreach ($fashionSubcategories as $subcategory) {
                Category::firstOrCreate(
                    ['slug' => Str::slug($subcategory['name'])],
                    [
                        'name' => $subcategory['name'],
                        'icon' => $subcategory['icon'],
                        'description' => $subcategory['description'],
                        'sort_order' => $subcategory['sort_order'],
                        'parent_id' => $fashionCategory->id,
                        'is_active' => true,
                    ]
                );
            }
        }

        // Get Electronics category for subcategories
        $electronicsCategory = Category::where('slug', 'electronics')->first();

        if ($electronicsCategory) {
            $electronicsSubcategories = [
                [
                    'name' => 'Smartphones',
                    'icon' => '📱',
                    'description' => 'Latest smartphones and mobile devices',
                    'sort_order' => 1,
                ],
                [
                    'name' => 'Laptops',
                    'icon' => '💻',
                    'description' => 'High-performance laptops and computers',
                    'sort_order' => 2,
                ],
                [
                    'name' => 'Headphones',
                    'icon' => '🎧',
                    'description' => 'Quality headphones and audio devices',
                    'sort_order' => 3,
                ],
                [
                    'name' => 'Smart Watches',
                    'icon' => '⌚',
                    'description' => 'Smart watches and fitness trackers',
                    'sort_order' => 4,
                ],
            ];

            foreach ($electronicsSubcategories as $subcategory) {
                Category::firstOrCreate(
                    ['slug' => Str::slug($subcategory['name'])],
                    [
                        'name' => $subcategory['name'],
                        'icon' => $subcategory['icon'],
                        'description' => $subcategory['description'],
                        'sort_order' => $subcategory['sort_order'],
                        'parent_id' => $electronicsCategory->id,
                        'is_active' => true,
                    ]
                );
            }
        }

        // Get Home & Garden category for subcategories
        $homeCategory = Category::where('slug', 'home-garden')->first();

        if ($homeCategory) {
            $homeSubcategories = [
                [
                    'name' => 'Furniture',
                    'icon' => '🪑',
                    'description' => 'Beautiful furniture for your home',
                    'sort_order' => 1,
                ],
                [
                    'name' => 'Decor',
                    'icon' => '🖼️',
                    'description' => 'Home decoration items',
                    'sort_order' => 2,
                ],
                [
                    'name' => 'Kitchen',
                    'icon' => '🍳',
                    'description' => 'Kitchen appliances and utensils',
                    'sort_order' => 3,
                ],
                [
                    'name' => 'Garden',
                    'icon' => '🌱',
                    'description' => 'Garden tools and plants',
                    'sort_order' => 4,
                ],
            ];

            foreach ($homeSubcategories as $subcategory) {
                Category::firstOrCreate(
                    ['slug' => Str::slug($subcategory['name'])],
                    [
                        'name' => $subcategory['name'],
                        'icon' => $subcategory['icon'],
                        'description' => $subcategory['description'],
                        'sort_order' => $subcategory['sort_order'],
                        'parent_id' => $homeCategory->id,
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
