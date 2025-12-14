<?php

namespace Database\Seeders;

use App\Models\Admin\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Branch::factory()->count(3)->create();
    }
}
