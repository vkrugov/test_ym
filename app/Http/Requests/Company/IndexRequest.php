<?php

namespace App\Http\Requests\Company;

use Urameshibr\Requests\FormRequest;

class IndexRequest extends FormRequest
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
            'page'  => 'int|nullable|min:0',
            'limit' => 'int|nullable|min:1|max:100',
            'title' => 'string|nullable|max:255'
        ];
    }
}
