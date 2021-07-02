<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SmsRequest extends ApiBaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    public function attributes()
    {
        return [
            'phone'   => '電話番号',
            'message' => 'メッセージ',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone'   => 'required|min:11|max:15',
            'message' => 'max:70',
        ];
    }

    public function messages()
    {
        return [
            '*.required' => ':attributeは必須です。',
            '*.min'      => ':attributeは:min文字以上で入力してください。',
            '*.max'      => ':attributeは:max文字以下で入力してください。',
        ];
    }
}
