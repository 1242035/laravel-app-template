<?php

namespace App\Http\Requests\Web;

use App\Models\User;
use App\Rules\UniQueEmailUsers;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule as Rule1;

class AddOrderRequest extends FormRequest
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
                'user_id'   => 'required|numeric',
                'order_date' => 'date|after:yesterday',
            ];
    }

    public function messages()
    {
        return [

        ];
    }
}
