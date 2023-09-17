<?php


namespace App\Services\Delivery;


use App\Models\Product;

abstract class  DeliveryServiceAbstract
{
    abstract public function calculate(Product $product): int;
}
