<?php

namespace App\Http\Requests\Web;

use App\Models\User;
use App\Rules\UniQueEmailUsers;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule as Rule1;

class PasswordResetTokenRequest extends FormRequest
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
        if ($this->isMethod('post')) {
            return [
                'token' => ['required']
            ];
        }
        return [];
    }

    public function messages()
    {
        return [
            'email.required' => trans('validation.web.user.required_email'),
        ];
    }
}
