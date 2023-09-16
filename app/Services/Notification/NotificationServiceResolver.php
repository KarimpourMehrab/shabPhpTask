<?php


namespace App\Services\Notification;


use Exception;
use Illuminate\Support\Str;

class NotificationServiceResolver
{

    protected $notificationService;


    /**
     * @throws Exception
     */
    public function __construct(string $notificationService = null)
    {
        $this->make($notificationService);
    }

    /**
     * @throws Exception
     */
    public function __call(string $name, array $arguments)
    {
        if (in_array(Str::lower($name), $this->getActiveServices())) {
            return $this->make($name);
        }
        return call_user_func_array([$this->notificationService, $name], $arguments);
    }

    /**
     * @throws Exception
     */
    public function make($notificationService = null): NotificationServiceResolver
    {
        # Get default notification service if the $notificationService is null
        if (!$notificationService) $notificationService = $this->getActiveServices()[0];

        if (!$notificationService instanceof notificationServiceAbstract) {


            if (!in_array($notificationService, $this->getActiveServices())) {
                throw new Exception('notification Service Not Found');
            }

            $notificationService = Str::studly(strtolower($notificationService));


            $class = 'App\\Services\\Notification\\' . $notificationService . '\\' . $notificationService;
            $notificationService = new $class();
        }

        $this->notificationService = $notificationService;

        return $this;
    }

    private function getActiveServices()
    {
        return config('notification.active_services');
    }

}
