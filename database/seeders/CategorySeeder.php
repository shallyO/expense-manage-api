<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
     $categories = [
            'Food',
            'Transportation',
            'Rent',
            'Utilities',
            'Healthcare',
            'Savings',
            'Miscellaneous',
        ];

        foreach ($categories as $name) {
            Category::firstOrCreate([
                'name' => $name
            ]);
        }
    }
}
