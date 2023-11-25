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

    'accepted'=> '이 필드를 동의해야 합니다.',
    'accepted_if'=> '이 필드는 :other 이(가) :value이면 동의해야 합니다.',
    'active_url'=> '이 URL은 유효한 URL이 아닙니다.',
    'after'=> ':Date 이후 날짜여야 합니다.',
    'after_or_equal'=> ':Date 이후 날짜이거나 같은 날짜여야 합니다.',
    'alpha'=> '이 필드는 문자만 포함할 수 있습니다.',
    'alpha_dash'=> '이 필드는 문자, 숫자, 대쉬(-), 밑줄(_)만 포함할 수 있습니다.',
    'alpha_num'=> '이 필드는 문자와 숫자만 포함할 수 있습니다.',
    'array'=> '이 필드는 배열이어야 합니다.',
    'ascii'=> '이 필드에는 1바이트 영숫자 문자 및 기호만 포함해야 합니다.',
    'attached'=> '이 필드는 이미 첨부되어 있습니다.',
    'before'=> ':Date 이전 날짜여야 합니다.',
    'before_or_equal'=> ':Date 이전 날짜이거나 같은 날짜여야 합니다.',
    'between' => [
        'array' => '이 배열의 항목 수는 :min에서 :max 개의 항목이 있어야 합니다.',
        'file'=> '이 파일의 용량은 :min에서 :max 킬로바이트 사이여야 합니다.',
        'numeric'=> '이 값은 :min에서 :max 사이여야 합니다.',
        'string'=> '이 문자열의 길이는 :min에서 :max 문자 사이여야 합니다.',
    ],
    'boolean'=> '이 필드는 true 또는 false 이어야 합니다.',
    'can'=> '이 필드에는 승인되지 않은 값이 포함되어 있습니다.',
    'confirmed'=> '확인 항목이 일치하지 않습니다.',
    'country'=> '이 필드는 유효한 국가가 아닙니다.',
    'date'=> '유효한 날짜가 아닙니다.',
    'date_equals'=> ':Date과(와) 같은날짜여야합니다.',
    'date_format'=> ':Format 형식과 일치하지 않습니다.',
    'decimal'=> '이 필드에는 소수점 이하 :decimal자리가 있어야 합니다.',
    'declined'=> '이 필드는 거부되어야 합니다',
    'declined_if'=> ':Other이(가) :value일때 이 필드는 거부되어야 합니다.',
    'different'=> '이 값과 :other은(는) 서로 달라야 합니다.',
    'digits'=> ':Digits 자리 숫자여야 합니다.',
    'digits_between'=> ':Min에서 :max 자리 사이여야 합니다.',
    'dimensions'=> '올바르지 않는 이미지 크기입니다.',
    'distinct'=> '이 필드에 중복된 값이 있습니다.',
    'doesnt_end_with'=> '이 필드는 다음 중 하나로 끝나지 않을 수 있습니다: :values.',
    'doesnt_start_with'=> '이 필드는 다음 중 하나로 시작할 수 없습니다: :values.',
    'email'=> '유효한 이메일 주소여야 합니다.',
    'ends_with'=> '다음 중 하나로 끝나야 합니다: :values.',
    'enum'=> '올바른 값이 아닙니다.',
    'exists'=> '존재하지 않습니다.',
    'file'=> '파일이어야 합니다.',
    'filled'=> '이 필드는 값이 있어야 합니다.',
    'gt' => [
        'array'=> '이 배열의 항목 수는 :value개 보다 많아야 합니다.',
        'file'=> '이 파일의 용량은 :value킬로바이트보다 커야 합니다.',
        'numeric'=> '이 값은 :value보다 커야 합니다.',
        'string'=> '이 문자열의 길이는 :value보다 길어야 합니다.',
    ],
    'gte' => [
        'array'=> '이 배열의 항목 수는 :value개 보다 같거나 많아야 합니다.',
        'file'=> '이 파일의 용량은 :value킬로바이트보다 같거나 커야 합니다.',
        'numeric'=> '이 값은 :value보다 같거나 커야 합니다.',
        'string'=> '이 문자열의 길이는 :value보다 같거나 길어야 합니다.',
    ],
    'image'=> '이미지여야 합니다.',
    'in'=> '선택된 값은 올바르지 않습니다.',
    'in_array'=> '이 값은 :other에 존재하지 않습니다.',
    'integer'=> '정수여야 합니다.',
    'ip'=> '유효한 IP 주소여야 합니다.',
    'ipv4'=> '유효한 IPv4 주소여야 합니다.',
    'ipv6'=> '유효한 IPv6 주소여야 합니다.',
    'json'=> 'JSON 문자열이어야 합니다.',
    'lowercase'=> '이 필드는 소문자여야 합니다.',
    'lt' => [
        'array'=> '이 배열의 항목 수는 :value개 보다 작아야 합니다.',
        'file'=> '이 파일의 용량은 :value킬로바이트보다 작아야 합니다.',
        'numeric'=> '이 값은 :value보다 작아야 합니다.',
        'string'=> '이 문자열의 길이는 :value보다 짧아야 합니다.',
    ],
    'lte' => [
        'array'=> '이 배열의 항목 수는 :value개 보다 같거나 작아야 합니다.',
        'file'=> '이 파일의 용량은 :value킬로바이트보다 같거나 작아야 합니다.',
        'numeric'=> '이 값은 :value보다 같거나 작아야 합니다.',
        'string'=> '이 문자열의 길이는 :value보다 같거나 짧아야 합니다.',
    ],
    'mac_address'=> '올바른 MAC 주소가 아닙니다.',
    'max' => [
        'array'=> '이 배열의 항목 수는 :max개보다 많을 수 없습니다.',
        'file'=> '이 파일의 용량은 :max킬로바이트보다 클 수 없습니다.',
        'numeric'=> '이 값은 :max보다 클 수 없습니다.',
        'string'=> '이 문자열의 길이는 :max자보다 클 수 없습니다.',
    ],
    'max_digits'=> '이 필드는 :max자리를 초과할 수 없습니다.',
    'mimes'=> '다음의 파일 형식이어야 합니다: :values.',
    'mimetypes'=> '다음의 파일 형식이어야 합니다: :values.',
    'min' => [
        'array'=> '이 배열의 항목 수는 최소한 :min개의 항목이 있어야 합니다.',
        'file'=> '이 파일의 용량은 최소한 :min킬로바이트이어야 합니다.',
        'numeric'=> '이 값은 최소한 :min이어야 합니다.',
        'string'=> '이 문자열의 길이는 최소한 :min자이어야 합니다.',
    ],
    'min_digits'=> '이 필드는 :min자리 이상이어야 합니다.',
    'missing'=> '이 필드는 누락되어야 합니다.',
    'missing_if'=> ':Other이 :value일 때 이 필드는 누락되어야 합니다.',
    'missing_unless'=> ':Other이 :value이 아닌 경우 이 필드는 누락되어야 합니다.',
    'missing_with'=> '이 필드는 :values이 있는 경우 누락되어야 합니다.',
    'missing_with_all'=> '이 필드는 :values개가 있는 경우 누락되어야 합니다.',
    'multiple_of'=> '이 값은 :value 의 배수여야 합니다.',
    'not_in'=> '선택된 값은 올바르지 않습니다.',
    'not_regex'=> '형식이 올바르지 않습니다.',
    'numeric'=> '숫자여야 합니다.',
    'password' => [
        'password.letters'=> '이 필드에는 최소한 하나의 문자가 포함되어야 합니다.',
        'password.mixed'=> '이 필드는 적어도 하나의 대문자와 하나의 소문자를 포함해야 합니다.',
        'password.numbers'=> '이 필드에는 하나 이상의 숫자가 포함되어야 합니다.',
        'password.symbols'=> '이 필드에는 하나 이상의 기호가 포함되어야 합니다.',
        'password.uncompromised'=> '제공된 필드가 데이터 유출에 나타났습니다. 다른 필드를 선택하십시오.',
    ],
    'present'=> '이 필드가 있어야 합니다.',
    'prohibited'=> '이 필드는 금지되어 있습니다.',
    'prohibited_if'=> '이 필드는 :other 이(가) :value 인 경우 금지되어 있습니다.',
    'prohibited_unless'=> '이 필드는 :other 이(가) :value 이(가) 아닌 경우 금지되어 있습니다.',
    'prohibits'=> '이 필드는 :other을(를) 금지합니다.',
    'regex'=> '형식이 올바르지 않습니다.',
    'relatable'=> '이 필드는이 리소스와 연결되지 않을 수도 있습니다.',
    'required'=> '이 필드는 필수입니다.',
    'required_array_keys'=> '이 필드에는 다음 항목이 포함되어야 합니다. :values.',
    'required_if'=> ':Other이(가) :value 일 때 이 필드는 필수입니다.',
    'required_if_accepted'=> '이 필드는 :other이 허용될 때 필수입니다.',
    'required_unless'=> ':Other이(가) :values에 없다면 이 필드는 필수입니다.',
    'required_with'=> ':Values이(가) 있는 경우이 필드는 필수입니다.',
    'required_with_all'=> ':Values이(가) 모두 있는 경우 이 필드는 필수입니다.',
    'required_without'=> ':Values이(가) 없는 경우 이 필드는 필수입니다.',
    'required_without_all'=> ':Values이(가) 모두 없는 경우 이 필드는 필수입니다.',
    'same'=> '이 필드의 값과 :other은(는) 일치해야 합니다.',
    'size' =>[
        'size.array'=> '이 배열은 :size개의 항목을 포함해야 합니다.',
        'size.file'=> '이 파일의 용량은 :size킬로바이트여야 합니다.',
        'size.numeric'=> '이 값은 :size (이)여야 합니다.',
        'size.string'=> '이 문자열의 길이는 :size자여야 합니다.',
    ],
    'starts_with'=> ':Values 중 하나로 시작해야 합니다.',
    'string'=> '문자열이어야 합니다.',
    'timezone'=> '올바른 시간대 이어야 합니다.',
    'ulid'=> '이 필드는 유효한 ULID여야 합니다.',
    'unique'=> '이미 사용 중입니다.',
    'uploaded'=> '업로드하지 못했습니다.',
    'uppercase'=> '이 필드는 대문자여야 합니다.',
    'url'=> '형식이 올바르지 않습니다.',
    'uuid'=> '유효한UUID여야합니다.',

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
        'session_current_count.lt' => 'PT 진행한 횟수가 총 횟수보다 많습니다. 확인해주세요!',
        'regular_exercise_days.*.day.in' => 'Check all your days in exercise days.'
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
];
