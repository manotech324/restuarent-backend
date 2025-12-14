<?php

namespace Database\Factories;

use App\Models\Auth_SuperVisor\Table;
use App\Models\Admin\Branch;
use Illuminate\Database\Eloquent\Factories\Factory;

class TableFactory extends Factory
{
    protected $model = Table::class;

    public function definition(): array
    {
        return [
            'name' => 'Table ' . $this->faker->unique()->numberBetween(1, 50),
            'branch_id' => Branch::factory(),
        ];
    }
}
