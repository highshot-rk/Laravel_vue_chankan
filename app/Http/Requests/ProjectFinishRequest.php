<?php

namespace App\Http\Requests;

/**
 * 案件完了登録時のバリデーション
 */
class ProjectFinishRequest extends ApiBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->image == 'null') {
            return [
                'image' => 'nullable'
            ];
        }
        return [
            'image' => 'mimes:jpeg,bmp,png|max:10240'
        ];
    }

    public function attributes()
    {
        return [
            'image' => '画像'
        ];
    }

    public function messages()
    {
        return [
            '*.max'      => ':attributeは:maxMB以下で入力してください。',
            '*.mimes'    => ':attributeは:valuesタイプのファイルにしてください。',
        ];
    }
}
