<?php

namespace Database\Seeders;

use App\Enum\UserRoles;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@admin.com',
            'phone' => '1234567890',
            'password' => Hash::make('password'),
            'role' => UserRoles::SUPER_ADMIN->value,
        ]);
    }
}
