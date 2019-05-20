<?php
/**
 * Created by PhpStorm.
 * User: yunli
 * Date: 2019/5/16
 * Time: 下午7:24
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    /**
     * 成功时路由跳转
     * @param $route
     * @param $message
     * @return mixed
     * @user yun.li
     * @time 2019/5/19 下午4:38
     */
    public function successRouteTo($route, $message)
    {
        return redirect($route)->withSuccess($message);
    }

    /**
     * 成功时返回当前页
     * @param $message
     * @return mixed
     * @user yun.li
     * @time 2019/5/19 下午4:39
     */
    public function successBackTo($message)
    {
        return redirect()->back()->withSuccess($message);
    }

    /**
     * 失败时路由跳转
     * @param $route
     * @param $message
     * @return $this
     * @user yun.li
     * @time 2019/5/19 下午4:39
     */
    public function errorRouteTo($route, $message)
    {
        return redirect($route)->withErrors($message);
    }

    /**
     * 失败时返回当前页
     * @param $message
     * @return $this
     * @user yun.li
     * @time 2019/5/19 下午4:39
     */
    public function errorBackTo($message)
    {
        return redirect()->back()->withErrors($message)->withInput();
    }

    /**
     * 请求成功返回结果
     * @param $data
     * @param string $message
     * @return mixed
     * @user yun.li
     * @time 2019/4/28 下午11:10
     */
    public function success($data = [], string $message = 'request process ok')
    {
        $result = [
            'status'  => 'ok',
            'message' => $message,
            'data'    => !empty($data) ? $data : json_decode('{}')
        ];
        return response()->json($result);
    }

    /**
     * 请求失败返回结果
     * @param string $code
     * @param string $message
     * @param string $errMsg
     * @return mixed
     * @user yun.li
     * @time 2019/4/28 下午11:11
     */
    public function error(string $code = 'service_error', string $errMsg = '', string $message = 'request process error')
    {
        $result = [
            'status'  => 'error',
            'message' => $message,
            'error'   => [
                'code'    => config('response_code.' . $code),
                'message' => empty($errMsg) ? trans('common.service_error') : $errMsg,
            ]
        ];
        return response()->json($result);
    }

}