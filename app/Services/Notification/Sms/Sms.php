<?php

namespace App\Services\Notification\Sms;


use App\Jobs\SendSmsJob;
use App\Services\Notification\Exceptions\ParameterNotificationExceptions;
use App\Services\Notification\NotificationServiceAbstract;

class Sms extends NotificationServiceAbstract
{

    public function __construct(public null|int $pattern = null, public null|array $params = null, public $mobile = null, public $timeShouldBeSuitable = false, public null|string $service = null)
    {

    }

    //                start of required methods


    public static function name(): string
    {
        return 'sms';
    }

    public function setService(string $service): static
    {
        $this->service = $service;
        return $this;
    }

    public function setPattern(string $pattern): static
    {
        $this->pattern = $pattern;
        return $this;
    }

    public function setParams(array $params): static
    {
        $this->params = $params;
        return $this;
    }

    public function setMobile(string $mobile): static
    {
        $this->mobile = $mobile;
        return $this;
    }

    /**
     * @throws ParameterNotificationExceptions
     */
    public function notify()
    {
        $this->checkParameters();
        SendSmsJob::dispatch($this->pattern, $this->params, $this->mobile, $this->service);
    }


    /**
     * @throws ParameterNotificationExceptions
     */
    public function notifySync()
    {
        $this->checkParameters();
        SendSmsJob::dispatchSync($this->pattern, $this->params, $this->mobile);
    }

    /**
     * @throws ParameterNotificationExceptions
     */
    private function checkParameters()
    {
        if ((!$this->pattern && $this->pattern != 0) || !$this->params || !$this->mobile)
            throw new ParameterNotificationExceptions();
    }


    //                start of un required methods

    public function timeShouldBeSuitable(bool $timeShouldBeSuitable): static
    {
        $this->timeShouldBeSuitable = $timeShouldBeSuitable;
        return $this;
    }

}

