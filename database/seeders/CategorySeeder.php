<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $fashion = Category::create([
            'name' => 'Fashion',
            'slug' => 'fashion',
            'parent_id' => null,
        ]);

        $electronics = Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
            'parent_id' => null,
        ]);

        Category::insert([
            [
                'name' => 'Men',
                'slug' => 'men',
                'parent_id' => $fashion->id,
            ],
            [
                'name' => 'Women',
                'slug' => 'women',
                'parent_id' => $fashion->id,
            ],
            [
                'name' => 'Smartphones',
                'slug' => 'smartphones',
                'parent_id' => $electronics->id,
            ],
            [
                'name' => 'Accessories',
                'slug' => 'accessories',
                'parent_id' => $electronics->id,
            ],
        ]);
    }
}
