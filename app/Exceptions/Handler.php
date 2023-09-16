<?php

namespace App\Exceptions;

use App\Exceptions\General\NotFoundException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;

class Handler extends ExceptionHandler
{
    public mixed $response;
    public int $status;

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];


    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        $this->customApiResponse($e);
        return response()->json($this->response, $this->status);
    }

    private function customApiResponse($exception): void
    {
        match (get_class($exception)) {
            RouteNotFoundException::class => $this->routeNotFoundExceptionHandler($exception),
            MethodNotAllowedHttpException::class => $this->methodNotAllowedHttpExceptionHandler($exception),
            ValidationException::class => $this->validationExceptionHandler($exception),
            AuthenticationException::class => $this->unAuthenticatedExceptionHandler(),
            NotFoundHttpException::class, NotFoundException::class => $this->dataNotFoundExceptionHandler($exception),
            default => $this->generalExceptionHandler($exception)
        };
    }

    private function validationExceptionHandler($exception): void
    {
        $this->response = [
            'status' => false,
            'data' => null,
            'messages' => $exception->validator->getMessageBag()->toArray()
        ];
        $this->status = Response::HTTP_UNPROCESSABLE_ENTITY;
    }

    private function generalExceptionHandler($exception): void
    {
        $this->response = [
            'status' => false,
            'data' => null,
            'messages' => $this->exceptionMessage($exception)
        ];
        $this->status = (method_exists($exception, 'getCode') && in_array(intval($exception->getCode()), array_keys(Response::$statusTexts)))
        != 0 ? $exception->getCode() : 500;
    }

    private function methodNotAllowedHttpExceptionHandler(): void
    {
        $this->response = [
            'status' => false,
            'data' => null,
            'messages' => __('messages.general.route_not_found')
        ];
        $this->status = Response::HTTP_METHOD_NOT_ALLOWED;
    }

    private function dataNotFoundExceptionHandler(): void
    {
        $this->response = [
            'status' => false,
            'data' => null,
            'messages' => __('messages.general.not_found')
        ];
        $this->status = Response::HTTP_BAD_REQUEST;
    }

    private function routeNotFoundExceptionHandler(): void
    {
        $this->response = [
            'status' => false,
            'data' => null,
            'messages' => __('messages.general.route_not_found')
        ];
        $this->status = Response::HTTP_NOT_FOUND;
    }

    private function unAuthenticatedExceptionHandler(): void
    {
        $this->response = [
            'status' => false,
            'data' => null,
            'messages' => __('messages.auth.unauthenticated')
        ];
        $this->status = Response::HTTP_FORBIDDEN;
    }

    private function exceptionMessage($exception): string
    {
        return env('APP_ENV') === 'local' && (method_exists($exception, 'getMessage'))
            ? $exception->getMessage() : __('messages.general.error');
    }
}
