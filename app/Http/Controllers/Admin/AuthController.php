<?php
/**
 * Created by PhpStorm.
 * User: yunli
 * Date: 2019/5/16
 * Time: 下午7:23
 */

namespace App\Http\Controllers\Admin;


class AuthController extends BaseController
{
    public function login()
    {
        return view('auth.login');
    }
}