<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\VariationOption;

class ProductVariationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get clothing products (T-Shirts, Hoodies, etc.)
        $clothingProducts = Product::whereHas('category', function ($query) {
            $query->whereIn('slug', ['t-shirts', 'hoodies', 'dresses', 'jeans']);
        })->get();

        foreach ($clothingProducts as $product) {
            // Add Size variation
            $sizeVariation = ProductVariation::create([
                'product_id' => $product->id,
                'name' => 'Size',
                'type' => 'select',
                'is_required' => true,
                'sort_order' => 1,
            ]);

            // Add size options
            $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
            $sizeLabels = ['Extra Small', 'Small', 'Medium', 'Large', 'Extra Large', '2XL'];
            
            foreach ($sizes as $index => $size) {
                VariationOption::create([
                    'product_variation_id' => $sizeVariation->id,
                    'value' => $size,
                    'label' => $sizeLabels[$index],
                    'price_adjustment' => 0, // No price adjustment for sizes
                    'stock' => rand(5, 20),
                    'sku' => $product->sku ? $product->sku . '-' . $size : null,
                    'is_active' => true,
                    'sort_order' => $index + 1,
                ]);
            }

            // Add Color variation
            $colorVariation = ProductVariation::create([
                'product_id' => $product->id,
                'name' => 'Color',
                'type' => 'select',
                'is_required' => true,
                'sort_order' => 2,
            ]);

            // Add color options
            $colors = [
                ['value' => 'black', 'label' => 'Black'],
                ['value' => 'white', 'label' => 'White'],
                ['value' => 'navy', 'label' => 'Navy Blue'],
                ['value' => 'gray', 'label' => 'Gray'],
                ['value' => 'red', 'label' => 'Red'],
                ['value' => 'blue', 'label' => 'Blue'],
            ];

            foreach ($colors as $index => $color) {
                VariationOption::create([
                    'product_variation_id' => $colorVariation->id,
                    'value' => $color['value'],
                    'label' => $color['label'],
                    'price_adjustment' => 0, // No price adjustment for colors
                    'stock' => rand(3, 15),
                    'sku' => $product->sku ? $product->sku . '-' . $color['value'] : null,
                    'is_active' => true,
                    'sort_order' => $index + 1,
                ]);
            }
        }

        // Get shoe products
        $shoeProducts = Product::whereHas('category', function ($query) {
            $query->where('slug', 'shoes');
        })->get();

        foreach ($shoeProducts as $product) {
            // Add Size variation for shoes
            $sizeVariation = ProductVariation::create([
                'product_id' => $product->id,
                'name' => 'Size',
                'type' => 'select',
                'is_required' => true,
                'sort_order' => 1,
            ]);

            // Add shoe size options
            $shoeSizes = ['6', '7', '8', '9', '10', '11', '12'];
            
            foreach ($shoeSizes as $index => $size) {
                VariationOption::create([
                    'product_variation_id' => $sizeVariation->id,
                    'value' => $size,
                    'label' => 'US Size ' . $size,
                    'price_adjustment' => 0,
                    'stock' => rand(3, 12),
                    'sku' => $product->sku ? $product->sku . '-' . $size : null,
                    'is_active' => true,
                    'sort_order' => $index + 1,
                ]);
            }

            // Add Color variation for shoes
            $colorVariation = ProductVariation::create([
                'product_id' => $product->id,
                'name' => 'Color',
                'type' => 'select',
                'is_required' => true,
                'sort_order' => 2,
            ]);

            // Add shoe color options
            $shoeColors = [
                ['value' => 'black', 'label' => 'Black'],
                ['value' => 'white', 'label' => 'White'],
                ['value' => 'brown', 'label' => 'Brown'],
                ['value' => 'navy', 'label' => 'Navy Blue'],
            ];

            foreach ($shoeColors as $index => $color) {
                VariationOption::create([
                    'product_variation_id' => $colorVariation->id,
                    'value' => $color['value'],
                    'label' => $color['label'],
                    'price_adjustment' => 0,
                    'stock' => rand(2, 8),
                    'sku' => $product->sku ? $product->sku . '-' . $color['value'] : null,
                    'is_active' => true,
                    'sort_order' => $index + 1,
                ]);
            }
        }

        // Get electronics products
        $electronicsProducts = Product::whereHas('category', function ($query) {
            $query->whereIn('slug', ['smartphones', 'laptops', 'headphones', 'smart-watches']);
        })->get();

        foreach ($electronicsProducts as $product) {
            // Add Storage variation for electronics
            $storageVariation = ProductVariation::create([
                'product_id' => $product->id,
                'name' => 'Storage',
                'type' => 'select',
                'is_required' => true,
                'sort_order' => 1,
            ]);

            // Add storage options
            $storageOptions = [
                ['value' => '64gb', 'label' => '64GB', 'price_adjustment' => 0],
                ['value' => '128gb', 'label' => '128GB', 'price_adjustment' => 50],
                ['value' => '256gb', 'label' => '256GB', 'price_adjustment' => 100],
                ['value' => '512gb', 'label' => '512GB', 'price_adjustment' => 200],
            ];

            foreach ($storageOptions as $index => $storage) {
                VariationOption::create([
                    'product_variation_id' => $storageVariation->id,
                    'value' => $storage['value'],
                    'label' => $storage['label'],
                    'price_adjustment' => $storage['price_adjustment'],
                    'stock' => rand(2, 10),
                    'sku' => $product->sku ? $product->sku . '-' . $storage['value'] : null,
                    'is_active' => true,
                    'sort_order' => $index + 1,
                ]);
            }

            // Add Color variation for electronics
            $colorVariation = ProductVariation::create([
                'product_id' => $product->id,
                'name' => 'Color',
                'type' => 'select',
                'is_required' => true,
                'sort_order' => 2,
            ]);

            // Add electronics color options
            $electronicsColors = [
                ['value' => 'black', 'label' => 'Black'],
                ['value' => 'white', 'label' => 'White'],
                ['value' => 'silver', 'label' => 'Silver'],
                ['value' => 'gold', 'label' => 'Gold'],
            ];

            foreach ($electronicsColors as $index => $color) {
                VariationOption::create([
                    'product_variation_id' => $colorVariation->id,
                    'value' => $color['value'],
                    'label' => $color['label'],
                    'price_adjustment' => 0,
                    'stock' => rand(1, 5),
                    'sku' => $product->sku ? $product->sku . '-' . $color['value'] : null,
                    'is_active' => true,
                    'sort_order' => $index + 1,
                ]);
            }
        }
    }
}
