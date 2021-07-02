<?php

namespace App\Http\Requests\Manage;

use App\Http\Requests\ApiBaseRequest;

class UserRegisterRequest extends ApiBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user.email'              => 'required|email|max:255',
            'charges.*.name'          => 'required|min:1|max:255',
            'charges.*.phone'         => 'required|max:16',
            'charges.*.email'         => 'required|unique:charges,email|email|max:255',
            'charges.*.password'      => 'nullable|max:255',
            'charges.*.editType'      => 'required|in:0,1',
            'charges.*.contractPrice' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'user.email'              => 'メールアドレス',
            'charges.*.name'          => '担当者',
            'charges.*.phone'         => '担当者携帯電話',
            'charges.*.email'         => '担当者メールアドレス',
            'charges.*.password'      => '担当者パスワード',
            'charges.*.editType'      => '担当者タイプ',
            'charges.*.phone'         => '担当者携帯電話',
            'charges.*.contractPrice' => '契約金額',
        ];
    }

    public function messages()
    {
        return [
            '*.required'                                 => ':attributeは必須です。',
            '*.max'                                      => ':attributeは:max文字以下で入力してください。',
            '*.min'                                      => ':attributeは:min文字以上で入力してください。',
            '*.integer'                                  => ':attributeは数値で入力してください。',
            '*.digits'                                   => ':attributeは:digits桁で入力してください。',
            '*.digits_between'                           => ':attributeは:min～:max桁で入力してください。',
            '*.in'                                       => ':attributeの値が範囲外です。',
        ];
    }
}
