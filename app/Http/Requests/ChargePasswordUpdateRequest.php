<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChargePasswordUpdateRequest extends FormRequest
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
            'password' => 'required|max:255',
            'password_confirm' => 'same:password',
        ];
    }

    public function attributes()
    {
        return [
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
            '*.same'                => 'パスワードが確認用のものと一致しません。',
        ];
    }
}
