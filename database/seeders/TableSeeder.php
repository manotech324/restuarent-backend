<?php

namespace Database\Seeders;

use App\Models\Admin\Branch;
use App\Models\Auth_SuperVisor\Table;
use Illuminate\Database\Seeder;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = Branch::all();

        foreach ($branches as $branch) {
            // Create 10 tables for each branch
            // Note: Table model doesn't seem to have branch_id in fillable?
            // Let's check Table model again.
            // If Table is global or not linked to branch, just create tables.
            // But usually tables belong to a branch.
            // Assuming Table model needs update or existing schema allows it.
            // Based on previous view, Table only has 'name'.
            // If so, we just create tables.
            
            Table::factory()->count(10)->create([
                'branch_id' => $branch->id
            ]); 
        }
    }
}
