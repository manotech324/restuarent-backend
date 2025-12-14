<?php

namespace Database\Seeders;

use App\Models\Admin\Branch;
use App\Models\Auth_SuperVisor\MenuCategory;
use App\Models\Auth_SuperVisor\MenuItem;
use App\Models\Auth_SuperVisor\MenuItemVariant;
use App\Models\Auth_SuperVisor\MenuItemAddon;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = Branch::all();

        foreach ($branches as $branch) {
            // Create Categories for this branch
            $categories = MenuCategory::factory()->count(3)->create([
                'branch_id' => $branch->id
            ]);

            foreach ($categories as $category) {
                // Create Items for this category
                $items = MenuItem::factory()->count(5)->create([
                    'category_id' => $category->id,
                    'branch_id' => $branch->id
                ]);

                foreach ($items as $item) {
                    // Create Variants
                    MenuItemVariant::factory()->count(2)->create([
                        'menu_item_id' => $item->id
                    ]);

                    // Create Addons
                    MenuItemAddon::factory()->count(3)->create([
                        'menu_item_id' => $item->id
                    ]);
                }
            }
        }
    }
}
