<?php

namespace App\Models\traits\cartItem;

use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait Relations
{
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
