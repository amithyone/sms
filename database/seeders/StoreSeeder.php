<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Store;
use Illuminate\Support\Str;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stores = [
            [
                'name' => 'McDonald\'s',
                'description' => 'Fast food restaurant chain',
                'website_url' => 'https://www.mcdonalds.com',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Chick-fil-A',
                'description' => 'Fast food restaurant specializing in chicken sandwiches',
                'website_url' => 'https://www.chick-fil-a.com',
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Uber Eats',
                'description' => 'Food delivery service',
                'website_url' => 'https://www.ubereats.com',
                'is_featured' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Walmart',
                'description' => 'Retail corporation',
                'website_url' => 'https://www.walmart.com',
                'is_featured' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Apple',
                'description' => 'Technology company',
                'website_url' => 'https://www.apple.com',
                'is_featured' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'KFC',
                'description' => 'Fast food restaurant chain specializing in fried chicken',
                'website_url' => 'https://www.kfc.com',
                'is_featured' => true,
                'sort_order' => 6,
            ],
            [
                'name' => '1-800-Flowers',
                'description' => 'Florist and gift retailer',
                'website_url' => 'https://www.1800flowers.com',
                'is_featured' => true,
                'sort_order' => 7,
            ],
            [
                'name' => 'Pandora Jewelry',
                'description' => 'Jewelry retailer',
                'website_url' => 'https://www.pandora.net',
                'is_featured' => true,
                'sort_order' => 8,
            ],
            [
                'name' => 'Domino\'s Pizza',
                'description' => 'Pizza restaurant chain',
                'website_url' => 'https://www.dominos.com',
                'is_featured' => false,
                'sort_order' => 9,
            ],
            [
                'name' => 'Starbucks',
                'description' => 'Coffeehouse chain',
                'website_url' => 'https://www.starbucks.com',
                'is_featured' => false,
                'sort_order' => 10,
            ],
        ];

        foreach ($stores as $store) {
            Store::create([
                'name' => $store['name'],
                'slug' => Str::slug($store['name']),
                'description' => $store['description'],
                'website_url' => $store['website_url'],
                'is_featured' => $store['is_featured'],
                'sort_order' => $store['sort_order'],
                'is_active' => true,
            ]);
        }
    }
}
