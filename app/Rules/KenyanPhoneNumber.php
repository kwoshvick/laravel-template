<?php

declare(strict_types=1);

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class KenyanPhoneNumber implements Rule
{
    public function passes($attribute, $value): bool|int
    {
        // Remove any non-digit characters from the phone number
        $phoneNumber = preg_replace('/[^0-9]/', '', $value);

        // Check if the phone number starts with '+254' or '0'
        return preg_match('/^(?:\+?254|0)[17]\d{8}$/', $phoneNumber);
    }

    public function message(): string
    {
        return 'The :attribute must be a valid Kenyan phone number.';
    }
}
