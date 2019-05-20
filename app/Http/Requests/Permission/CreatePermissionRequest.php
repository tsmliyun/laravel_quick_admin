<?php
/**
 * Created by PhpStorm.
 * User: yunli
 * Date: 2019/5/7
 * Time: 上午10:34
 */

namespace App\Http\Requests\Permission;


use App\Http\Requests\Request;

class CreatePermissionRequest extends Request
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
            'parent_id' => 'nullable|integer',
            'title' => 'required|string',
            'icon' => 'nullable|string',
            'path' => 'nullable|string',
            'is_menu' => 'nullable|integer',
            'sort' => 'nullable|integer',
            'status' => 'nullable|integer'
        ];
    }
}