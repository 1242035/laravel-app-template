<?php

namespace App\Http\Requests\Web;

use App\Models\User;
use App\Rules\UniQueEmailUsers;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule as Rule1;

class AddressRequest extends FormRequest
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
            'name'            => 'required|max:64',
            'country_code'    => 'nullable|max:3',
            'pref_id'         => 'nullable|integer',
            'postal_code'     => 'nullable|max:16',
            'addr01'          => 'required|max:255',
            'addr02'          => 'required|max:255',
            'phone_number'    => 'required|max:16|regex:' . User::VALIDATE_PHONE,
            'company_name'    => 'nullable|max:255',
            'post_code_01'    => 'required|size:3|regex:' . User::VALIDATE_INTERGER,
            'post_code_02'    => 'required|size:4|regex:' . User::VALIDATE_INTERGER,
            'email'           => 'required|email|max:255'
        ];
    }

    public function messages()
    {
        return [
            'name.required'         => trans('validation.web.user.name_required'),
            'name.max'              => trans('validation.web.user.name_max'),
            'first_name_kana.max'   => trans('validation.web.user.first_name_kana_max'),
            'first_name_kana.regex' => trans('validation.web.user.first_name_kana_regex'),
            'last_name_kana.max'    => trans('validation.web.user.last_name_kana_max'),
            'last_name_kana.regex'  => trans('validation.web.user.last_name_kana_regex'),
            'pref_id.integer'       => trans('validation.web.user.pref_id_integer'),
            'postal_code.max'       => trans('validation.web.user.postal_code_max'),
            'addr01.required'       => trans('validation.web.user.addr01_required'),
            'addr01.max'            => trans('validation.web.user.addr01_max'),
            'addr02.required'       => trans('validation.web.user.addr02_required'),
            'addr02.max'            => trans('validation.web.user.addr02_max'),
            'phone_number.max'      => trans('validation.web.user.phone_number_max'),
            'phone_number.regex'    => trans('validation.web.user.phone_number_numeric'),
            'phone_number.required' => trans('validation.web.user.phone_number_required'),
            'company_name.max'      => trans('validation.web.user.company_name_max'),
            'post_code_01.regex'    => trans('validation.web.user.postal_code_is_number'),
            'post_code_02.regex'    => trans('validation.web.user.postal_code_is_number'),
            'post_code_01.size'     => trans('validation.web.user.postal_code_01'),
            'post_code_02.size'     => trans('validation.web.user.postal_code_02'),
            'post_code_01.required' => trans('validation.web.user.post_code1_required'),
            'post_code_02.required' => trans('validation.web.user.post_code2_required'),
            'email.required'        => trans('validation.web.user.email_required'),
            'email.max'             => trans('validation.web.user.email_max'),
            'email.email'           => trans('validation.web.user.email'),
        ];
    }
}
