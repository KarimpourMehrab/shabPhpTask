<?php

namespace App\Listeners\newOrder;

use App\Services\Notification\Email\Email;
use App\Services\Notification\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOrderDetailNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $order = $event->order;
        // send the order notification for admin
        $notification = NotificationService::make(Email::name());
        $notification->setEmail('admin@admin');
        $notification->setParams($order);
        $notification->notify();

        // send the order notification for actor
        $notification = NotificationService::make(Email::name());
        $notification->setEmail($order->user->email);
        $notification->setParams($order);
        $notification->notify();
    }
}
