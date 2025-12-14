<?php

namespace Database\Factories;

use App\Models\Auth_SuperVisor\MenuCategory;
use App\Models\Admin\Branch;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuCategoryFactory extends Factory
{
    protected $model = MenuCategory::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'branch_id' => Branch::factory(),
        ];
    }
}
