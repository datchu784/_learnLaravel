<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;

    protected $fillable = ['attribute_id', 'value'];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function productAttributes()
    {
        //'combination_attributes': Đây là tên của bảng trục lưu trữ các mối quan hệ nhiều nhiều
        return $this->hasMany(ProductAttribute::class);
    }
}
