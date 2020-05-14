<?php

namespace App\Http\Requests\Web;

use App\Models\User;
use App\Rules\UniQueEmailUsers;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule as Rule1;

class AddCartRequest extends FormRequest
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
            'quantity'   => 'required|numeric',
            'product_id' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [

        ];
    }

    public function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'status'  => false,
            'message' => trans('admin_message.param_wrong')
        ],422);
        throw new HttpResponseException($response);
    }
}
