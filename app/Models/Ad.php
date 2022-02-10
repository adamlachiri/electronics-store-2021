<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        "product_id",
        "image",
        "type"
    ];

    // product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
