<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ChargeUpdateRequest extends FormRequest
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
    public function rules(Request $request)
    {
        // dd($request->charge_id);
        return [
            // 'phone'     => 'required|unique:charges|digits_between:11, 16',
            'phone'     => [
                'required',
                // 'unique:charges',
                Rule::unique('charges')->ignore($request->charge_id),
                'digits:11',
            ],
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
            'phone.required'     => '電話番号は必須です。',
            'phone.digits'       => '電話番号は半角数字で11桁です。',
            'phone.unique'       => '電話番号が既に使用されています。',
            'name.required'      => '名前は必須です。',
            'name.max'           => '名前は255文字以内です。',
            'edit_type.required' => '編集タイプは必須です。',
        ];
    }
}
