<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PhoneRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return !! preg_match('/^\+380\d{3}\d{2}\d{2}\d{2}$/', $value);
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return 'The phone is invalid. Right Format is: +380XXXXXXXXX';
    }
}
