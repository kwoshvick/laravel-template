<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Rules\KenyanPhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class ManagerUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:50'],
            'phone' => ['bail', 'sometimes', 'string', new KenyanPhoneNumber()],
            'email' => ['sometimes', 'string', 'max:50'],
            'supermarket_id' => ['sometimes', 'string', 'exists:supermarkets,id'],
        ];
    }
}
