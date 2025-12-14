<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            BranchSeeder::class,
            TableSeeder::class, // Warning: Tables might not differ per branch if schema lacks branch_id
            MenuSeeder::class,
        ]);
    }
}
