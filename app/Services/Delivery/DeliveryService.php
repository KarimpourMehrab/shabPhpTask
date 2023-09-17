<?php


namespace App\Services\Delivery;


use Illuminate\Support\Facades\Facade;

class  DeliveryService extends Facade
{

    protected static function getFacadeAccessor(): string
    {
        return 'deliveryService';
    }

}
