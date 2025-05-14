<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'subtotal',
        'freight',
        'total',
        'status',
        'address',
        'coupon_id' // se estiver usando cupons no pedido
    ];
}
