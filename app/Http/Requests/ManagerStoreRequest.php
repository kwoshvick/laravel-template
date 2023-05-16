<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Rules\KenyanPhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class ManagerStoreRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:50'],
            'phone' => ['required', 'string', new KenyanPhoneNumber()],
            'email' => ['required', 'string', 'max:50', 'unique:managers'],
            'supermarket_id' => ['required', 'string', 'exists:supermarkets,id'],
        ];
    }
}
