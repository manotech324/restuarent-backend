<?php

namespace Database\Factories;

use App\Models\Auth_SuperVisor\MenuItemVariant;
use App\Models\Auth_SuperVisor\MenuItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuItemVariantFactory extends Factory
{
    protected $model = MenuItemVariant::class;

    public function definition(): array
    {
        return [
            'menu_item_id' => MenuItem::factory(),
            'name' => $this->faker->randomElement(['Small', 'Medium', 'Large', 'Spicy', 'Regular']),
            'price' => $this->faker->randomFloat(2, 1, 10),
            'is_available' => true,
        ];
    }
}
