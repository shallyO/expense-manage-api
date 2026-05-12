<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Ensure a User exists
        $user = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Shalom', 'password' => bcrypt('password')]
        );

        // 2. Ensure a Category exists (so exists:categories,id doesn't fail)
        DB::table('categories')->updateOrInsert(
            ['id' => 1],
            ['name' => 'Food', 'created_at' => now()]
        );

        // 3. Create the manual expense
        Expense::create([
            'user_id'     => 1,
            'category_id' => 23,
            'title'       => 'Food',
            'amount'      => 2.500,
            'note'        => 'Food',
            'date'        => '2025-03-2',
        ]);
    }
}
