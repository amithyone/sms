<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Main Categories
        $mainCategories = [
            [
                'name' => 'Flowers',
                'icon' => '🌹',
                'description' => 'Beautiful flowers for every occasion',
                'sort_order' => 1,
            ],
            [
                'name' => 'Food & Dining',
                'icon' => '🍕',
                'description' => 'Delicious food from your favorite restaurants',
                'sort_order' => 2,
            ],
            [
                'name' => 'Jewelry',
                'icon' => '💍',
                'description' => 'Elegant jewelry pieces for special moments',
                'sort_order' => 3,
            ],
            [
                'name' => 'Electronics',
                'icon' => '📱',
                'description' => 'Latest gadgets and electronics',
                'sort_order' => 4,
            ],
            [
                'name' => 'Fashion & Apparel',
                'icon' => '👗',
                'description' => 'Trendy fashion items and clothing',
                'sort_order' => 5,
            ],
            [
                'name' => 'Home & Garden',
                'icon' => '🏠',
                'description' => 'Home decor and garden essentials',
                'sort_order' => 6,
            ],
            [
                'name' => 'Books & Media',
                'icon' => '📚',
                'description' => 'Books, movies, and entertainment',
                'sort_order' => 7,
            ],
            [
                'name' => 'Sports & Outdoors',
                'icon' => '⚽',
                'description' => 'Sports equipment and outdoor gear',
                'sort_order' => 8,
            ],
        ];

        // Create main categories
        foreach ($mainCategories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'icon' => $category['icon'],
                'description' => $category['description'],
                'sort_order' => $category['sort_order'],
                'is_active' => true,
            ]);
        }

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
                Category::create([
                    'name' => $subcategory['name'],
                    'slug' => Str::slug($subcategory['name']),
                    'icon' => $subcategory['icon'],
                    'description' => $subcategory['description'],
                    'sort_order' => $subcategory['sort_order'],
                    'parent_id' => $fashionCategory->id,
                    'is_active' => true,
                ]);
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
                Category::create([
                    'name' => $subcategory['name'],
                    'slug' => Str::slug($subcategory['name']),
                    'icon' => $subcategory['icon'],
                    'description' => $subcategory['description'],
                    'sort_order' => $subcategory['sort_order'],
                    'parent_id' => $electronicsCategory->id,
                    'is_active' => true,
                ]);
            }
        }
    }
}
