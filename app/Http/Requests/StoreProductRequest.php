<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // dd($this->all());
        return [
            'name' => 'required|string|max:255',
            'code' => 'required|integer|unique:products',
            'description' => 'nullable|string',
            'category_id' => 'required|integer|exists:categories,id',
            'brand_id' => 'required|integer|exists:brands,id',
            'unit' => 'required|string|max:10',
            'in_price' => 'required|numeric',
            'in_price_usd' => 'required|numeric',
            'price' => 'required|numeric',
            'price_usd' => 'required|numeric',
            'day_sale' => 'nullable|integer',
            'alert_quantity' => 'required|integer',
            // is_imei is value on 1 or 0
            'is_imei' => 'nullable|integer',
            'image' => 'nullable|image',
        ];
    }
}
