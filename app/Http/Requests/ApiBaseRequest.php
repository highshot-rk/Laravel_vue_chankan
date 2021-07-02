<?php

namespace App\Http\Requests;

use App\Exceptions\BadRequestErrorResponseException;
// バリデーション用のFormRequestクラス
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class ApiBaseRequest extends FormRequest
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

    protected function failedValidation(Validator $validator)
    {
        throw new BadRequestErrorResponseException(
            $validator->errors()->toArray()
        );
    }
}
