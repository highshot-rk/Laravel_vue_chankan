<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserMainRegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'                => 'required|max:255',
            'company'             => 'required|max:255',
            'phone'               => 'max:16',
            'password'            => 'required|max:255',
            'prefecture_id'       => 'required|integer',
            'charges.*.name'      => 'required|max:255',
            'charges.*.phone'     => 'required|max:16',
            'charges.*.email'     => 'required|email|max:255',
            'charges.*.password'  => 'required|max:255',
            'charges.*.edit_type' => 'required|in:0,1',
        ];
    }

    public function attributes()
    {
        return [
            'name'                => '名前',
            'company'             => '会社名',
            'phone'               => '携帯番号',
            'password'            => 'パスワード',
            'prefecture_id'       => '都道府県',
            'charges.*.name'      => '担当者名',
            'charges.*.email'     => '担当者メールアドレス',
            'charges.*.password'  => '担当者パスワード',
            'charges.*.edit_type' => '担当者タイプ',
            'charges.*.phone'     => '担当者携帯電話',
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
            '*.in'                                       => ':attributeの値が範囲外です。',
        ];
    }
}
