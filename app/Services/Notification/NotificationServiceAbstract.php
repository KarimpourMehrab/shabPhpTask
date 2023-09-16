<?php


namespace App\Services\Notification;


use App\Models\User;

abstract class  NotificationServiceAbstract
{
    abstract public static function name(): string;

    abstract public function notify();

}
