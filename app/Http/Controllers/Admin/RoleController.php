<?php
/**
 * Created by PhpStorm.
 * User: yunli
 * Date: 2019/5/6
 * Time: 下午5:58
 */

namespace App\Http\Controllers\Admin;


use App\Logs\QALog;
use App\Services\PermissionService;
use App\Services\RoleService;
use Illuminate\Http\Request;

class RoleController extends BaseController
{
    /**
     * 日志文件
     */
    const LOG_FILE = 'crm';

    /**
     * @var RoleService
     */
    private $lmRoleService;

    public function __construct(RoleService $lmRoleService)
    {
        $this->lmRoleService = $lmRoleService;
    }

    /**
     * 列表查询
     * @param Request $request
     * @return mixed
     * @user yun.li
     * @time 2019/5/6 下午6:45
     */
    public function index(Request $request)
    {
        $requestData             = $request->all();
        $requestData['is_admin'] = 1;
        $result                  = $this->lmRoleService->getLists($requestData);
        $title                   = '角色列表';
        $data                    = compact('result', 'title', 'requestData');
        return view('admin.role.index', $data);
    }

    /**
     * 添加角色-view
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @user yun.li
     * @time 2019/5/20 下午4:31
     */
    public function create(Request $request)
    {
        $requestData = $request->all();
        $title       = '添加角色';
        $result      = [];
        $postUrl     = route('role.store');
        $data        = compact('title', 'requestData', 'result', 'postUrl');
        return view('admin.role.create', $data);
    }

    /**
     * 新增角色
     * @param Request $request
     * @return mixed
     * @user yun.li
     * @time 2019/5/6 下午6:19
     */
    public function store(Request $request)
    {
        $name   = $request->input('name', '');
        $status = $request->input('status', 1);
        if (empty($name)) {
            return $this->error('params_error', trans('admin.role_name_required'));
        }
        try {
            $createData = [
                'name'   => (string)$name,
                'status' => $status
            ];
            $this->lmRoleService->createRole($createData);
            return $this->success();
        } catch (\Exception $e) {
            $errData = [
                'errMsg'      => $e->getMessage(),
                'errTrace'    => $e->getTraceAsString(),
                'requestData' => $request->all(),
            ];
            QALog::error(__METHOD__, $errData, self::LOG_FILE);
            return $this->error('service_error', trans('common.service_error'));
        }
    }

    /**
     * 查看单个角色详情
     * @param Request $request
     * @return mixed
     * @user yun.li
     * @time 2019/5/6 下午6:26
     */
    public function edit(Request $request)
    {
        $id = $request->input('id', 0);
        if (empty($id)) {
            return $this->error('params_error', trans('common.params_error'));
        }
        $postUrl = route('role.update');
        $result  = $this->lmRoleService->getRoleById($id);
        $data    = compact('result', 'postUrl');
        return view('admin.role.create', $data);
    }

    /**
     * 修改单个角色信息
     * @param Request $request
     * @return mixed
     * @user yun.li
     * @time 2019/5/6 下午6:35
     */
    public function update(Request $request)
    {
        $id     = $request->input('id', 0);
        $name   = $request->input('name', '');
        $status = $request->input('status', 1);
        if (empty($id) || empty($name)) {
            return $this->error('params_error', trans('common.params_error'));
        }
        try {
            $this->lmRoleService->updateRoleById($id, ['name' => $name, 'status' => $status]);
            return $this->success();
        } catch (\Exception $e) {
            $errData = [
                'errMsg'      => $e->getMessage(),
                'errTrace'    => $e->getTraceAsString(),
                'requestData' => $request->all(),
            ];
            QALog::error(__METHOD__, $errData, self::LOG_FILE);
            return $this->error('service_error', trans('common.service_error'));
        }
    }

    /**
     * 修改单项字段
     * @param Request $request
     * @return mixed
     * @user yun.li
     * @time 2019/5/20 下午3:18
     */
    public function updateField(Request $request)
    {
        $requestData = $request->all();
        if (empty($requestData['id']) || empty($requestData['field'])) {
            return $this->error('params_error', trans('common.params_error'));
        }
        try {
            $updateData = [
                $requestData['field'] => $requestData['value']
            ];
            $this->lmRoleService->updateRoleById($requestData['id'], $updateData);
            return $this->success();
        } catch (\Exception $e) {
            $errLog = [
                'errMsg'      => $e->getMessage(),
                'requestData' => $requestData
            ];
            QALog::error(__METHOD__, $errLog, self::LOG_FILE);
            return $this->error();
        }
    }

    /**
     * 删除角色
     * @param Request $request
     * @return mixed
     * @user yun.li
     * @time 2019/5/6 下午6:49
     */
    public function destroy(Request $request)
    {
        $id = $request->input('id', 0);
        if (empty($id)) {
            return $this->error('params_error', trans('common.params_error'));
        }
        try {
            $id = is_array($id) ? $id : [$id];
            $this->lmRoleService->deleteRoleById($id);
            return $this->success();
        } catch (\Exception $e) {
            $errData = [
                'errMsg'      => $e->getMessage(),
                'errTrace'    => $e->getTraceAsString(),
                'requestData' => $request->all(),
            ];
            QALog::error(__METHOD__, $errData, self::LOG_FILE);
            return $this->error('service_error', trans('common.service_error'));
        }
    }

    /**
     * 修改角色拥有的权限
     * @param Request $request
     * @return mixed
     * @user yun.li
     * @time 2019/5/7 下午5:55
     */
    public function updatePermission(Request $request)
    {
        $roleId       = $request->input('role_id', 0);
        $permissionId = $request->input('permission_id', []);
        if (empty($roleId)) {
            return $this->error('params_error', trans('common.params_error'));
        }
        try {
            $this->lmRoleService->updateRolePermission($roleId, $permissionId);
            return $this->success();
        } catch (\Exception $e) {
            $errData = [
                'errMsg'      => $e->getMessage(),
                'errTrace'    => $e->getTraceAsString(),
                'requestData' => $request->all(),
            ];
            QALog::error(__METHOD__, $errData, self::LOG_FILE);
            return $this->error();
        }
    }

    /**
     * 查看角色拥有的权限
     * @param Request $request
     * @param PermissionService $LMPermissionService
     * @return mixed
     * @user yun.li
     * @time 2019/5/7 下午6:07
     */
    public function permission(Request $request, PermissionService $LMPermissionService)
    {
        $roleId = $request->input('role_id', 0);
        if (empty($roleId)) {
            return $this->error('params_error', trans('common.params_error'));
        }
        $roleNode = $this->lmRoleService->getRolePermission($roleId);
        $roleNode = array_column($roleNode,'permission_id');
        $nodeTree = $LMPermissionService->getPermissionTree();
        $data     = compact('roleNode', 'nodeTree','roleId');
        return view('admin.role.role_node', $data);
    }


}