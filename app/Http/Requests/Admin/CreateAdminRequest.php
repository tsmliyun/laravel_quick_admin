<?php
/**
 * Created by PhpStorm.
 * User: yunli
 * Date: 2019/4/30
 * Time: 下午2:27
 */

namespace App\Http\Requests\Admin;


use App\Http\Requests\Request;

class CreateAdminRequest extends Request
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
            'username' => 'nullable|string|max:32',
            'email' => 'email',
            'phone' => 'nullable|string|max:11',
            'pass' => 'required',
            'confirm_pass' => 'required',
            'role_id' => 'nullable|integer'
        ];
    }
}