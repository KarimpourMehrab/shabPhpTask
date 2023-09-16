<?php

namespace App\Services\Notification\Exceptions;

use Exception;

class ParameterNotificationExceptions extends Exception
{
    protected $message = 'missing parameters required';
}
