<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Store;
use Illuminate\Support\Str;

class CustomizeProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create a default store
        $store = Store::firstOrCreate(
            ['name' => 'Bubblemart Store'],
            [
                'slug' => Str::slug('Bubblemart Store'),
                'description' => 'Official Bubblemart store for customized gifts',
                'address' => 'Lagos, Nigeria',
                'phone' => '+2341234567890',
                'email' => 'store@bubblemart.com',
                'is_active' => true,
            ]
        );

        $products = [
            // Wears Category
            [
                'name' => 'Custom Hoodie',
                'category' => 'Wears',
                'description' => 'Personalized hoodie with your custom design',
                'price' => 15000,
                'stock' => 50,
            ],
            [
                'name' => 'Custom T-Shirt',
                'category' => 'Wears',
                'description' => 'Personalized t-shirt with your custom design',
                'price' => 8000,
                'stock' => 100,
            ],
            [
                'name' => 'Custom Cap',
                'category' => 'Wears',
                'description' => 'Personalized cap with your custom design',
                'price' => 5000,
                'stock' => 75,
            ],

            // Frames Category
            [
                'name' => 'Photo Frame',
                'category' => 'Frames',
                'description' => 'Custom photo frame for your memories',
                'price' => 12000,
                'stock' => 30,
            ],
            [
                'name' => 'Picture Frame',
                'category' => 'Frames',
                'description' => 'Personalized picture frame',
                'price' => 10000,
                'stock' => 40,
            ],

            // Drinkware Category
            [
                'name' => 'Custom Mug',
                'category' => 'Drinkware',
                'description' => 'Personalized coffee mug',
                'price' => 6000,
                'stock' => 80,
            ],
            [
                'name' => 'Custom Cup',
                'category' => 'Drinkware',
                'description' => 'Personalized drinking cup',
                'price' => 4000,
                'stock' => 90,
            ],

            // Cards Category
            [
                'name' => 'Fan Card',
                'category' => 'Cards',
                'description' => 'Custom fan card design',
                'price' => 3000,
                'stock' => 200,
            ],
            [
                'name' => 'ATM Card',
                'category' => 'Cards',
                'description' => 'Custom ATM card design',
                'price' => 2500,
                'stock' => 150,
            ],

            // Home & Living Category
            [
                'name' => 'Custom Pillow',
                'category' => 'Home & Living',
                'description' => 'Personalized decorative pillow',
                'price' => 9000,
                'stock' => 60,
            ],
            [
                'name' => 'Custom Blanket',
                'category' => 'Home & Living',
                'description' => 'Personalized blanket',
                'price' => 18000,
                'stock' => 25,
            ],
        ];

        foreach ($products as $productData) {
            $category = Category::where('name', $productData['category'])->first();
            
            if ($category) {
                // Check if product already exists
                $existingProduct = Product::where('name', $productData['name'])->first();
                
                if (!$existingProduct) {
                    Product::create([
                        'name' => $productData['name'],
                        'slug' => Str::slug($productData['name']),
                        'description' => $productData['description'],
                        'price' => $productData['price'],
                        'price_naira' => $productData['price'],
                        'stock' => $productData['stock'],
                        'category_id' => $category->id,
                        'store_id' => $store->id,
                        'is_active' => true,
                        'is_featured' => false,
                    ]);
                }
            }
        }
    }
}
