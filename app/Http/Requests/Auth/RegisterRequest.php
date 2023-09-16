<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'mobile' => ['required', 'string', 'digits:11'],
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'password', 'max:24', 'min:6']
        ];
    }
}
