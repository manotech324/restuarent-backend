<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingsService
{
    /**
     * Get all settings (Global + Branch)
     * Falls back to .env values if missing
     */
    public static function getAll($branchId = null)
    {
        $cacheKey = 'settings_' . ($branchId ?? 'global');

        return Cache::remember($cacheKey, 3600, function () use ($branchId) {

            // 1️⃣ Global settings from DB
            $global = Setting::whereNull('branch_id')->pluck('value', 'key');

            // 2️⃣ Branch-specific overrides
            if ($branchId) {
                $branch = Setting::where('branch_id', $branchId)->pluck('value', 'key');
                $global = $global->merge($branch);
            }

            // 3️⃣ Fallback to .env defaults if missing
            $defaults = [
                'app_name'             => env('APP_NAME', 'Laravel'),
                'currency'             => env('DEFAULT_CURRENCY', 'PKR'),
                'tax_percent'          => env('DEFAULT_TAX_PERCENT', 16),
                'delivery_fee'         => env('DEFAULT_DELIVERY_FEE', 150),
                'min_order_amount'     => env('DEFAULT_MIN_ORDER_AMOUNT', 500),
                'support_email'        => env('SUPPORT_EMAIL', 'support@restaurant.com'),
                'support_phone'        => env('SUPPORT_PHONE', '+92-300-0000000'),
                'is_delivery_enabled'  => env('IS_DELIVERY_ENABLED', '1'),
                'is_pickup_enabled'    => env('IS_PICKUP_ENABLED', '1'),
            ];

            // Merge defaults for any missing keys
            foreach ($defaults as $key => $value) {
                if (!$global->has($key)) {
                    $global->put($key, $value);
                }
            }

            return $global;
        });
    }

    /**
     * Clear cache helper
     */
    public static function clearCache($branchId = null)
    {
        Cache::forget('settings_global');

        if ($branchId) {
            Cache::forget('settings_' . $branchId);
        }
    }
}
