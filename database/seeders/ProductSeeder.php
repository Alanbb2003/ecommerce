<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Products;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $menCategory = Category::where('name', 'Men')->first();
        $phoneCategory = Category::where('name', 'Smartphones')->first();

        Products::create([
            'category_id' => $menCategory->id,
            'name' => 'Basic Cotton T-Shirt',
            'slug' => 'basic-cotton-t-shirt',
            'description' => 'Comfortable cotton t-shirt suitable for daily wear.',
            'is_active' => true,
        ]);

        Products::create([
            'category_id' => $phoneCategory->id,
            'name' => 'Smartphone X Pro',
            'slug' => 'smartphone-x-pro',
            'description' => 'Flagship smartphone with AMOLED display and fast charging.',
            'is_active' => true,
        ]);
    }
}
