<?php

namespace App\Models\traits\User;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait Relations
{
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }
}
