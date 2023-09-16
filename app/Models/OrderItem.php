<?php

namespace App\Models;

use App\Models\traits\OrderItem\Relations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory, Relations;

    protected $fillable = [
        'order_id',
        'product_id',
        'price'
    ];

}
