<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserEditRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (\Auth::guard('charge')->check()) {
            return [
                'name'               => 'required|max:255',
                'phone'              => 'required|max:16',
            ];
        }
        return [
            'name'               => 'required|max:255',
            'email'              => 'required|email|max:255',
            'company'            => 'required|max:255',
            'phone'              => 'required|max:16',
            'prefecture_id'      => 'required|integer',
            'charge.*.name'      => 'required|max:255',
            'charge.*.phone'     => 'required|max:16',
            'charge.*.email'     => 'required|email|max:255',
            'charge.*.edit_type' => 'required|in:0,1',
        ];
    }

    public function attributes()
    {
        return [
            'name'               => '名前',
            'email'              => 'メールアドレス',
            'company'            => '会社名',
            'phone'              => '携帯番号',
            'prefecture_id'      => '都道府県',
            'charge.*.name'      => '担当者名',
            'charge.*.phone'     => '担当者携帯番号',
            'charge.*.email'     => '担当者メールアドレス',
            'charge.*.edit_type' => '担当者タイプ',
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
