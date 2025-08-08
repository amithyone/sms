<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'exchange_rate',
                'value' => '1600',
                'type' => 'number',
                'group' => 'pricing',
                'description' => 'Exchange rate from USD to NGN (Naira)'
            ],
            [
                'key' => 'markup_percentage',
                'value' => '0',
                'type' => 'number',
                'group' => 'pricing',
                'description' => 'Percentage markup to add to product prices'
            ],
            [
                'key' => 'shipping_cost_usd',
                'value' => '5.99',
                'type' => 'number',
                'group' => 'pricing',
                'description' => 'Standard shipping cost in USD'
            ],
            [
                'key' => 'tax_percentage',
                'value' => '8',
                'type' => 'number',
                'group' => 'pricing',
                'description' => 'Tax percentage applied to orders'
            ],
            [
                'key' => 'auto_update_exchange_rate',
                'value' => 'false',
                'type' => 'boolean',
                'group' => 'pricing',
                'description' => 'Automatically update exchange rate from external API'
            ],
            [
                'key' => 'exchange_rate_api_url',
                'value' => 'https://api.exchangerate-api.com/v4/latest/USD',
                'type' => 'string',
                'group' => 'pricing',
                'description' => 'API URL for fetching current exchange rates'
            ],
            [
                'key' => 'exchange_rate_update_frequency',
                'value' => 'daily',
                'type' => 'string',
                'group' => 'pricing',
                'description' => 'How often to update exchange rate (daily, weekly, monthly)'
            ]
        ];

        foreach ($settings as $setting) {
            Setting::setValue(
                $setting['key'],
                $setting['value'],
                $setting['type'],
                $setting['group'],
                $setting['description']
            );
        }
    }
} 