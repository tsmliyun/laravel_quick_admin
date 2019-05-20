<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ResetPwdRequest;
use App\Logs\QALog;
use App\Services\CacheService;
use App\Services\MailService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after auth.
     *
     * @var string
     */
    protected $redirectTo = '/admin/index';

    /**
     * @var UserService
     */
    private $userService;

    const LOG_FILE = 'crm';

    /**
     * Create a new controller instance.
     *
     * @param UserService $userService
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->middleware('guest')->except('logout');
        $this->userService = $userService;
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }


    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {

        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/admin/login');
    }

    /**
     * 找回密码
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @user yun.li
     * @time 2019/5/19 下午2:05
     */
    public function retrievePwd()
    {
        return view('admin.auth.retrieve_pwd');
    }


    /**
     * 重置密码发送邮件
     * @param Request $request
     * @return mixed
     * @user yun.li
     * @time 2019/5/5 下午7:49
     */
    public function retrievePassSendMail(Request $request)
    {
        $email = $request->input('email', '');
        $this->validate($request, [
            'email' => 'required|email'
        ]);
        // 校验邮箱是否存在用户
        $user = $this->userService->getUserByCond(['email' => $email]);
        if (empty($user)) {
            return $this->errorBackTo(['error' => trans('admin.admin_not_exist')]);
        }
        $resetPwdUrl = route('admin.resetPwdView');
        $token       = md5($user->id . $user->username . $user->password);
        $resetPwdUrl .= '?token=' . $token;
        CacheService::setRetrievePwdToken($token, $email, 600);
        QALog::info(__METHOD__, [$email => CacheService::getRetrievePwdToken($email)], 'user');
        $data     = [
            'username' => $user->username ?? '',
            'link'     => $resetPwdUrl,
            'minutes'  => 10,
            'endTime'  => Carbon::now()->addMinute(10)->toDateTimeString(),
            'admin'    => config('crm.mail_list.crm_admin'),
        ];
        $sendData = [
            'subject'     => '密码找回',
            'format'      => 'html',
            'to'          => $email,
            'body'        => 'email.retrieve',
            'attachments' => [],
            'data'        => $data
        ];
        MailService::sendMail($sendData);
        return $this->successBackTo(trans('common.success'));
    }

    /**
     * 密码重置
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @user yun.li
     * @time 2019/5/19 下午4:13
     */
    public function resetPwdView(Request $request)
    {
        $requestData = $request->all();
        $token       = $requestData['token'] ?? '';
        $data        = compact('token');
        return view('admin.auth.reset_pwd', $data);
    }

    /**
     * 重置密码(用户重置)
     * @param ResetPwdRequest $request
     * @return mixed
     * @user yun.li
     * @time 2019/4/30 下午5:16
     */
    public function resetPwd(ResetPwdRequest $request)
    {
        $requestData = $request->all();
        // 获取发送邮件的token 对应的email
        $token = $requestData['token'] ?? '';
        $email = CacheService::getRetrievePwdToken($token);
        if (empty($email)) {
            return $this->errorBackTo(['error' => trans('admin.reset_pwd_link_expired')]);
        }

        $user = $this->userService->getUserByCond(['email' => $email]);
        if (empty($user)) {
            return $this->errorBackTo(['error' => trans('admin.admin_not_exist')]);
        }

        // 判断token是否正确
        $confirmToken = md5($user->id . $user->username . $user->password);
        if ($confirmToken != $token) {
            return $this->errorBackTo(['error' => trans('admin.reset_pwd_link_error')]);
        }

        // 判断两次密码是否一致
        if ($requestData['new_pwd'] != $requestData['confirm_new_pwd']) {
            return $this->errorBackTo(['error' => trans('admin.confirm_pass_error')]);
        }
        try {
            $updateData = [
                'password' => bcrypt($requestData['new_pwd'])
            ];
            $this->userService->updateUserById($updateData, $user->id);
            CacheService::delRetrievePwdToken($token);
            return $this->successRouteTo('admin/login', trans('common.success'));
        } catch (\Exception $e) {
            $errorData = [
                'errMsg'      => $e->getMessage(),
                'errTrace'    => $e->getTraceAsString(),
                'requestData' => $requestData,
            ];
            QALog::error(__METHOD__, $errorData, self::LOG_FILE);
            return $this->errorBackTo(['error' => trans('common.service_error')]);
        }
    }


}
