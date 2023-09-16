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
            'mobile' => ['required', 'string', 'digits:11', 'unique:users,mobile'],
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:24', 'min:6']
        ];
    }
}
