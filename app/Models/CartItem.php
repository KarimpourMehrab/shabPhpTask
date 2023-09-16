<?php

namespace App\Models;

use App\Models\traits\cartItem\Relations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory,Relations;

    protected $fillable = [
        'user_id',
        'product_id'
    ];

}
