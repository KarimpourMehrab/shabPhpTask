<?php

namespace App\Exceptions\General;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class NotFoundException extends Exception
{

    public function __construct(string $message = "", int $code = Response::HTTP_NOT_FOUND, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->message = __('messages.general.not_found');
    }
}

