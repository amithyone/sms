<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\VariationOption;

class WearableVariationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get jewelry products
        $jewelryProducts = Product::whereHas('category', function ($query) {
            $query->where('slug', 'jewelry');
        })->get();

        foreach ($jewelryProducts as $product) {
            $productName = strtolower($product->name);
            
            // Add size variations based on product type
            if (str_contains($productName, 'ring') || str_contains($productName, 'charm')) {
                $this->addRingSizeVariation($product);
            } elseif (str_contains($productName, 'bracelet')) {
                $this->addBraceletSizeVariation($product);
            } elseif (str_contains($productName, 'necklace')) {
                $this->addNecklaceSizeVariation($product);
            } else {
                // Default jewelry size variation
                $this->addStandardSizeVariation($product);
            }

            // Add material variation for jewelry
            $this->addMaterialVariation($product);
        }

        // Get clothing products and add standard sizes
        $clothingProducts = Product::whereHas('category', function ($query) {
            $query->whereIn('slug', ['t-shirts', 'hoodies', 'dresses', 'jeans', 'caps']);
        })->get();

        foreach ($clothingProducts as $product) {
            $this->addStandardSizeVariation($product);
            $this->addColorVariation($product);
        }

        // Get shoe products and add shoe sizes
        $shoeProducts = Product::whereHas('category', function ($query) {
            $query->whereIn('slug', ['shoes', 'sneakers', 'boots']);
        })->get();

        foreach ($shoeProducts as $product) {
            $this->addShoeSizeVariation($product);
            $this->addColorVariation($product);
        }
    }

    /**
     * Add ring size variation with both US and EU sizes
     */
    private function addRingSizeVariation(Product $product): void
    {
        $sizeVariation = ProductVariation::firstOrCreate([
            'product_id' => $product->id,
            'name' => 'Ring Size',
        ], [
            'type' => 'select',
            'is_required' => true,
            'sort_order' => 1,
        ]);

        // Ring sizes with both US and EU measurements
        $ringSizes = [
            ['value' => '3', 'label' => 'US 3 (14.1mm)', 'price_adjustment' => 0],
            ['value' => '3.5', 'label' => 'US 3.5 (14.5mm)', 'price_adjustment' => 0],
            ['value' => '4', 'label' => 'US 4 (14.9mm)', 'price_adjustment' => 0],
            ['value' => '4.5', 'label' => 'US 4.5 (15.3mm)', 'price_adjustment' => 0],
            ['value' => '5', 'label' => 'US 5 (15.7mm)', 'price_adjustment' => 0],
            ['value' => '5.5', 'label' => 'US 5.5 (16.1mm)', 'price_adjustment' => 0],
            ['value' => '6', 'label' => 'US 6 (16.5mm)', 'price_adjustment' => 0],
            ['value' => '6.5', 'label' => 'US 6.5 (16.9mm)', 'price_adjustment' => 0],
            ['value' => '7', 'label' => 'US 7 (17.3mm)', 'price_adjustment' => 0],
            ['value' => '7.5', 'label' => 'US 7.5 (17.7mm)', 'price_adjustment' => 0],
            ['value' => '8', 'label' => 'US 8 (18.1mm)', 'price_adjustment' => 0],
            ['value' => '8.5', 'label' => 'US 8.5 (18.5mm)', 'price_adjustment' => 0],
            ['value' => '9', 'label' => 'US 9 (18.9mm)', 'price_adjustment' => 0],
            ['value' => '9.5', 'label' => 'US 9.5 (19.3mm)', 'price_adjustment' => 0],
            ['value' => '10', 'label' => 'US 10 (19.7mm)', 'price_adjustment' => 0],
            ['value' => '10.5', 'label' => 'US 10.5 (20.1mm)', 'price_adjustment' => 0],
            ['value' => '11', 'label' => 'US 11 (20.5mm)', 'price_adjustment' => 0],
            ['value' => '11.5', 'label' => 'US 11.5 (20.9mm)', 'price_adjustment' => 0],
            ['value' => '12', 'label' => 'US 12 (21.3mm)', 'price_adjustment' => 0],
        ];

        foreach ($ringSizes as $index => $size) {
            VariationOption::firstOrCreate([
                'product_variation_id' => $sizeVariation->id,
                'value' => $size['value'],
            ], [
                'label' => $size['label'],
                'price_adjustment' => $size['price_adjustment'],
                'stock' => rand(2, 8),
                'sku' => $product->sku ? $product->sku . '-R' . $size['value'] : null,
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }
    }

    /**
     * Add bracelet size variation
     */
    private function addBraceletSizeVariation(Product $product): void
    {
        $sizeVariation = ProductVariation::firstOrCreate([
            'product_id' => $product->id,
            'name' => 'Bracelet Size',
        ], [
            'type' => 'select',
            'is_required' => true,
            'sort_order' => 1,
        ]);

        // Bracelet sizes with measurements
        $braceletSizes = [
            ['value' => 'xs', 'label' => 'XS (6.5" / 16.5cm)', 'price_adjustment' => 0],
            ['value' => 's', 'label' => 'S (7" / 17.8cm)', 'price_adjustment' => 0],
            ['value' => 'm', 'label' => 'M (7.5" / 19cm)', 'price_adjustment' => 0],
            ['value' => 'l', 'label' => 'L (8" / 20.3cm)', 'price_adjustment' => 0],
            ['value' => 'xl', 'label' => 'XL (8.5" / 21.6cm)', 'price_adjustment' => 0],
            ['value' => 'xxl', 'label' => 'XXL (9" / 22.9cm)', 'price_adjustment' => 0],
        ];

        foreach ($braceletSizes as $index => $size) {
            VariationOption::firstOrCreate([
                'product_variation_id' => $sizeVariation->id,
                'value' => $size['value'],
            ], [
                'label' => $size['label'],
                'price_adjustment' => $size['price_adjustment'],
                'stock' => rand(3, 10),
                'sku' => $product->sku ? $product->sku . '-B' . strtoupper($size['value']) : null,
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }
    }

    /**
     * Add necklace size variation
     */
    private function addNecklaceSizeVariation(Product $product): void
    {
        $sizeVariation = ProductVariation::firstOrCreate([
            'product_id' => $product->id,
            'name' => 'Necklace Length',
        ], [
            'type' => 'select',
            'is_required' => true,
            'sort_order' => 1,
        ]);

        // Necklace lengths with measurements
        $necklaceSizes = [
            ['value' => '16', 'label' => '16" (40.6cm) - Choker', 'price_adjustment' => 0],
            ['value' => '18', 'label' => '18" (45.7cm) - Princess', 'price_adjustment' => 0],
            ['value' => '20', 'label' => '20" (50.8cm) - Matinee', 'price_adjustment' => 0],
            ['value' => '22', 'label' => '22" (55.9cm) - Opera', 'price_adjustment' => 0],
            ['value' => '24', 'label' => '24" (61cm) - Rope', 'price_adjustment' => 0],
        ];

        foreach ($necklaceSizes as $index => $size) {
            VariationOption::firstOrCreate([
                'product_variation_id' => $sizeVariation->id,
                'value' => $size['value'],
            ], [
                'label' => $size['label'],
                'price_adjustment' => $size['price_adjustment'],
                'stock' => rand(2, 8),
                'sku' => $product->sku ? $product->sku . '-N' . $size['value'] : null,
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }
    }

    /**
     * Add standard size variation (XS, S, M, L, XL, XXL)
     */
    private function addStandardSizeVariation(Product $product): void
    {
        $sizeVariation = ProductVariation::firstOrCreate([
            'product_id' => $product->id,
            'name' => 'Size',
        ], [
            'type' => 'select',
            'is_required' => true,
            'sort_order' => 1,
        ]);

        // Standard sizes with measurements
        $standardSizes = [
            ['value' => 'xs', 'label' => 'XS (Extra Small)', 'price_adjustment' => 0],
            ['value' => 's', 'label' => 'S (Small)', 'price_adjustment' => 0],
            ['value' => 'm', 'label' => 'M (Medium)', 'price_adjustment' => 0],
            ['value' => 'l', 'label' => 'L (Large)', 'price_adjustment' => 0],
            ['value' => 'xl', 'label' => 'XL (Extra Large)', 'price_adjustment' => 0],
            ['value' => 'xxl', 'label' => 'XXL (2XL)', 'price_adjustment' => 0],
        ];

        foreach ($standardSizes as $index => $size) {
            VariationOption::firstOrCreate([
                'product_variation_id' => $sizeVariation->id,
                'value' => $size['value'],
            ], [
                'label' => $size['label'],
                'price_adjustment' => $size['price_adjustment'],
                'stock' => rand(5, 20),
                'sku' => $product->sku ? $product->sku . '-' . strtoupper($size['value']) : null,
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }
    }

    /**
     * Add shoe size variation
     */
    private function addShoeSizeVariation(Product $product): void
    {
        $sizeVariation = ProductVariation::firstOrCreate([
            'product_id' => $product->id,
            'name' => 'Shoe Size',
        ], [
            'type' => 'select',
            'is_required' => true,
            'sort_order' => 1,
        ]);

        // US shoe sizes
        $shoeSizes = [
            ['value' => '6', 'label' => 'US 6', 'price_adjustment' => 0],
            ['value' => '7', 'label' => 'US 7', 'price_adjustment' => 0],
            ['value' => '8', 'label' => 'US 8', 'price_adjustment' => 0],
            ['value' => '9', 'label' => 'US 9', 'price_adjustment' => 0],
            ['value' => '10', 'label' => 'US 10', 'price_adjustment' => 0],
            ['value' => '11', 'label' => 'US 11', 'price_adjustment' => 0],
            ['value' => '12', 'label' => 'US 12', 'price_adjustment' => 0],
        ];

        foreach ($shoeSizes as $index => $size) {
            VariationOption::firstOrCreate([
                'product_variation_id' => $sizeVariation->id,
                'value' => $size['value'],
            ], [
                'label' => $size['label'],
                'price_adjustment' => $size['price_adjustment'],
                'stock' => rand(3, 12),
                'sku' => $product->sku ? $product->sku . '-S' . $size['value'] : null,
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }
    }

    /**
     * Add material variation for jewelry
     */
    private function addMaterialVariation(Product $product): void
    {
        $materialVariation = ProductVariation::firstOrCreate([
            'product_id' => $product->id,
            'name' => 'Material',
        ], [
            'type' => 'select',
            'is_required' => true,
            'sort_order' => 2,
        ]);

        // Jewelry materials
        $materials = [
            ['value' => 'sterling_silver', 'label' => 'Sterling Silver', 'price_adjustment' => 0],
            ['value' => 'gold_plated', 'label' => 'Gold Plated', 'price_adjustment' => 5000],
            ['value' => 'rose_gold', 'label' => 'Rose Gold', 'price_adjustment' => 3000],
            ['value' => 'stainless_steel', 'label' => 'Stainless Steel', 'price_adjustment' => -2000],
        ];

        foreach ($materials as $index => $material) {
            VariationOption::firstOrCreate([
                'product_variation_id' => $materialVariation->id,
                'value' => $material['value'],
            ], [
                'label' => $material['label'],
                'price_adjustment' => $material['price_adjustment'],
                'stock' => rand(5, 15),
                'sku' => $product->sku ? $product->sku . '-' . strtoupper(str_replace('_', '', $material['value'])) : null,
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }
    }

    /**
     * Add color variation
     */
    private function addColorVariation(Product $product): void
    {
        $colorVariation = ProductVariation::firstOrCreate([
            'product_id' => $product->id,
            'name' => 'Color',
        ], [
            'type' => 'select',
            'is_required' => true,
            'sort_order' => 2,
        ]);

        // Color options
        $colors = [
            ['value' => 'black', 'label' => 'Black', 'price_adjustment' => 0],
            ['value' => 'white', 'label' => 'White', 'price_adjustment' => 0],
            ['value' => 'navy', 'label' => 'Navy Blue', 'price_adjustment' => 0],
            ['value' => 'gray', 'label' => 'Gray', 'price_adjustment' => 0],
            ['value' => 'red', 'label' => 'Red', 'price_adjustment' => 0],
            ['value' => 'blue', 'label' => 'Blue', 'price_adjustment' => 0],
        ];

        foreach ($colors as $index => $color) {
            VariationOption::firstOrCreate([
                'product_variation_id' => $colorVariation->id,
                'value' => $color['value'],
            ], [
                'label' => $color['label'],
                'price_adjustment' => $color['price_adjustment'],
                'stock' => rand(5, 20),
                'sku' => $product->sku ? $product->sku . '-' . strtoupper($color['value']) : null,
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }
    }
} 