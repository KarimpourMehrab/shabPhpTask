<?php

namespace App\Models;

use App\Models\traits\Order\Relations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, Relations;

    protected $fillable = [
        'user_id',
        'final_price'
    ];
}
