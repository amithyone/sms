<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class TelegramSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $telegramSettings = [
            [
                'key' => 'telegram_enabled',
                'value' => 'false',
                'type' => 'boolean',
                'group' => 'notifications',
                'description' => 'Enable or disable Telegram notifications'
            ],
            [
                'key' => 'telegram_bot_token',
                'value' => '',
                'type' => 'string',
                'group' => 'notifications',
                'description' => 'Telegram bot token from @BotFather'
            ],
            [
                'key' => 'telegram_chat_id',
                'value' => '',
                'type' => 'string',
                'group' => 'notifications',
                'description' => 'Chat ID where notifications will be sent'
            ],
            [
                'key' => 'notify_new_orders',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'notifications',
                'description' => 'Send notifications for new orders'
            ],
            [
                'key' => 'notify_order_updates',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'notifications',
                'description' => 'Send notifications for order status updates'
            ],
            [
                'key' => 'notify_payments',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'notifications',
                'description' => 'Send notifications for payment confirmations'
            ],
            [
                'key' => 'notify_low_stock',
                'value' => 'false',
                'type' => 'boolean',
                'group' => 'notifications',
                'description' => 'Send notifications for low stock alerts'
            ],
            [
                'key' => 'telegram_message_template',
                'value' => '🎉 New order received!',
                'type' => 'string',
                'group' => 'notifications',
                'description' => 'Template for Telegram notification messages'
            ]
        ];

        foreach ($telegramSettings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        $this->command->info('Telegram notification settings seeded successfully!');
    }
} 