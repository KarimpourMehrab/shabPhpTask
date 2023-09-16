<?php

namespace App\Services\Notification\PushNotification;

use App\Models\User;
use App\Services\Notification\NotificationServiceAbstract;

class PushNotification extends NotificationServiceAbstract
{

    public static function name(): string
    {
        return 'pushNotification';
    }

    public function notify()
    {
        // TODO: Implement notify() method.
    }
}
