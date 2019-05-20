<?php
/**
 * Created by PhpStorm.
 * User: yunli
 * Date: 2019/4/30
 * Time: 下午1:33
 */

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
            'username' => 'nullable|string',
            'email' => 'nullable|email',
            'status' => 'nullable|integer',
            'page' => 'nullable|integer',
            'pageCount' => 'nullable|integer',
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