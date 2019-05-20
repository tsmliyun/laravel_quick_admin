<?php
/**
 * Created by PhpStorm.
 * User: yunli
 * Date: 2019/5/19
 * Time: 下午1:17
 */

namespace App\Http\Controllers\Admin;


class IndexController extends BaseController
{
    public function index()
    {
        return view('admin.index');
    }
}