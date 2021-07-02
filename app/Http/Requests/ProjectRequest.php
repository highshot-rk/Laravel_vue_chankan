<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * 案件情報のバリデーションを行うクラス
 */
class ProjectRequest extends ApiBaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'project.name'                     => 'required|max:255',
            'project.charge_id'                => 'required|integer',
            'project.work_on_date.*.work_on'   => 'date_format:Y-m-d',
            'project.work_on_date.*.time_type' => 'required|integer',
            'project.tel'                      => 'max:16',
            'project.zip'                      => 'nullable|digits:7',
            'project.address'                  => 'required|max:255',
            'project.road'                     => 'required|integer',
            'project.remark'                   => 'max:1000',
        ];

        // 元請け情報の新規登録or既存から選択に対応する、バリデーションを行う
        if ($this->is_new_project_orderer) {
            // 電話番号は後ほど登録するがONの場合、電話番号は必須としない
            if ($this->is_register_phone_later) {
                $rules = array_merge($rules, [
                    'project_orderer.company' => 'required|max:255',
                    'project_orderer.phone'   => 'max:16'
                ]);
            } else {
                $rules = array_merge($rules, [
                    'project_orderer.company' => 'required|max:255',
                    'project_orderer.phone'   => 'required|max:16'
                ]);
            }
        } else {
            $rules = array_merge($rules, [
                'project_orderer_id' => 'required',
            ]);
        }
        return $rules;
    }

    public function attributes()
    {
        return [
            'project.name'                     => '案件名',
            'project.charge_id'                => '担当者',
            'project.work_on_date.*.work_on'   => '施工予定日',
            'project.work_on_date.*.time_type' => '時間タイプ',
            'project.tel'                      => '案件お客様電話番号',
            'project.zip'                      => '郵便番号',
            'project.address'                  => '住所',
            'project.road'                     => '道路規制',
            'project.remark'                   => '備考',
            'project_orderer.company'          => '元請け情報-会社名',
            'project_orderer.phone'            => '元請け情報-電話番号',
            'project_orderer_id'               => '登録済み元請け情報(プルダウン)',
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
