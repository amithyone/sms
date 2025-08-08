<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class JewelrySubcategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find the jewelry category
        $jewelryCategory = Category::where('name', 'like', '%jewelry%')
            ->orWhere('name', 'like', '%jewel%')
            ->orWhere('name', 'like', '%accessor%')
            ->first();

        if (!$jewelryCategory) {
            // Create jewelry category if it doesn't exist
            $jewelryCategory = Category::create([
                'name' => 'Jewelry & Accessories',
                'slug' => 'jewelry-accessories',
                'description' => 'Beautiful jewelry and accessories for all occasions',
                'icon' => '💍',
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 5,
                'variation_types' => ['size', 'color', 'material', 'style'],
            ]);
        }

        // Create subcategories
        $subcategories = [
            [
                'name' => "Men's Jewelry",
                'slug' => 'mens-jewelry',
                'description' => 'Elegant jewelry designed for men',
                'icon' => '👔',
                'variation_types' => ['size', 'color', 'material', 'style'],
            ],
            [
                'name' => "Women's Jewelry",
                'slug' => 'womens-jewelry',
                'description' => 'Beautiful jewelry designed for women',
                'icon' => '👗',
                'variation_types' => ['size', 'color', 'material', 'style'],
            ],
            [
                'name' => 'Unisex Jewelry',
                'slug' => 'unisex-jewelry',
                'description' => 'Jewelry suitable for everyone',
                'icon' => '✨',
                'variation_types' => ['size', 'color', 'material', 'style'],
            ],
            [
                'name' => 'Watches',
                'slug' => 'watches',
                'description' => 'Elegant timepieces for all occasions',
                'icon' => '⌚',
                'variation_types' => ['size', 'color', 'material', 'style'],
            ],
            [
                'name' => 'Bags & Purses',
                'slug' => 'bags-purses',
                'description' => 'Stylish bags and purses',
                'icon' => '👜',
                'variation_types' => ['size', 'color', 'material', 'style'],
            ],
        ];

        foreach ($subcategories as $subcategoryData) {
            // Check if subcategory already exists
            $existingSubcategory = Category::where('slug', $subcategoryData['slug'])->first();
            
            if (!$existingSubcategory) {
                Category::create([
                    'name' => $subcategoryData['name'],
                    'slug' => $subcategoryData['slug'],
                    'description' => $subcategoryData['description'],
                    'icon' => $subcategoryData['icon'],
                    'is_active' => true,
                    'is_featured' => false,
                    'sort_order' => 1,
                    'parent_id' => $jewelryCategory->id,
                    'variation_types' => $subcategoryData['variation_types'],
                ]);
            }
        }

        $this->command->info('Jewelry subcategories created successfully!');
    }
} 