<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'products' => "required",
            'products.*' => "required",
            'products.*.arrival_date' => "required|date",
            'products.*.supplier_id' => "required|integer|exists:suppliers,id",
            'products.*.category_id' => "required|integer|exists:categories,id",
            'products.*.market_id' => "required|integer|exists:markets,id",
            'products.*.total_quantity' => "required|numeric|min:0|not_in:0",
            'products.*.total_price' => "required|numeric|min:0|not_in:0",
            'products.*.note' => "sometimes|nullable|string",
            'products.*.name' => [
                "required",
                "string",
                'max:255',
                // "regex:/^[\s\w\-,_.]*$/",
            ],
            'products.*.images' => "sometimes|required|image|bail|mimes:jpeg,png,jpg,svg|max:2048",
        ];
    }

    public function messages()
    {
        return [
            'products.required' => __('validation.admin.product.required'),
            'products.*.required' => __('validation.admin.product.required'),
            'products.*.arrival_date.required' => __('validation.admin.product.required'),
            'products.*.arrival_date.date' => __('validation.admin.product.exists'),
            'products.*.supplier_id.required' => __('validation.admin.product.required'),
            'products.*.supplier_id.exists' => __('validation.admin.product.exists'),
            'products.*.category_id.required' => __('validation.admin.product.required'),
            'products.*.category_id.exists' => __('validation.admin.product.exists'),
            'products.*.market_id.required' => __('validation.admin.product.required'),
            'products.*.market_id.exists' => __('validation.admin.product.exists'),
            'products.*.total_quantity.required' =>  __('validation.admin.product.required'),
            'products.*.total_quantity.not_in' =>  __('validation.admin.product.not_in'),
            'products.*.total_price.required' =>  __('validation.admin.product.required'),
            'products.*.total_price.not_in' =>  __('validation.admin.product.not_in'),
            'products.*.name.required' => __('validation.admin.product.required'),
            'products.*.name.regex' => __('validation.admin.product.name'),
            'products.*.name.max' => __('validation.admin.product.name_max'),
            'products.*.images.image' => __('validation.admin.product.image'),
            'product.*.images.mimes' => __('validation.admin.product.mimes'),
            'products.*.images.max' => __('validation.admin.product.max'),
        ];
    }
}
