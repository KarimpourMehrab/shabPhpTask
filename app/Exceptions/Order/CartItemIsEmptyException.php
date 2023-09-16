<?php

namespace App\Exceptions\Order;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class CartItemIsEmptyException extends Exception
{
    protected $code = Response::HTTP_UNPROCESSABLE_ENTITY;
    protected $message = '';

    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->message = __('messages.order.empty_cart_item');
    }
}

