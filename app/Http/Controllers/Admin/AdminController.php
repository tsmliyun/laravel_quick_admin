<?php
/**
 * Created by PhpStorm.
 * User: yunli
 * Date: 2019/5/16
 * Time: 下午7:23
 */

namespace App\Http\Controllers\Admin;


use App\Http\Requests\Admin\AdminRequest;
use App\Http\Requests\Admin\CreateAdminRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Http\Requests\Admin\UpdatePwdRequest;
use App\Logs\QALog;
use App\Services\RoleService;
use App\Services\UserService;
use Illuminate\Http\Request;

class AdminController extends BaseController
{

    /**
     * 日志文件
     */
    const LOG_FILE = 'crm';

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var RoleService
     */
    private $lmRoleService;

    public function __construct(UserService $userService, RoleService $roleService)
    {
        $this->userService = $userService;
        $this->lmRoleService = $roleService;
    }

    /**
     * 管理员列表页
     * @param AdminRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @user yun.li
     * @time 2019/5/20 上午12:23
     */
    public function index(AdminRequest $request)
    {
        $requestData             = $request->all();
        $requestData['is_admin'] = 1;
        $result                  = $this->userService->getUserList($requestData);
        $title                   = '管理员列表';
        $data                    = compact('result', 'title', 'requestData');
        return view('admin.admin.index', $data);
    }

    /**
     * 新增管理员
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @user yun.li
     * @time 2019/5/20 上午12:24
     */
    public function create()
    {
        $title = '添加管理员';
        $roles = $this->lmRoleService->getAllRole();
        $data  = compact('title','roles');
        return view('admin.admin.create', $data);
    }

    /**
     * 新增管理员
     * @param CreateAdminRequest $request
     * @return mixed
     * @user yun.li
     * @time 2019/4/30 下午2:37
     */
    public function store(CreateAdminRequest $request)
    {
        $requestData = $request->all();
        if ($requestData['pass'] != $requestData['confirm_pass']) {
            return $this->error('params_error', trans('admin.confirm_pass_error'));
        }
        try {
            $result = $this->userService->addUser($requestData);
            // 设置角色
            if (!empty($requestData['role_id'])) {
                $roleId = is_array($requestData['role_id']) ? $requestData['role_id'] : [$requestData['role_id']];
                $this->userService->updateUserRole($result->id, $roleId);
            }
            return $this->success();
        } catch (\Exception $e) {
            $errorData = [
                'errMsg'      => $e->getMessage(),
                'errTrace'    => $e->getTraceAsString(),
                'requestData' => $requestData,
            ];
            QALog::error(__METHOD__, $errorData, self::LOG_FILE);
            return $this->error('service_error', trans('common.service_error'));
        }
    }

    /**
     * 编辑管理员
     * @param Request $request
     * @return mixed
     * @user yun.li
     * @time 2019/4/30 下午3:34
     */
    public function edit(Request $request)
    {
        $userId = $request->input('user_id', 0);
        if (empty($userId)) {
            return $this->errorBackTo(['error' => trans('common.params_error')]);
        }
        $result = $this->userService->getUserById($userId);
        $roles = $this->lmRoleService->getAllRole();
        $data = compact('result','roles');
        return view('admin.admin.edit',$data);
    }

    /**
     * 编辑管理员-提交
     * @param UpdateAdminRequest $request
     * @return mixed
     * @user yun.li
     * @time 2019/4/30 下午3:48
     */
    public function update(UpdateAdminRequest $request)
    {
        $requestData = $request->all();
        try {
            $updateData = $requestData;
            unset($updateData['user_id'], $updateData['role_id'],$updateData['_token']);
            $this->userService->updateUserById($updateData, $requestData['user_id']);
            // 设置角色
            if (!empty($requestData['role_id'])) {
                $roleId = is_array($requestData['role_id']) ? $requestData['role_id'] : [$requestData['role_id']];
                $this->userService->updateUserRole($requestData['user_id'], $roleId);
            }
            return $this->success();
        } catch (\Exception $e) {
            $errorData = [
                'errMsg'      => $e->getMessage(),
                'errTrace'    => $e->getTraceAsString(),
                'requestData' => $requestData,
            ];
            QALog::error(__METHOD__, $errorData, self::LOG_FILE);
            return $this->error('service_error', trans('common.service_error'));
        }
    }

    /**
     * 删除管理员(软删除)
     * @param Request $request
     * @return mixed
     * @user yun.li
     * @time 2019/4/30 下午4:33
     */
    public function destroy(Request $request)
    {
        $userId = $request->input('user_id', 0);
        if (empty($userId)) {
            return $this->error('params_error', trans('common.params_error'));
        }
        try {
            $this->userService->deleteUserById($userId);
            return $this->success();
        } catch (\Exception $e) {
            $errorData = [
                'errMsg'      => $e->getMessage(),
                'errTrace'    => $e->getTraceAsString(),
                'requestData' => $request->all(),
            ];
            QALog::error(__METHOD__, $errorData, self::LOG_FILE);
            return $this->error('service_error', trans('common.service_error'));
        }
    }

    /**
     * 修改密码-view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @user yun.li
     * @time 2019/5/20 上午12:24
     */
    public function editPwd()
    {
        $title = '修改密码';
        $data  = compact('title');
        return view('admin.admin.edit_pwd', $data);
    }

    /**
     * 修改密码
     * @param UpdatePwdRequest $request
     * @return mixed
     * @user yun.li
     * @time 2019/4/30 下午5:59
     */
    public function updatePwd(UpdatePwdRequest $request)
    {
        $requestData = $request->all();
        $userInfo    = UserService::getUserInfo();
        if (!\Hash::check($requestData['old_pwd'], $userInfo->password)) {
            return $this->error('params_error', trans('admin.old_pass_error'));
        }
        if ($requestData['new_pwd'] != $requestData['confirm_new_pwd']) {
            return $this->error('params_error', trans('admin.confirm_pass_error'));
        }
        try {
            $updateData = [
                'password' => bcrypt($requestData['new_pwd'])
            ];
            $this->userService->updateUserById($updateData, $userInfo->id);
            return $this->success();
        } catch (\Exception $e) {
            $errorData = [
                'errMsg'      => $e->getMessage(),
                'errTrace'    => $e->getTraceAsString(),
                'requestData' => $requestData,
            ];
            QALog::error(__METHOD__, $errorData, self::LOG_FILE);
            return $this->error();
        }
    }
}