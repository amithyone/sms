<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoryVariationTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define variation types for different categories
        $categoryVariations = [
            // Clothing categories
            'Fashion' => ['size', 'color', 'material', 'style', 'fit'],
            'Wears' => ['size', 'color', 'material', 'style', 'fit'],
            'T-Shirts' => ['size', 'color', 'material', 'style', 'fit'],
            'Hoodies' => ['size', 'color', 'material', 'style', 'fit'],
            'Dresses' => ['size', 'color', 'material', 'style', 'fit'],
            'Jeans' => ['size', 'color', 'material', 'fit'],
            'Shoes' => ['size', 'color', 'material', 'style'],
            'Accessories' => ['color', 'material', 'style'],
            'Jewelry' => ['color', 'material', 'style'],
            'Smart Watches' => ['color', 'material', 'style'],
            
            // Electronics categories
            'Electronics' => ['color', 'style'],
            'Smartphones' => ['color', 'style'],
            'Laptops' => ['color', 'style'],
            'Headphones' => ['color', 'style'],
            
            // Home & Living
            'Home & Garden' => ['color', 'material', 'style'],
            'Home & Living' => ['color', 'material', 'style'],
            'Furniture' => ['color', 'material', 'style'],
            'Decor' => ['color', 'material', 'style'],
            'Kitchen' => ['color', 'material', 'style'],
            'Garden' => ['color', 'material', 'style'],
            
            // Sports & Outdoors
            'Sports & Outdoors' => ['size', 'color', 'material', 'style'],
            
            // Books & Media
            'Books & Media' => ['style'],
            
            // Other categories
            'Flowers' => ['color', 'style'],
            'Food & Dining' => ['style'],
            'Frames' => ['color', 'material', 'style'],
            'Drinkware' => ['color', 'material', 'style'],
            'Cards' => ['style'],
        ];

        foreach ($categoryVariations as $categoryName => $variationTypes) {
            $category = Category::where('name', $categoryName)->first();
            if ($category) {
                $category->update(['variation_types' => $variationTypes]);
                $this->command->info("Updated category: {$categoryName} with variations: " . implode(', ', $variationTypes));
            } else {
                $this->command->warn("Category not found: {$categoryName}");
            }
        }

        // For categories not explicitly defined, add basic variations
        $categoriesWithoutVariations = Category::whereNull('variation_types')->get();
        foreach ($categoriesWithoutVariations as $category) {
            // Add basic variations based on category name
            $basicVariations = ['color', 'style'];
            
            // Add size for clothing-like categories
            if (stripos($category->name, 'clothing') !== false || 
                stripos($category->name, 'shirt') !== false || 
                stripos($category->name, 'dress') !== false || 
                stripos($category->name, 'pant') !== false || 
                stripos($category->name, 'shoe') !== false ||
                stripos($category->name, 'wear') !== false) {
                $basicVariations[] = 'size';
            }
            
            $category->update(['variation_types' => $basicVariations]);
            $this->command->info("Added basic variations to category: {$category->name}");
        }
    }
}
