<?php

namespace Database\Factories;

use App\Models\Auth_SuperVisor\MenuItemAddon;
use App\Models\Auth_SuperVisor\MenuItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuItemAddonFactory extends Factory
{
    protected $model = MenuItemAddon::class;

    public function definition(): array
    {
        return [
            'menu_item_id' => MenuItem::factory(),
            'name' => $this->faker->randomElement(['Extra Cheese', 'Sauce', 'Bacon', 'Olives']),
            'price' => $this->faker->randomFloat(2, 0.5, 3),
            'is_available' => true,
        ];
    }
}
