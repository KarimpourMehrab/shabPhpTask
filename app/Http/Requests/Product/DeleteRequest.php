<?php

namespace App\Http\Requests\Product;

use App\Exceptions\Auth\UserUnauthorizedException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class DeleteRequest extends FormRequest
{

    /**
     * @throws UserUnauthorizedException
     */
    public function authorize(Request $request): bool
    {
        $userDoSnotHavePermission = !auth()->user()->whereHas('products', function ($q) use ($request) {
            $q->where('id', $request->route('id'));
        })->exists();
        if ($userDoSnotHavePermission) throw new UserUnauthorizedException();
        return true;
    }


    public function rules(): array
    {
        return [];
    }
}
