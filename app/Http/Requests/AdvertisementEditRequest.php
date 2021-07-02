<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdvertisementEditRequest extends ApiBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'company' => 'required|max:255',
            'url'     => 'required|max:255',
            'tel'     => 'required|max:16',
            'charge'  => 'required|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'required|max:16',
            'zip'     => 'required|digits:7',
            'address' => 'required|max:255',
        ];
    }

    public function attributes()
    {
        return [
            'company' => '会社名',
            'url'     => 'URL',
            'tel'     => '電話番号',
            'charge'  => '担当者名',
            'email'   => 'メールアドレス',
            'phone'   => '携帯電話',
            'zip'     => '郵便番号',
            'address' => '住所',
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
