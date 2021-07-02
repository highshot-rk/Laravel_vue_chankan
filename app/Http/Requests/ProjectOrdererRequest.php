<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectOrdererRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone'          => 'required|max:16|regex:/^[0-9]{10,12}$/',
            'company'        => 'required|max:255',
            'company_kana'   => [
                'nullable',
                'max:255',
                'regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u',
            ],
            'zip_first'      => 'nullable|digits:3',
            'zip_second'     => 'nullable|digits:4',
            'president'      => 'max:255',
            'president_kana' => [
                'nullable',
                'max:255',
                'regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u',
            ],
            'email'          => 'nullable|email|max:255',
            'tel'            => 'nullable|max:16|regex:/^[0-9]{10,12}$/',
            'fax'            => 'nullable|max:16|regex:/^[0-9]{10,12}$/',
            'remark'         => 'max:10000',
        ];
    }

    public function attributes()
    {
        return [
            'phone'          => '携帯電話',
            'company'        => '会社名',
            'company_kana'   => '会社名カナ',
            'zip_first'      => '郵便番号(前3桁)',
            'zip_second'     => '郵便番号(後4桁)',
            'president'      => '代表者名',
            'president_kana' => '代表者名カナ',
            'email'          => 'メールアドレス',
            'tel'            => '電話番号',
            'fax'            => 'FAX',
            'remark'         => '備考',
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
