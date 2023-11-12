<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart_Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'total_price',
        'total_qty',
        'total_waiting_time',
        'updated_at'
    ];
}
