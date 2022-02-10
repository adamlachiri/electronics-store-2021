<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "user_id",
        "name",
        "phone",
        "city",
        "address",
        "payment_method",
        "total_price",
        "step"
    ];

    public function order_items()
    {
        return $this->hasMany(Order_item::class);
    }
}
