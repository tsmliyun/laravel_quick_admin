<?php
/**
 * Created by PhpStorm.
 * User: yunli
 * Date: 2019/4/30
 * Time: 下午1:33
 */

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class LoginRequest extends Request
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
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

//    /**
//     * Get the validation message that apply to the request
//     *
//     * @return array
//     */
//    public function messages()
//    {
//        return []
//    }
}