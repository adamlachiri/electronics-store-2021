<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "category_id",
        "original_price",
        "price",
        "stock",
        "total_sells",
        "total_reviews",
        "rating",
        "main_image",
        "image_1",
        "image_2",
        "video",
        "promotion",
        "coupon_code",
        "coupon_reduction",
        "guarantee"
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
