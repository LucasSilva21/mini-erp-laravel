<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'discount', 'min_value', 'expires_at'];

    protected $casts = [
        'expires_at' => 'date',
    ];

    public function isValid()
    {
        return $this->expires_at && $this->expires_at->isFuture();
    }
}
