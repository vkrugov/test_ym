<?php

namespace App\Http\Requests\Auth;

use Urameshibr\Requests\FormRequest;

class RecoverPasswordRequest extends FormRequest
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
            'email' => 'required|email|string|max:255',
        ];
    }
}
