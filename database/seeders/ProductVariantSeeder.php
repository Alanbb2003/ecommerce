<?php

namespace Database\Seeders;

use App\Models\Products;
use App\Models\ProductVariant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductVariantSeeder extends Seeder
{
    public function run(): void
    {
        $tshirt = Products::where('name', 'Basic Cotton T-Shirt')->first();
        $phone = Products::where('name', 'Smartphone X Pro')->first();

        ProductVariant::insert([
            [
                'product_id' => $tshirt->id,
                'sku' => 'TSHIRT-S',
                'size' => 'S',
                'price' => 99000,
                'stock' => 50,
            ],
            [
                'product_id' => $tshirt->id,
                'sku' => 'TSHIRT-M',
                'size' => 'M',
                'price' => 99000,
                'stock' => 80,
            ],
            [
                'product_id' => $tshirt->id,
                'sku' => 'TSHIRT-L',
                'size' => 'L',
                'price' => 109000,
                'stock' => 40,
            ],
        ]);

        ProductVariant::insert([
            [
                'product_id' => $phone->id,
                'size' => '128GB',
                'sku'=>'PHONE-128',
                'price' => 8999000,
                'stock' => 25,
            ],
            [
                'product_id' => $phone->id,
                'size' => '256GB',
                'sku'=>'PHONE-256',
                'price' => 9999000,
                'stock' => 15,
            ],
        ]);
    }
}
