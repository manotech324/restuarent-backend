<?php

namespace Database\Factories;

use App\Models\Auth_SuperVisor\MenuItem;
use App\Models\Auth_SuperVisor\MenuCategory;
use App\Models\Admin\Branch;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuItemFactory extends Factory
{
    protected $model = MenuItem::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(),
            // 'price' => $this->faker->randomFloat(2, 5, 50), // Removed as column missing
            'image' => $this->faker->imageUrl(640, 480, 'food'),
            'is_available' => true,
            'category_id' => MenuCategory::factory(),
            'branch_id' => Branch::factory(),
        ];
    }
}
