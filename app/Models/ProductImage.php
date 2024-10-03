<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
    protected $fillable=['file_name','path', 'product_combination_id','main'];

    protected $attributes =['main' => 0];

    public function product()
    {
        return $this->belongsTo(ProductCombination:: class);
    }
}
