<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class FeaturedCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Set only 3 popular categories as featured (limit)
        $featuredCategories = [
            'jewelry',
            'frames', 
            'wears'
        ];

        foreach ($featuredCategories as $slug) {
            $category = Category::where('slug', $slug)->first();
            if ($category) {
                $category->update(['is_featured' => true]);
                $this->command->info("Set {$category->name} as featured");
            }
        }

        $this->command->info('Featured categories updated successfully!');
    }
}
