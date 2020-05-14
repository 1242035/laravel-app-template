<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'The :attribute must be accepted.',
    'active_url'           => 'The :attribute is not a valid URL.',
    'after'                => 'The :attribute must be a date after :date.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => 'The :attribute may only contain letters.',
    'alpha_dash'           => 'The :attribute may only contain letters, numbers, dashes and underscores.',
    'alpha_num'            => 'The :attribute may only contain letters and numbers.',
    'array'                => 'The :attribute must be an array.',
    'before'               => 'The :attribute must be a date before :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => 'The :attribute confirmation does not match.',
    'date'                 => 'The :attribute is not a valid date.',
    'date_equals'          => 'The :attribute must be a date equal to :date.',
    'date_format'          => 'The :attribute does not match the format :format.',
    'different'            => 'The :attribute and :other must be different.',
    'digits'               => 'The :attribute must be :digits digits.',
    'digits_between'       => 'The :attribute must be between :min and :max digits.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'The :attribute must be a valid email address.',
    'ends_with'            => 'The :attribute must end with one of the following: :values',
    'exists'               => 'The selected :attribute is invalid.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'gt'                   => [
        'numeric' => 'The :attribute must be greater than :value.',
        'file'    => 'The :attribute must be greater than :value kilobytes.',
        'string'  => 'The :attribute must be greater than :value characters.',
        'array'   => 'The :attribute must have more than :value items.',
    ],
    'gte'                  => [
        'numeric' => 'The :attribute must be greater than or equal :value.',
        'file'    => 'The :attribute must be greater than or equal :value kilobytes.',
        'string'  => 'The :attribute must be greater than or equal :value characters.',
        'array'   => 'The :attribute must have :value items or more.',
    ],
    'image'                => 'The :attribute must be an image.',
    'in'                   => 'The selected :attribute is invalid.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => 'The :attribute must be an integer.',
    'ip'                   => 'The :attribute must be a valid IP address.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'lt'                   => [
        'numeric' => 'The :attribute must be less than :value.',
        'file'    => 'The :attribute must be less than :value kilobytes.',
        'string'  => 'The :attribute must be less than :value characters.',
        'array'   => 'The :attribute must have less than :value items.',
    ],
    'lte'                  => [
        'numeric' => 'The :attribute must be less than or equal :value.',
        'file'    => 'The :attribute must be less than or equal :value kilobytes.',
        'string'  => 'The :attribute must be less than or equal :value characters.',
        'array'   => 'The :attribute must not have more than :value items.',
    ],
    'max'                  => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file'    => 'The :attribute may not be greater than :max kilobytes.',
        'string'  => 'The :attribute may not be greater than :max characters.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'The :attribute must be at least :min.',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => 'The :attribute must be at least :min characters.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'not_regex'            => 'The :attribute format is invalid.',
    'numeric'              => 'The :attribute must be a number.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'The :attribute format is invalid.',
    'required'             => 'The :attribute field is required.',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values are present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'starts_with'          => 'The :attribute must start with one of the following: :values',
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'The :attribute has already been taken.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'The :attribute format is invalid.',
    'uuid'                 => 'The :attribute must be a valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],


    'admin' => [
        'store' => [
            'required_email'        => 'メールアドレスは必須項目です',
            'email_type'            => 'Type of Email is Incorect',
            'required_name'         => '氏名は必須項目です',
            'required_phone_number' => '電話番号 は必須項目です',
            'required_address'      => '住所は必須項目です',
            'product_number'        => '番号が無効です'
        ],

        'send_mail' => [
            'required_subject'    => '件名は必ず入力してください。',
            'required_name_store' => '店舗名は必ず入力してください。',
            'email'               => 'メールが無効です',
            'required_body'       => '本文は必ず入力してください。',
            'max_attach'          => 'ファイルサイズは10を超えてなりません',
            'success'             => 'メールを送りました',
        ],

        'product'  => [
            'required' => "必須項目を全て入力してください",
            'name'     => "製品名に特殊文字を含むことはできません",
            'name_max' => "Product name must not exceed 255 characters",
            'exists'   => "見つかりません",
            'not_in'   => "数量は0より大きい必要があります",
            'max'      => "製品名に特殊文字を含むことはできません",
            'image'    => "画像形式はjpeg/png/jpg/svgである必要です",
            'mimes'    => "画像形式はjpeg/png/jpg/svgである必要です",
        ],
        'order'    => [
            'time_error' => '現在の日付よりも大きい日付を選択する必要があります',
        ],
        'register' => [
            'check' => '少なくとも1つの製品を選択してください',
        ],
        'accounts' => [
            'required_name'         => '店舗名は必須項目です',
            'max_length_name'       => '文字は100文字より多い入力してください',
            'required_email'        => 'メールは必須項目です',
            'format_email'          => 'メールの形式は正しくないです。または無効です',
            'max_length_email'      => 'メール文字は256文字より多い入力してください',
            'required_phone_number' => '電話は必須項目です',
            'required_pref_id'      => '住所は必須項目です',
            'required_addr01'       => '住所は必須項目です',
            'required_addr02'       => '住所は必須項目です',
            'required_balance_type' => '残高は必須項目です',
            'required_password'     => 'パスワードは必須項目です'
        ],
        'deposit'  => [
            'money_required' => '得意先は必須項目です',
            'user_required'  => '店舗をは必須項目です',
            'date_required'  => '入金日は必須項目です',
            'money_number'   => '金額は数字でなければなりません',
        ],

        'general'      => [
            'email_error'          => 'メールの形が正しくないです',
            'invalid_email'        => 'メールが存在しました',
            'invalid_phone_number' => '電話の形式は正しくないです。または無効です',
            'required'             => ':fieldは必須項目です',
            'max'                  => '文字は:max文字より多い入力してください',
            'min'                  => '数量は:minより大きい必要があります',
            'number'               => ':fieldは数字でなければなりません',
        ],
        'money_number' => '金額は数字でなければなりません',
        'import' => [
            'csv_xls' => 'csv、xls、xlxsファイルを選択してください'
        ]
    ],

    'web' => [
        'user' => [
            'required_email'        => 'メールアドレスは必須項目です',
            'required_phone'        => '電話番号 は必須項目です',
            'email_unique'          => 'メールが存在しました',
            'required_password'     => 'パスワードは必須項目です',
            'email'                 => 'メールの形が正しくないです',
            'email_max'             => '文字は255文字より多い入力してください',
            'email_required'        => 'メールフィールドは必須です',
            'name_required'         => '氏名は必須項目です',
            'name_max'              => '文字は255文字より多い入力してください',
            'first_name_kana_max'   => '文字は64文字より多い入力してください',
            'first_name_kana_regex' => '名はかな形式が正しくないです',
            'last_name_kana_max'    => '文字は64文字より多い入力してください',
            'last_name_kana_regex'  => '姓はかな形式が正しくないです',
            'pref_id_integer'       => 'Pref id phải là số ',
            'postal_code_max'       => '文字は16文字より多い入力してください',
            'addr01_required'       => '住所は必須項目です',
            'addr01_max'            => '文字は255文字より多い入力してください',
            'addr02_required'       => '住所は必須項目です',
            'addr02_max'            => '文字は255文字より多い入力してください',
            'phone_number_max'      => '文字は16文字より多い入力してください',
            'phone_number_numeric'  => '電話番号は数字でなければなりません',
            'phone_number_required' => '電話番号フィールドは必須です',
            'company_name_max'      => '文字は255文字より多い入力してください',
            'postal_code_01'        => '3桁の半角数字を入力してください',
            'postal_code_02'        => '4桁の半角数字を入力してください',
            'post_code1_required'   => '郵便番号は必須項目です',
            'post_code2_required'   => '郵便番号は必須項目です',
            'postal_code_is_number' => '郵便番号は数字でなければなりません'
        ]
    ]

];
