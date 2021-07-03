<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class ChargeStoreRequest extends FormRequest
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
            'user_id'   => 'required',
            'password'  => 'required|min:8',
            // 'phone'     => 'required|unique:charges|digits_between:11, 16',
            // 'phone'     => 'required|unique:charges,phone,deleted_at,NULL|digits_between:11, 16',
            // 'phone'     => [Rule::unique('users', 'email')->whereNull('deleted_at')],
            'phone'     => ['required', 'digits:11', Rule::unique('charges')->whereNull('deleted_at')],
            'name'      => 'required|max:255',
            'edit_type' => 'required',
        ];
    }

    /**
     * 定義済みバリデーションルールのエラーメッセージ取得
     *
     * @return array
     */
    public function messages()
    {
        return [
            'user_id.required'   => 'ユーザー情報は必須です。',
            'password.required'  => 'パスワードは必須です。',
            'password.min'       => 'パスワードは最低8文字以上です。',
            'phone.required'     => '電話番号は必須です。',
            'phone.digits'       => '電話番号は半角数字で11桁です。',
            'phone.unique'       => '電話番号が既に使用されています。',
            'name.required'      => '名前は必須です。',
            'name.max'           => '名前は255文字以内です。',
            'edit_type.required' => '編集タイプは必須です。',
        ];
    }
}
