<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Address;
use App\Models\Wallet;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test user
        $user = User::firstOrCreate(
            ['email' => 'test2@example.com'],
            [
                'name' => 'Test User',
                'email' => 'test2@example.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'admin' => false
            ]
        );

        // Create wallet for the user
        $wallet = Wallet::firstOrCreate(
            ['user_id' => $user->id],
            [
                'user_id' => $user->id,
                'balance' => 100000, // ₦100,000 for testing
                'currency' => 'NGN'
            ]
        );

        // Create US address for the user
        $address = Address::firstOrCreate(
            [
                'user_id' => $user->id,
                'name' => 'Test User'
            ],
            [
                'user_id' => $user->id,
                'name' => 'Test User',
                'phone' => '+1234567890',
                'address_line_1' => '123 Test Street',
                'address_line_2' => 'Apt 4B',
                'city' => 'New York',
                'state' => 'NY',
                'postal_code' => '10001',
                'country' => 'US',
                'label' => 'Home',
                'is_default' => true
            ]
        );

        // Create international address for testing
        $internationalAddress = Address::firstOrCreate(
            [
                'user_id' => $user->id,
                'name' => 'Test User International'
            ],
            [
                'user_id' => $user->id,
                'name' => 'Test User International',
                'phone' => '+44123456789',
                'address_line_1' => '456 International Street',
                'address_line_2' => 'Suite 10',
                'city' => 'London',
                'state' => 'England',
                'postal_code' => 'SW1A 1AA',
                'country' => 'GB',
                'label' => 'International',
                'is_default' => false
            ]
        );
    }
}
