<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class EnabledCountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $enabledCountries = [
            'US' => 'United States',
            'CA' => 'Canada',
            'GB' => 'United Kingdom',
            'AU' => 'Australia',
            'DE' => 'Germany',
            'FR' => 'France',
            'IT' => 'Italy',
            'ES' => 'Spain',
            'NL' => 'Netherlands',
            'BE' => 'Belgium',
            'CH' => 'Switzerland',
            'AT' => 'Austria',
            'SE' => 'Sweden',
            'NO' => 'Norway',
            'DK' => 'Denmark',
            'FI' => 'Finland',
            'IE' => 'Ireland',
            'NZ' => 'New Zealand',
            'JP' => 'Japan',
            'SG' => 'Singapore',
            'HK' => 'Hong Kong',
            'KR' => 'South Korea',
            'AE' => 'United Arab Emirates',
            'SA' => 'Saudi Arabia',
            'IL' => 'Israel',
            'BR' => 'Brazil',
            'MX' => 'Mexico',
            'AR' => 'Argentina',
            'CL' => 'Chile',
            'CO' => 'Colombia',
            'PE' => 'Peru',
            'ZA' => 'South Africa',
            'EG' => 'Egypt',
            'MA' => 'Morocco',
            'NG' => 'Nigeria',
            'KE' => 'Kenya',
            'GH' => 'Ghana',
            'UG' => 'Uganda',
            'TZ' => 'Tanzania',
            'ET' => 'Ethiopia',
            'IN' => 'India',
            'PK' => 'Pakistan',
            'BD' => 'Bangladesh',
            'LK' => 'Sri Lanka',
            'NP' => 'Nepal',
            'TH' => 'Thailand',
            'VN' => 'Vietnam',
            'MY' => 'Malaysia',
            'ID' => 'Indonesia',
            'PH' => 'Philippines'
        ];

        Setting::updateOrCreate(
            ['key' => 'enabled_countries'],
            [
                'value' => json_encode($enabledCountries),
                'type' => 'json',
                'group' => 'shipping',
                'description' => 'List of countries enabled for international shipping'
            ]
        );
    }
}
