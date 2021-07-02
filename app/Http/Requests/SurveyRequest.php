<?php

namespace App\Http\Requests;

class SurveyRequest extends ApiBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image' => 'nullable|mimes:jpeg,bmp,png|max:10240',
        ];
    }

    public function attributes()
    {
        return [
            'image' => '画像',
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
            'image.max'                                  => ':attributeは:maxMB以下で入力してください。',
            '*.mimes'                                    => ':attributeは:valuesタイプのファイルにしてください。',
        ];
    }
}
