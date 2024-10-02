<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
        'product_type_id'
    ];

    public function productVariants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function productAttributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function productType(): BelongsTo
    {
        return $this->belongsTo(ProductType::class);
    }

    public function cartItem()
    {
        return $this->hasMany(Product::class);
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }
}
