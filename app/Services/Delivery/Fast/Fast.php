<?php

namespace App\Services\Delivery\Fast;


use App\Models\Product;
use App\Services\Delivery\DeliveryServiceAbstract;

class Fast extends DeliveryServiceAbstract
{

    public static function name(): string
    {
        return 'fast';
    }


    public function calculate(Product $product): int
    {
        // calculate the delivery price
        // ...
        // ...
        return intval($product->price * 0.02);
    }
}

