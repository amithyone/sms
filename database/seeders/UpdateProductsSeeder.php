<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVariation;
use App\Models\VariationOption;

class UpdateProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update clothing products to use proper subcategories
        $this->updateClothingProducts();
        
        // Update electronics products to use proper subcategories
        $this->updateElectronicsProducts();
        
        // Update home products to use proper subcategories
        $this->updateHomeProducts();
        
        // Add variations to appropriate products
        $this->addProductVariations();
    }

    private function updateClothingProducts()
    {
        // Get subcategories
        $tShirtsCategory = Category::where('slug', 't-shirts')->first();
        $hoodiesCategory = Category::where('slug', 'hoodies')->first();
        $accessoriesCategory = Category::where('slug', 'accessories')->first();
        $fashionCategory = Category::where('slug', 'fashion-apparel')->first();

        if ($tShirtsCategory) {
            Product::where('name', 'Custom T-Shirt')->update(['category_id' => $tShirtsCategory->id]);
        }

        if ($hoodiesCategory) {
            Product::where('name', 'Custom Hoodie')->update(['category_id' => $hoodiesCategory->id]);
        }

        if ($accessoriesCategory) {
            Product::where('name', 'Custom Cap')->update(['category_id' => $accessoriesCategory->id]);
        }

        if ($fashionCategory) {
            Product::where('name', 'Designer Handbag')->update(['category_id' => $fashionCategory->id]);
        }
    }

    private function updateElectronicsProducts()
    {
        // Get subcategories
        $smartphonesCategory = Category::where('slug', 'smartphones')->first();
        $headphonesCategory = Category::where('slug', 'headphones')->first();

        if ($smartphonesCategory) {
            Product::where('name', 'iPhone 15 Pro')->update(['category_id' => $smartphonesCategory->id]);
        }

        if ($headphonesCategory) {
            Product::where('name', 'AirPods Pro')->update(['category_id' => $headphonesCategory->id]);
        }
    }

    private function updateHomeProducts()
    {
        // Get subcategories
        $decorCategory = Category::where('slug', 'decor')->first();
        $furnitureCategory = Category::where('slug', 'furniture')->first();

        if ($decorCategory) {
            Product::where('name', 'Photo Frame')->update(['category_id' => $decorCategory->id]);
            Product::where('name', 'Picture Frame')->update(['category_id' => $decorCategory->id]);
        }

        if ($furnitureCategory) {
            Product::where('name', 'Custom Pillow')->update(['category_id' => $furnitureCategory->id]);
            Product::where('name', 'Custom Blanket')->update(['category_id' => $furnitureCategory->id]);
        }
    }

    private function addProductVariations()
    {
        // Add variations to clothing products
        $this->addClothingVariations();
        
        // Add variations to electronics products
        $this->addElectronicsVariations();
        
        // Add variations to home products
        $this->addHomeProductVariations();
    }

    private function addClothingVariations()
    {
        // T-Shirts
        $tShirts = Product::whereHas('category', function ($query) {
            $query->where('slug', 't-shirts');
        })->get();

        foreach ($tShirts as $product) {
            $this->addSizeAndColorVariations($product);
        }

        // Hoodies
        $hoodies = Product::whereHas('category', function ($query) {
            $query->where('slug', 'hoodies');
        })->get();

        foreach ($hoodies as $product) {
            $this->addSizeAndColorVariations($product);
        }

        // Caps
        $caps = Product::whereHas('category', function ($query) {
            $query->where('slug', 'accessories');
        })->where('name', 'like', '%cap%')->get();

        foreach ($caps as $product) {
            $this->addCapVariations($product);
        }
    }

    private function addElectronicsVariations()
    {
        // Smartphones
        $smartphones = Product::whereHas('category', function ($query) {
            $query->where('slug', 'smartphones');
        })->get();

        foreach ($smartphones as $product) {
            $this->addSmartphoneVariations($product);
        }

        // Headphones
        $headphones = Product::whereHas('category', function ($query) {
            $query->where('slug', 'headphones');
        })->get();

        foreach ($headphones as $product) {
            $this->addHeadphoneVariations($product);
        }
    }

    private function addHomeProductVariations()
    {
        // Pillows and Blankets
        $homeProducts = Product::whereIn('name', ['Custom Pillow', 'Custom Blanket'])->get();

        foreach ($homeProducts as $product) {
            $this->addHomeProductVariationOptions($product);
        }
    }

    private function addSizeAndColorVariations($product)
    {
        // Size variation
        $sizeVariation = ProductVariation::firstOrCreate([
            'product_id' => $product->id,
            'name' => 'Size',
        ], [
            'type' => 'select',
            'is_required' => true,
            'sort_order' => 1,
        ]);

        // Size options
        $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
        $sizeLabels = ['Extra Small', 'Small', 'Medium', 'Large', 'Extra Large', '2XL'];
        
        foreach ($sizes as $index => $size) {
            VariationOption::firstOrCreate([
                'product_variation_id' => $sizeVariation->id,
                'value' => $size,
            ], [
                'label' => $sizeLabels[$index],
                'price_adjustment' => 0,
                'stock' => rand(5, 20),
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }

        // Color variation
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
            ['value' => 'black', 'label' => 'Black'],
            ['value' => 'white', 'label' => 'White'],
            ['value' => 'navy', 'label' => 'Navy Blue'],
            ['value' => 'gray', 'label' => 'Gray'],
            ['value' => 'red', 'label' => 'Red'],
            ['value' => 'blue', 'label' => 'Blue'],
        ];

        foreach ($colors as $index => $color) {
            VariationOption::firstOrCreate([
                'product_variation_id' => $colorVariation->id,
                'value' => $color['value'],
            ], [
                'label' => $color['label'],
                'price_adjustment' => 0,
                'stock' => rand(3, 15),
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }
    }

    private function addCapVariations($product)
    {
        // Size variation for caps
        $sizeVariation = ProductVariation::firstOrCreate([
            'product_id' => $product->id,
            'name' => 'Size',
        ], [
            'type' => 'select',
            'is_required' => true,
            'sort_order' => 1,
        ]);

        // Cap size options
        $capSizes = ['S/M', 'L/XL', 'One Size'];
        
        foreach ($capSizes as $index => $size) {
            VariationOption::firstOrCreate([
                'product_variation_id' => $sizeVariation->id,
                'value' => $size,
            ], [
                'label' => $size,
                'price_adjustment' => 0,
                'stock' => rand(5, 15),
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }

        // Color variation
        $colorVariation = ProductVariation::firstOrCreate([
            'product_id' => $product->id,
            'name' => 'Color',
        ], [
            'type' => 'select',
            'is_required' => true,
            'sort_order' => 2,
        ]);

        // Cap color options
        $capColors = [
            ['value' => 'black', 'label' => 'Black'],
            ['value' => 'white', 'label' => 'White'],
            ['value' => 'navy', 'label' => 'Navy Blue'],
            ['value' => 'red', 'label' => 'Red'],
        ];

        foreach ($capColors as $index => $color) {
            VariationOption::firstOrCreate([
                'product_variation_id' => $colorVariation->id,
                'value' => $color['value'],
            ], [
                'label' => $color['label'],
                'price_adjustment' => 0,
                'stock' => rand(3, 10),
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }
    }

    private function addSmartphoneVariations($product)
    {
        // Storage variation
        $storageVariation = ProductVariation::firstOrCreate([
            'product_id' => $product->id,
            'name' => 'Storage',
        ], [
            'type' => 'select',
            'is_required' => true,
            'sort_order' => 1,
        ]);

        // Storage options
        $storageOptions = [
            ['value' => '128gb', 'label' => '128GB', 'price_adjustment' => 0],
            ['value' => '256gb', 'label' => '256GB', 'price_adjustment' => 50000],
            ['value' => '512gb', 'label' => '512GB', 'price_adjustment' => 100000],
        ];

        foreach ($storageOptions as $index => $storage) {
            VariationOption::firstOrCreate([
                'product_variation_id' => $storageVariation->id,
                'value' => $storage['value'],
            ], [
                'label' => $storage['label'],
                'price_adjustment' => $storage['price_adjustment'],
                'stock' => rand(2, 8),
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }

        // Color variation
        $colorVariation = ProductVariation::firstOrCreate([
            'product_id' => $product->id,
            'name' => 'Color',
        ], [
            'type' => 'select',
            'is_required' => true,
            'sort_order' => 2,
        ]);

        // Smartphone color options
        $phoneColors = [
            ['value' => 'black', 'label' => 'Black'],
            ['value' => 'white', 'label' => 'White'],
            ['value' => 'gold', 'label' => 'Gold'],
            ['value' => 'blue', 'label' => 'Blue'],
        ];

        foreach ($phoneColors as $index => $color) {
            VariationOption::firstOrCreate([
                'product_variation_id' => $colorVariation->id,
                'value' => $color['value'],
            ], [
                'label' => $color['label'],
                'price_adjustment' => 0,
                'stock' => rand(1, 5),
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }
    }

    private function addHeadphoneVariations($product)
    {
        // Color variation
        $colorVariation = ProductVariation::firstOrCreate([
            'product_id' => $product->id,
            'name' => 'Color',
        ], [
            'type' => 'select',
            'is_required' => true,
            'sort_order' => 1,
        ]);

        // Headphone color options
        $headphoneColors = [
            ['value' => 'white', 'label' => 'White'],
            ['value' => 'black', 'label' => 'Black'],
            ['value' => 'blue', 'label' => 'Blue'],
        ];

        foreach ($headphoneColors as $index => $color) {
            VariationOption::firstOrCreate([
                'product_variation_id' => $colorVariation->id,
                'value' => $color['value'],
            ], [
                'label' => $color['label'],
                'price_adjustment' => 0,
                'stock' => rand(2, 8),
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }
    }

    private function addHomeProductVariationOptions($product)
    {
        // Size variation for home products
        $sizeVariation = ProductVariation::firstOrCreate([
            'product_id' => $product->id,
            'name' => 'Size',
        ], [
            'type' => 'select',
            'is_required' => true,
            'sort_order' => 1,
        ]);

        if (str_contains(strtolower($product->name), 'pillow')) {
            // Pillow sizes
            $pillowSizes = [
                ['value' => 'small', 'label' => 'Small (16" x 16")', 'price_adjustment' => 0],
                ['value' => 'medium', 'label' => 'Medium (18" x 18")', 'price_adjustment' => 2000],
                ['value' => 'large', 'label' => 'Large (20" x 20")', 'price_adjustment' => 4000],
            ];

            foreach ($pillowSizes as $index => $size) {
                VariationOption::firstOrCreate([
                    'product_variation_id' => $sizeVariation->id,
                    'value' => $size['value'],
                ], [
                    'label' => $size['label'],
                    'price_adjustment' => $size['price_adjustment'],
                    'stock' => rand(3, 12),
                    'is_active' => true,
                    'sort_order' => $index + 1,
                ]);
            }
        } else {
            // Blanket sizes
            $blanketSizes = [
                ['value' => 'throw', 'label' => 'Throw (50" x 60")', 'price_adjustment' => 0],
                ['value' => 'twin', 'label' => 'Twin (66" x 90")', 'price_adjustment' => 5000],
                ['value' => 'queen', 'label' => 'Queen (90" x 90")', 'price_adjustment' => 10000],
            ];

            foreach ($blanketSizes as $index => $size) {
                VariationOption::firstOrCreate([
                    'product_variation_id' => $sizeVariation->id,
                    'value' => $size['value'],
                ], [
                    'label' => $size['label'],
                    'price_adjustment' => $size['price_adjustment'],
                    'stock' => rand(2, 8),
                    'is_active' => true,
                    'sort_order' => $index + 1,
                ]);
            }
        }

        // Color variation
        $colorVariation = ProductVariation::firstOrCreate([
            'product_id' => $product->id,
            'name' => 'Color',
        ], [
            'type' => 'select',
            'is_required' => true,
            'sort_order' => 2,
        ]);

        // Home product color options
        $homeColors = [
            ['value' => 'white', 'label' => 'White'],
            ['value' => 'gray', 'label' => 'Gray'],
            ['value' => 'navy', 'label' => 'Navy Blue'],
            ['value' => 'beige', 'label' => 'Beige'],
        ];

        foreach ($homeColors as $index => $color) {
            VariationOption::firstOrCreate([
                'product_variation_id' => $colorVariation->id,
                'value' => $color['value'],
            ], [
                'label' => $color['label'],
                'price_adjustment' => 0,
                'stock' => rand(2, 10),
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }
    }
}
