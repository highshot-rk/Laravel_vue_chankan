<?php

namespace App\Http\Requests;

class AdvertisementStoreRequest extends ApiBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'advertisement.company' => 'required|max:255',
            'advertisement.url'     => 'required|max:255',
            'advertisement.tel'     => 'required|max:16',
            'advertisement.charge'  => 'required|max:255',
            'advertisement.email'   => 'required|email|max:255',
            'advertisement.phone'   => 'required|max:16',
            'advertisement.zip'     => 'required|digits:7',
            'advertisement.address' => 'required|max:255',
            'image'                 => 'required|mimes:jpeg,bmp,png|max:10240',
            'contract.period'       => 'required|max:255',
            'contract.price'        => 'required|integer',
        ];
    }

    public function attributes()
    {
        return [
            'advertisement.company' => '会社名',
            'advertisement.url'     => 'URL',
            'advertisement.tel'     => '電話番号',
            'advertisement.charge'  => '担当者名',
            'advertisement.email'   => 'メールアドレス',
            'advertisement.phone'   => '携帯電話',
            'advertisement.zip'     => '郵便番号',
            'advertisement.address' => '住所',
            'image'                 => '画像',
            'contract.period'       => '契約期間',
            'contract.price'        => '金額',
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
            'image.max'                                  => ':attributeは:maxMB以下で入力してください。',
            '*.mimes'                                    => ':attributeは:valuesタイプのファイルにしてください。',
        ];
    }
}
