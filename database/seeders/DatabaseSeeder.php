<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Call our custom seeders
        $this->call([
            CategorySeeder::class,
            StoreSeeder::class,
            ProductSeeder::class,
            CustomizeProductSeeder::class,
            CustomizeCategorySeeder::class,
            SubcategorySeeder::class,
            CategoryVariationTypesSeeder::class,
            ProductVariationSeeder::class,
            WearableVariationsSeeder::class,
            UpdateProductsSeeder::class,
            SettingsSeeder::class,
            TelegramSettingsSeeder::class,
            WristwatchVariationSeeder::class,
            EnabledCountriesSeeder::class,
            TestUserSeeder::class, // Add test user for payment testing
        ]);
    }
}
