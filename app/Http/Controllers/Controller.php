<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct(protected mixed $data = null, protected string|null $message = null, protected bool $status = true)
    {
    }

    public function response($statusCode = Response::HTTP_OK): \Illuminate\Http\JsonResponse
    {
        $this->message = $this->message ?? __('messages.general.success');
        $response = [
            'data' => $this->data,
            'message' => $this->message,
            'status' => $this->status
        ];
        return response()->json($response, $statusCode);
    }

}
