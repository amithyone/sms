<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVariation;
use App\Models\VariationOption;
use App\Models\Store;
use Illuminate\Support\Str;

class WristwatchVariationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First, let's find or create a wristwatch category
        $wristwatchCategory = Category::firstOrCreate(
            ['slug' => 'wristwatches'],
            [
                'name' => 'Wristwatches',
                'description' => 'Elegant and stylish wristwatches for all occasions',
                'icon' => '⌚',
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 1,
            ]
        );

        // Find or create a store
        $store = Store::firstOrCreate(
            ['name' => 'Luxury Timepieces'],
            [
                'slug' => 'luxury-timepieces',
                'description' => 'Premium wristwatches and accessories',
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        // Create the wristwatch product
        $wristwatch = Product::firstOrCreate(
            ['slug' => 'premium-classic-wristwatch'],
            [
                'name' => 'Premium Classic Wristwatch',
                'description' => 'A timeless classic wristwatch featuring premium materials and precise movement. Perfect for both casual and formal occasions. Features include water resistance, scratch-resistant crystal, and a comfortable leather strap.',
                'price' => 89.99, // Base price in USD
                'sale_price' => null,
                'category_id' => $wristwatchCategory->id,
                'store_id' => $store->id,
                'is_active' => true,
                'is_featured' => true,
                'allow_customization' => true,
                'stock' => 50,
                'sku' => 'WC-001',
                'image' => null, // Will be set by variations
                'gallery' => [],
            ]
        );

        // Create the Color variation
        $colorVariation = ProductVariation::firstOrCreate(
            [
                'product_id' => $wristwatch->id,
                'name' => 'Color'
            ],
            [
                'type' => 'radio',
                'is_required' => true,
                'sort_order' => 1,
            ]
        );

        // Create color options with different prices and images
        $colorOptions = [
            [
                'value' => 'Black',
                'label' => 'Classic Black',
                'price_adjustment' => 0.00, // Base price
                'stock' => 20,
                'sku' => 'WC-001-BLK',
                'image' => null, // You can add actual image paths here
            ],
            [
                'value' => 'Silver',
                'label' => 'Elegant Silver',
                'price_adjustment' => 15.00, // +$15 more expensive
                'stock' => 15,
                'sku' => 'WC-001-SLV',
                'image' => null,
            ],
            [
                'value' => 'Gold',
                'label' => 'Premium Gold',
                'price_adjustment' => 25.00, // +$25 more expensive
                'stock' => 15,
                'sku' => 'WC-001-GLD',
                'image' => null,
            ],
        ];

        foreach ($colorOptions as $option) {
            VariationOption::firstOrCreate(
                [
                    'product_variation_id' => $colorVariation->id,
                    'value' => $option['value']
                ],
                [
                    'label' => $option['label'],
                    'price_adjustment' => $option['price_adjustment'],
                    'stock' => $option['stock'],
                    'sku' => $option['sku'],
                    'image' => $option['image'],
                    'is_active' => true,
                    'sort_order' => 1,
                ]
            );
        }

        // Create a Size variation (optional)
        $sizeVariation = ProductVariation::firstOrCreate(
            [
                'product_id' => $wristwatch->id,
                'name' => 'Size'
            ],
            [
                'type' => 'select',
                'is_required' => false,
                'sort_order' => 2,
            ]
        );

        // Create size options
        $sizeOptions = [
            [
                'value' => '38mm',
                'label' => '38mm (Small)',
                'price_adjustment' => -5.00, // $5 cheaper
                'stock' => 10,
                'sku' => 'WC-001-38',
                'image' => null,
            ],
            [
                'value' => '42mm',
                'label' => '42mm (Standard)',
                'price_adjustment' => 0.00, // Base price
                'stock' => 25,
                'sku' => 'WC-001-42',
                'image' => null,
            ],
            [
                'value' => '45mm',
                'label' => '45mm (Large)',
                'price_adjustment' => 8.00, // $8 more expensive
                'stock' => 15,
                'sku' => 'WC-001-45',
                'image' => null,
            ],
        ];

        foreach ($sizeOptions as $option) {
            VariationOption::firstOrCreate(
                [
                    'product_variation_id' => $sizeVariation->id,
                    'value' => $option['value']
                ],
                [
                    'label' => $option['label'],
                    'price_adjustment' => $option['price_adjustment'],
                    'stock' => $option['stock'],
                    'sku' => $option['sku'],
                    'image' => $option['image'],
                    'is_active' => true,
                    'sort_order' => 1,
                ]
            );
        }

        // Seeder completed successfully
    }
} 