<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductVariant extends Model
{
    use HasFactory;
    public $table = "product_variants";
    protected $fillable = [
        'product_id',
        'size',
        'price',
        'stock'
    ];
    protected static function booted()
    {
        static::creating(function ($variant) {
            if ($variant->sku) {
                return;
            }

            $product = $variant->product()->with('category')->first();

            $categoryCode = Str::upper(Str::substr($product->category->slug, 0, 3));
            $productCode  = Str::upper(Str::substr($product->slug, 0, 6));
            $variantCode  = Str::upper(Str::slug($variant->size));

            $variant->sku = "{$categoryCode}-{$productCode}-{$variantCode}";
        });
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
