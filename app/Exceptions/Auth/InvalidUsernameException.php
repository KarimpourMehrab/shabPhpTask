<?php

namespace App\Exceptions\Auth;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class InvalidUsernameException extends Exception
{
    protected $code = Response::HTTP_UNPROCESSABLE_ENTITY;
    protected $message = '';

    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->message = __('messages.auth.invalid_username');
    }
}

