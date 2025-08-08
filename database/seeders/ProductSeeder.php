<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Store;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Flowers
            [
                'name' => 'Red Rose Bouquet',
                'description' => 'Beautiful red roses arranged in a stunning bouquet',
                'price' => 49.99,
                'category' => 'Flowers',
                'store' => '1-800-Flowers',
                'is_featured' => true,
                'allow_customization' => true,
                'image' => 'products/image-1.jpg',
            ],
            [
                'name' => 'Mixed Flower Basket',
                'description' => 'Colorful mixed flowers in a decorative basket',
                'price' => 39.99,
                'category' => 'Flowers',
                'store' => '1-800-Flowers',
                'is_featured' => false,
                'allow_customization' => true,
                'image' => 'products/image-2.jpg',
            ],
            // Food & Dining
            [
                'name' => 'Big Mac Combo',
                'description' => 'Classic Big Mac with fries and drink',
                'price' => 12.99,
                'category' => 'Food & Dining',
                'store' => 'McDonald\'s',
                'is_featured' => true,
                'allow_customization' => false,
                'image' => 'products/image-3.jpg',
            ],
            [
                'name' => 'Chick-fil-A Sandwich Meal',
                'description' => 'Original chicken sandwich with waffle fries and drink',
                'price' => 14.99,
                'category' => 'Food & Dining',
                'store' => 'Chick-fil-A',
                'is_featured' => true,
                'allow_customization' => false,
                'image' => 'products/image-4.jpg',
            ],
            [
                'name' => 'KFC Bucket Meal',
                'description' => '8-piece chicken bucket with sides',
                'price' => 24.99,
                'category' => 'Food & Dining',
                'store' => 'KFC',
                'is_featured' => false,
                'allow_customization' => false,
                'image' => 'products/image-5.jpg',
            ],
            // Jewelry
            [
                'name' => 'Pandora Heart Charm',
                'description' => 'Beautiful sterling silver heart charm',
                'price' => 35.00,
                'category' => 'Jewelry',
                'store' => 'Pandora Jewelry',
                'is_featured' => true,
                'allow_customization' => false,
                'image' => 'products/image-6.jpg',
            ],
            [
                'name' => 'Pandora Bracelet Set',
                'description' => 'Sterling silver bracelet with multiple charms',
                'price' => 89.99,
                'category' => 'Jewelry',
                'store' => 'Pandora Jewelry',
                'is_featured' => false,
                'allow_customization' => true,
                'image' => 'products/image-7.jpg',
            ],
            // Electronics
            [
                'name' => 'iPhone 15 Pro',
                'description' => 'Latest iPhone with advanced features',
                'price' => 999.00,
                'category' => 'Electronics',
                'store' => 'Apple',
                'is_featured' => true,
                'allow_customization' => false,
                'image' => 'products/image-8.jpg',
            ],
            [
                'name' => 'AirPods Pro',
                'description' => 'Wireless earbuds with noise cancellation',
                'price' => 249.00,
                'category' => 'Electronics',
                'store' => 'Apple',
                'is_featured' => false,
                'allow_customization' => false,
                'image' => 'products/image-9.jpg',
            ],
            // Fashion
            [
                'name' => 'Designer Handbag',
                'description' => 'Elegant leather handbag',
                'price' => 199.99,
                'category' => 'Fashion',
                'store' => 'Walmart',
                'is_featured' => false,
                'allow_customization' => false,
                'image' => 'products/image-10.jpg',
            ],
            // Custom Products
            [
                'name' => 'Custom Hoodie',
                'description' => 'Personalized hoodie with custom design',
                'price' => 24000000.00,
                'category' => 'T-Shirts',
                'store' => 'Bubblemart Store',
                'is_featured' => true,
                'allow_customization' => true,
                'image' => 'products/image-11.jpg',
            ],
            [
                'name' => 'Custom T-Shirt',
                'description' => 'Personalized t-shirt with custom design',
                'price' => 12800000.00,
                'category' => 'T-Shirts',
                'store' => 'Bubblemart Store',
                'is_featured' => true,
                'allow_customization' => true,
                'image' => 'products/image-12.jpg',
            ],
            [
                'name' => 'Custom Cap',
                'description' => 'Personalized cap with custom embroidery',
                'price' => 8000000.00,
                'category' => 'T-Shirts',
                'store' => 'Bubblemart Store',
                'is_featured' => false,
                'allow_customization' => true,
                'image' => 'products/image-13.jpg',
            ],
            [
                'name' => 'Photo Frame',
                'description' => 'Beautiful photo frame for your memories',
                'price' => 19200000.00,
                'category' => 'Home & Garden',
                'store' => 'Bubblemart Store',
                'is_featured' => false,
                'allow_customization' => true,
                'image' => 'products/image-14.jpg',
            ],
            [
                'name' => 'Picture Frame',
                'description' => 'Elegant picture frame for artwork',
                'price' => 16000000.00,
                'category' => 'Home & Garden',
                'store' => 'Bubblemart Store',
                'is_featured' => false,
                'allow_customization' => true,
                'image' => 'products/image-1.jpg',
            ],
            [
                'name' => 'Custom Mug',
                'description' => 'Personalized coffee mug with custom design',
                'price' => 9600000.00,
                'category' => 'Home & Garden',
                'store' => 'Bubblemart Store',
                'is_featured' => false,
                'allow_customization' => true,
                'image' => 'products/image-2.jpg',
            ],
            [
                'name' => 'Custom Cup',
                'description' => 'Personalized cup with custom design',
                'price' => 7200000.00,
                'category' => 'Home & Garden',
                'store' => 'Bubblemart Store',
                'is_featured' => false,
                'allow_customization' => true,
                'image' => 'products/image-3.jpg',
            ],
            [
                'name' => 'Fan Card',
                'description' => 'Custom fan card design',
                'price' => 4800000.00,
                'category' => 'Accessories',
                'store' => 'Bubblemart Store',
                'is_featured' => false,
                'allow_customization' => true,
                'image' => 'products/image-4.jpg',
            ],
            [
                'name' => 'ATM Card',
                'description' => 'Custom ATM card design',
                'price' => 3600000.00,
                'category' => 'Accessories',
                'store' => 'Bubblemart Store',
                'is_featured' => false,
                'allow_customization' => true,
                'image' => 'products/image-5.jpg',
            ],
            [
                'name' => 'Custom Pillow',
                'description' => 'Personalized pillow with custom design',
                'price' => 6400000.00,
                'category' => 'Home & Garden',
                'store' => 'Bubblemart Store',
                'is_featured' => false,
                'allow_customization' => true,
                'image' => 'products/image-6.jpg',
            ],
            [
                'name' => 'Custom Blanket',
                'description' => 'Personalized blanket with custom design',
                'price' => 8000000.00,
                'category' => 'Home & Garden',
                'store' => 'Bubblemart Store',
                'is_featured' => false,
                'allow_customization' => true,
                'image' => 'products/image-7.jpg',
            ],
        ];

        foreach ($products as $product) {
            $category = Category::where('name', $product['category'])->first();
            $store = Store::where('name', $product['store'])->first();

            if ($category && $store) {
                Product::create([
                    'name' => $product['name'],
                    'slug' => Str::slug($product['name']),
                    'description' => $product['description'],
                    'price' => $product['price'],
                    'category_id' => $category->id,
                    'store_id' => $store->id,
                    'is_featured' => $product['is_featured'],
                    'allow_customization' => $product['allow_customization'],
                    'is_active' => true,
                    'stock' => 100,
                    'delivery_time_hours' => 24,
                    'image' => $product['image'] ?? null,
                ]);
            }
        }
    }
}
