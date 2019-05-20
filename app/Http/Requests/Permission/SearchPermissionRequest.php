<?php
/**
 * Created by PhpStorm.
 * User: yunli
 * Date: 2019/4/30
 * Time: 下午1:33
 */

namespace App\Http\Requests\Permission;

use App\Http\Requests\Request;

class SearchPermissionRequest extends Request
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
            'title' => 'nullable|string',
            'status' => 'nullable|integer',
            'page' => 'nullable|integer',
            'pageCount' => 'nullable|integer',
        ];
    }
}