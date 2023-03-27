<?php

namespace App\Http\Requests\Auth;

use Urameshibr\Requests\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:45',
            'last_name'  => 'required|string|max:45',
            'email'      => 'required|email|unique:users,email|string|max:45',
            'password'   => 'required|string|max:255|min:8',
        ];
    }
}
