<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class FeeInvoiceRequest extends FormRequest
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
            'fee_receipt'  => 'nullable|min:0',
            'fee_invoice'  => 'nullable|min:0',
            'fee_delivery' => 'nullable|min:0',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'status'  => false,
            'message' => trans('admin_message.fee')
        ]);
        throw new HttpResponseException($response);
    }
}
