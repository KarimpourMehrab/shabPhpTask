<?php


namespace App\Services\Notification;


use Illuminate\Support\Facades\Facade;

class  NotificationService extends Facade
{

    protected static function getFacadeAccessor(): string
    {
        return 'notificationService';
    }

}
