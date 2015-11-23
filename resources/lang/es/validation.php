<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | El following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */
    'greater_than'         => ':attribute debe ser mayor que :field',
    'less_than'            => ':attribute debe ser menor que :field',
    'mult'                 => ':attribute debe ser igual a :field1 * :field2',
    'accepted'             => ':attribute debe ser aceptado.',
    'active_url'           => ':attribute no es una URL valida.',
    'after'                => ':attribute debe ser una fecha despues de :date.',
    'alpha'                => ':attribute solo puede tener letras.',
    'alpha_dash'           => ':attribute solo puede tener letras, numeros, y guiones.',
    'alpha_num'            => ':attribute solo puede tener letras y numeros.',
    'array'                => ':attribute debe ser un arreglo.',
    'before'               => ':attribute debe ser una fecha antes de :date.',
    'between'              => [
        'numeric' => ':attribute debe de ser entre :min y :max.',
        'file'    => ':attribute debe ser entre :min y :max kilobytes.',
        'string'  => ':attribute debe ser entre :min y :max caracteres.',
        'array'   => ':attribute debe tener entre :min y :max elementos.',
    ],
    'boolean'              => 'campo :attribute debe ser verdadero o falso.',
    'confirmed'            => 'La confirmacion de :attribute no concuerda.',
    'date'                 => ':attribute no es una fecha valida.',
    'date_format'          => ':attribute no concuerda con el formato :format.',
    'different'            => ':attribute y :other deben ser distintos.',
    'digits'               => ':attribute debe tener :digits digitos.',
    'digits_between'       => ':attribute debe tener entre :min y :max digitos.',
    'email'                => ':attribute debe ser un correo electrónico válido.',
    'filled'               => 'campo :attribute es obligatorio.',
    'exists'               => ':attribute seleccionado es invalido.',
    'image'                => ':attribute debe ser una imagen.',
    'in'                   => ':attribute seleccionado es invalido.',
    'integer'              => ':attribute debe ser un entero.',
    'ip'                   => ':attribute deber ser una direccion IP válida.',
    'max'                  => [
        'numeric' => ':attribute no puede ser mayor que :max.',
        'file'    => ':attribute no puede ser mayor que :max kilobytes.',
        'string'  => ':attribute no puede ser mayor que :max caracteres.',
        'array'   => ':attribute no puede tener más de :max elementos.',
    ],
    'mimes'                => ':attribute debe de ser un archivo de tipo: :values.',
    'min'                  => [
        'numeric' => ':attribute debe de ser al menos :min.',
        'file'    => ':attribute debe de ser al menos :min kilobytes.',
        'string'  => ':attribute debe de ser al menos :min caracteres.',
        'array'   => ':attribute debe tener cuando menos :min elementos.',
    ],
    'not_in'               => ':attribute seleccionado es invalido.',
    'numeric'              => ':attribute debe de ser un numero.',
    'regex'                => 'El formato de :attribute es invalido.',
    'required'             => 'El campo :attribute es obligatorio.',
    'required_if'          => 'El campo :attribute es obligatorio cuando :other es :value.',
    'required_with'        => 'El campo :attribute es obligatorio cuando :values esta presente.',
    'required_with_all'    => 'El campo :attribute es obligatorio cuando :values esta presente.',
    'required_without'     => 'El campo :attribute es obligatorio cuando :values no está presente.',
    'required_without_all' => 'El campo :attribute es obligatorio cuando ninguno de :values están presentes.',
    'same'                 => ':attribute y :other deben coincidir.',
    'size'                 => [
        'numeric' => ':attribute debe ser :size.',
        'file'    => ':attribute debe ser :size kilobytes.',
        'string'  => ':attribute debe ser :size caracteres.',
        'array'   => ':attribute debe contener :size elementos.',
    ],
    'string'               => ':attribute debe de ser texto.',
    'timezone'             => ':attribute debe de ser una zona valida.',
    'unique'               => ':attribute ya existe.',
    'unique_with'          => ':attribute ya existe en combinación con otros campos.',
    'url'                  => 'El formato :attribute es inválido.',

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
    | El following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => []

];
