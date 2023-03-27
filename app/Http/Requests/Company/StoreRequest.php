<?php

namespace App\Http\Requests\Company;

use App\Rules\PhoneRule;
use Urameshibr\Requests\FormRequest;

class StoreRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'phone' => [
                'required',
                'string',
                'max: 45',
                new PhoneRule()
            ],
            'description' => 'required|string',
        ];
    }
}
