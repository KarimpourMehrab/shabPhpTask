<?php

namespace App\Services\Notification\Email;

use App\Jobs\Notification\SendEmailJob;
use App\Services\Notification\Exceptions\ParameterNotificationExceptions;
use App\Services\Notification\NotificationServiceAbstract;
use Illuminate\Mail\Mailable;

class Email extends NotificationServiceAbstract
{

    public function __construct(public null|Mailable $mail = null, public null|string $email = null)
    {
    }

    //                start of required methods
    public static function name(): string
    {
        return 'email';
    }

    public function setMail(Mailable $mail): static
    {
        $this->mail = $mail;
        return $this;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }


    /**
     * @throws ParameterNotificationExceptions
     */
    public function notify(): void
    {
        $this->checkParameters();
        SendEmailJob::dispatch($this->mail, $this->email);
    }

    /**
     * @throws ParameterNotificationExceptions
     */
    public function notifySync(): void
    {
        $this->checkParameters();
        SendEmailJob::dispatchSync($this->mail, $this->email);
    }

    /**
     * @throws ParameterNotificationExceptions
     */
    private function checkParameters()
    {
        if (!$this->mail || !$this->email)
            throw new ParameterNotificationExceptions();
    }

}

