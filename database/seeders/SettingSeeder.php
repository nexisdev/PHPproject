<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'project_name' => 'Demo',
            'support_email' => 'info@zilab.co',
            'notification_email' => 'demo-s1@bitcord.io',
            'is_kyc_enabled' => true,
            'presale_contract_address' => '0xB4f790CeF288A718a0Eef7124E9eB2C28E3acCDe',
            'token_contract_address' => '0x0756dd20AC717691094B225fAB29A2B3F3c33bF9',
            'token_decimals' => 18,
            'facebook' => 'http://bitcord.io/',
            'discord' => 'http://bitcord.io/',
            'github' => 'http://bitcord.io/',
            'slack' => 'http://bitcord.io/',
            'reddit' => 'http://bitcord.io/',
            'instagram' => 'http://bitcord.io/',
            'twitter' => 'http://bitcord.io/',
            'youtube' => 'http://bitcord.io/',
            'website' => 'http://bitcord.io/',
            'telegram_group' => 'http://bitcord.io/',
            'telegram_channel' => 'http://bitcord.io/',
            'medium' => 'http://bitcord.io/',
            'linkedin' => 'http://bitcord.io/',
        ]);
    }
}
