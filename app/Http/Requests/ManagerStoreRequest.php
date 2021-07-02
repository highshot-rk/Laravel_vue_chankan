<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManagerStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'     => 'required|max:255',
            'email'    => 'required|email|max:255',
            'password' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'name'     => '名前',
            'email'    => 'メールアドレス',
            'password' => 'パスワード',
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
