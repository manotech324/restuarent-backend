<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    /**
     * 🔹 Get settings (Mobile App)
     * Global + Branch override
     */
    public function index(Request $request)
    {
        $branchId = $request->query('branch_id');

        $cacheKey = 'settings_' . ($branchId ?? 'global');

        $settings = Cache::remember($cacheKey, 3600, function () use ($branchId) {

            $global = Setting::whereNull('branch_id')
                ->pluck('value', 'key');

            if ($branchId) {
                $branch = Setting::where('branch_id', $branchId)
                    ->pluck('value', 'key');

                return $global->merge($branch);
            }

            return $global;
        });

        return response()->json([
            'success' => true,
            'data' => $settings
        ]);
    }

    /**
     * 🔹 Store new setting (Admin)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string|max:255',
            'value' => 'nullable',
            'branch_id' => 'nullable|exists:branches,id',
        ]);

        $setting = Setting::updateOrCreate(
            [
                'key' => $validated['key'],
                'branch_id' => $validated['branch_id'] ?? null
            ],
            [
                'value' => $validated['value']
            ]
        );

        $this->clearCache($validated['branch_id'] ?? null);

        return response()->json([
            'success' => true,
            'message' => 'Setting saved successfully',
            'data' => $setting
        ], 201);
    }

    /**
     * 🔹 Show single setting
     */
    public function show($id)
    {
        $setting = Setting::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $setting
        ]);
    }

    /**
     * 🔹 Update setting
     */
    public function update(Request $request, $id)
    {
        $setting = Setting::findOrFail($id);

        $validated = $request->validate([
            'key' => [
                'required',
                'string',
                Rule::unique('settings')
                    ->ignore($setting->id)
                    ->where(fn ($q) =>
                        $q->where('branch_id', $setting->branch_id)
                    )
            ],
            'value' => 'nullable'
        ]);

        $setting->update($validated);

        $this->clearCache($setting->branch_id);

        return response()->json([
            'success' => true,
            'message' => 'Setting updated successfully',
            'data' => $setting
        ]);
    }

    /**
     * 🔹 Delete setting
     */
    public function destroy($id)
    {
        $setting = Setting::findOrFail($id);

        $branchId = $setting->branch_id;

        $setting->delete();

        $this->clearCache($branchId);

        return response()->json([
            'success' => true,
            'message' => 'Setting deleted successfully'
        ]);
    }

    /**
     * 🔹 Clear cache helper
     */
    private function clearCache($branchId = null)
    {
        Cache::forget('settings_global');

        if ($branchId) {
            Cache::forget('settings_' . $branchId);
        }
    }
}
