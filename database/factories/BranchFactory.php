<?php

namespace Database\Factories;

use App\Models\Admin\Branch;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Branch>
 */
class BranchFactory extends Factory
{
    protected $model = Branch::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company() . ' Branch',
            'location' => $this->faker->address(),
            'phone' => $this->faker->phoneNumber(),
        ];
    }
}
