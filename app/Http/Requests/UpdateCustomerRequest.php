<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'passport' => 'nullable|string|required_with:passport_date|regex:/^[A-Z]{2}[0-9]{7}$/',
            'passport_date' => 'nullable|date',
            'passport_by' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|integer|regex:/^[0-9]{9}$/',
            'find_id' => 'nullable|integer|exists:finds,id',
            'description' => 'nullable|string',
        ];
    }
}
