<?php

namespace App\Http\Requests\Manage;

use App\Http\Requests\ApiBaseRequest;

class UserEditRequest extends ApiBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user.email'         => 'email|max:255',
            'user.company'       => 'max:255',
            'user.phone'         => 'max:16',
            'user.prefecture.id' => 'integer',
            'charge.*.name'      => 'max:255',
            'charge.*.phone'     => 'max:16',
        ];
    }

    public function attributes()
    {
        return [
            'user.email'         => 'メールアドレス',
            'user.company'       => '会社名',
            'user.phone'         => '携帯番号',
            'charge.*.name'      => '担当者名',
            'charge.*.phone'     => '担当者携帯電話',
        ];
    }

    public function messages()
    {
        return [
            '*.required'                                 => ':attributeは必須です。',
            '*.max'                                      => ':attributeは:max文字以下で入力してください。',
            '*.min'                                      => ':attributeは:min文字以上で入力してください。',
            'project.work_on_date.*.work_on.date_format' => ':attributeは必須です。',
            '*.integer'                                  => ':attributeは数値で入力してください。',
            '*.digits'                                   => ':attributeは:digits桁で入力してください。',
            '*.digits_between'                           => ':attributeは:min～:max桁で入力してください。',
        ];
    }
}
