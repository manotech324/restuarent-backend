<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;
use App\Models\Admin\Branch;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        /**
         * 🔹 GLOBAL SETTINGS (branch_id = NULL)
         */
        $globalSettings = [
            'app_name'            => 'My Restaurant App',
            'currency'            => 'PKR',
            'tax_percent'         => '16',
            'delivery_fee'        => '150',
            'min_order_amount'    => '500',
            'support_phone'       => '+92-300-0000000',
            'support_email'       => 'support@restaurant.com',
            'is_delivery_enabled' => '1',
            'is_pickup_enabled'   => '1',
        ];

        foreach ($globalSettings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key, 'branch_id' => null],
                ['value' => $value]
            );
        }

        /**
         * 🔹 BRANCH-SPECIFIC SETTINGS
         */
        $branches = Branch::all();

        foreach ($branches as $branch) {
            $branchSettings = [
                'opening_time'       => '10:00',
                'closing_time'       => '23:00',
                'branch_phone'       => $branch->phone ?? '+92-300-0000000',
                'branch_location'    => $branch->location ?? 'Not set',
                'delivery_radius_km' => '5',
                'is_branch_active'   => '1',
            ];

            foreach ($branchSettings as $key => $value) {
                Setting::updateOrCreate(
                    ['key' => $key, 'branch_id' => $branch->id],
                    ['value' => $value]
                );
            }
        }
    }
}
