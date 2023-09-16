<?php

namespace App\Models;

use App\Models\traits\Order\Relations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory,Relations;

    protected $fillable = [
        'user_id',
        'final_price'
    ];
}
