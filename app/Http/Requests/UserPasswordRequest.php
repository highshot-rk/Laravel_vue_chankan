<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserPasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password_now' => 'required|is_current_password',
            // 'password' => 'required|min:8|regex:/^(?=.*?[a-z])(?=.*?\d)[a-z\d]+$/i',
            'password' => 'required|max:255',
            'password_confirmation' => 'same:password',
        ];
    }

    public function attributes()
    {
        return [
            'password_now'     => '現在のパスワード',
            'password'         => 'パスワード',
            'password_confirm' => 'パスワード(確認用)',
        ];
    }

    public function messages()
    {
        return [
            '*.required'            => ':attributeは必須です。',
            '*.max'                 => ':attributeは:max文字以下で入力してください。',
            '*.min'                 => ':attributeは:min文字以上で入力してください。',
            '*.integer'             => ':attributeは数値で入力してください。',
            '*.is_current_password' => '入力した現在のパスワードが正しくありません。',
            '*.same'                => 'パスワードが確認用のものと一致しません。',
        ];
    }
}
