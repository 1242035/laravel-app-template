<?php

namespace App\Http\Requests\Web;

use App\Models\User;
use App\Rules\UniQueEmailUsers;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule as Rule1;

class RegisterRequest extends FormRequest
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
                'email'    => ['required', 'max:255', 'email', 'unique:users', 'regex:' . User::VALIDATE_SPACE],
                'password' => 'required'
            ];
        }
        return [];
    }

    public function messages()
    {
        return [
            'email.required'    => trans('validation.web.user.required_email'),
            'email.regex'       => trans('validation.web.user.email'),
            'email.email'       => trans('validation.web.user.email'),
            'email.max'         => trans('validation.web.user.email_max'),
            'email.unique'      => trans('validation.web.user.email_unique'),
            'password.required' => trans('validation.web.user.required_password'),
        ];
    }
}
