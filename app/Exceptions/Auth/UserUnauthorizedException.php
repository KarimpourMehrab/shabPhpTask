<?php

namespace App\Exceptions\Auth;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class UserUnauthorizedException extends Exception
{
    protected $code = Response::HTTP_UNAUTHORIZED;
    protected $message = '';

    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
        $this->message = __('messages.auth.unauthorized');
    }
}

