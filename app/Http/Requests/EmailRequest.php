<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmailRequest extends FormRequest
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
            'subject' => 'required',
            'name_store' => 'required',
            'email' => 'email',
            'body' => 'required',
            'attach' => 'max:10240',
        ];
    }

    public function messages()
    {
        return [
            'subject.required' => trans('validation.admin.send_mail.required_subject'),
            'name_store.required' => trans('validation.admin.send_mail.required_name_store'),
            'email.email' => trans('validation.admin.send_mail.email'),
            'attach.max' =>trans('validation.admin.send_mail.max_attach'),
            'body.required' => trans('validation.admin.send_mail.required_body'), 
        ];
    }
}
