<?php
/**
 * Created by PhpStorm.
 * User: yunli
 * Date: 2019/4/28
 * Time: 下午9:15
 */

namespace App\Http\Requests;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class Request extends FormRequest
{

    /**
     * 重写返回错误消息的方法
     * @param Validator $validator
     * @user yun.li
     * @time 2019/4/28 下午9:22
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => 'request process error',
            'error' => [
                'code' => '400',
                'message' => $validator->errors()->first()
            ]
        ]));
    }
}