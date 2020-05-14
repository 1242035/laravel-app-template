<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmRequest extends FormRequest
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
            'email' => 'required|email|max:255|regex:/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/',
            'name' => 'required|max:100',
            'phone_number' => 'required|max:12',
            'address' => 'required|max:150',
            'number_of_products' => function ($attribute, $value, $fail) {
                if ($value > 2147483647) {
                    $fail(__('validation.admin.store.product_number'));
                }
            }
        ];
    }

    public function messages()
    {
        return [
            'email.required' => __('validation.admin.store.required_email'),
            'email.email'  => __('validation.admin.store.email_type'),
            'name.required'  => __('validation.admin.store.required_name'),
            'phone_number.required' => __('validation.admin.store.required_phone_number'),
            'address.required'  => __('validation.admin.store.required_address'),
        ];
    }
}
