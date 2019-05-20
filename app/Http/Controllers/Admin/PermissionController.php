<?php
/**
 * Created by PhpStorm.
 * User: yunli
 * Date: 2019/5/7
 * Time: 上午10:25
 */

namespace App\Http\Controllers\Admin;


use App\Http\Requests\Permission\CreatePermissionRequest;
use App\Http\Requests\Permission\SearchPermissionRequest;
use App\Logs\QALog;
use App\Models\CrmAdminPermissionModel;
use App\Services\PermissionService;
use Illuminate\Http\Request;

class PermissionController extends BaseController
{

    /**
     * 日志文件
     */
    const LOG_FILE = 'crm';

    /**
     * @var PermissionService
     */
    private $lmPermissionService;

    public function __construct(PermissionService $lmPermissionService)
    {
        $this->lmPermissionService = $lmPermissionService;
    }

    /**
     * 权限列表查询
     * @param SearchPermissionRequest $request
     * @return array
     * @user yun.li
     * @time 2019/5/7 上午11:58
     */
    public function index(SearchPermissionRequest $request)
    {
        $requestData = $request->all();
        $pid         = $requestData['parent_id'] ?? 0;
        if ($pid) {
            $pidInfo  = $this->lmPermissionService->getPermissionByCond(['id' => $pid]);
            $pidLevel = $pidInfo->level ?? 1;
            $level    = $pidLevel + 1;
        } else {
            $level = 1;
        }
        $requestData['is_admin'] = 1;
        $result                  = $this->lmPermissionService->getPermissionList($requestData);
        $title                   = '权限列表';
        $data                    = compact('result', 'title', 'level', 'pid', 'requestData');
        return view('admin.node.index', $data);
    }

    /**
     * 添加权限-view
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @user yun.li
     * @time 2019/5/20 下午3:03
     */
    public function create(Request $request)
    {
        $requestData = $request->all();
        $title       = '添加权限';
        $result      = [];
        $postUrl     = route('permission.store');
        $pid         = $requestData['pid'] ?? 0;
        if ($pid) {
            $pidInfo  = $this->lmPermissionService->getPermissionByCond(['id' => $pid]);
            $pidLevel = $pidInfo->level ?? 1;
            $level    = $pidLevel + 1;
        } else {
            $level = 1;
        }
        $data        = compact('title', 'requestData', 'result', 'postUrl', 'pid','level');
        return view('admin.node.create', $data);
    }

    /**
     * 添加权限
     * @param CreatePermissionRequest $request
     * @return mixed
     * @user yun.li
     * @time 2019/5/7 上午11:58
     */
    public function store(CreatePermissionRequest $request)
    {
        $requestData = $request->all();
        try {
            $createData = [
                'parent_id' => $requestData['parent_id'] ?? 0,
                'title'     => $requestData['title'] ?? '',
                'icon'      => $requestData['icon'] ?? '',
                'path'      => $requestData['path'] ?? '',
                'is_menu'   => $requestData['is_menu'] ?? 0,
                'sort'      => $requestData['sort'] ?? 1,
                'status'    => $requestData['status'] ?? 1,
                'level'    => $requestData['level'] ?? 1,
            ];
            CrmAdminPermissionModel::create($createData);
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
     * 查看权限详情
     * @param Request $request
     * @return mixed
     * @user yun.li
     * @time 2019/5/7 上午11:59
     */
    public function edit(Request $request)
    {
        $id = $request->input('id', 0);
        if (empty($id)) {
            return $this->errorBackTo(['error' => trans('common.params_error')]);
        }
        $postUrl = route('permission.update');
        $result  = $this->lmPermissionService->getPermissionByCond(['id' => $id]);
        $result = $result->toArray();
        $pid     = $result['parent_id'] ?? 0;
        $data    = compact('result', 'pid','postUrl');
        return view('admin.node.create', $data);
    }

    /**
     * 修改权限
     * @param CreatePermissionRequest $request
     * @return mixed
     * @user yun.li
     * @time 2019/5/7 上午11:59
     */
    public function update(CreatePermissionRequest $request)
    {
        $requestData = $request->all();
        if (empty($requestData['id'])) {
            return $this->error('params_error', trans('common.params_error'));
        }
        try {
            $updateData = [
                'parent_id' => $requestData['parent_id'] ?? 0,
                'title'     => $requestData['title'] ?? '',
                'icon'      => $requestData['icon'] ?? '',
                'path'      => $requestData['path'] ?? '',
                'is_menu'   => $requestData['is_menu'] ?? 0,
                'sort'      => $requestData['sort'] ?? 1,
                'status'    => $requestData['status'] ?? 1
            ];
            $this->lmPermissionService->updatePermissionById($updateData, $requestData['id']);
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
            $this->lmPermissionService->updatePermissionById($updateData, $requestData['id']);
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
     * 删除
     * @param Request $request
     * @return mixed
     * @user yun.li
     * @time 2019/5/7 上午11:59
     */
    public function destroy(Request $request)
    {
        $id = $request->input('id', 0);
        if (empty($id)) {
            return $this->error('params_error', trans('common.params_error'));
        }
        try {
            CrmAdminPermissionModel::destroy($id);
            return $this->success();
        } catch (\Exception $e) {
            $errLog = [
                'errMsg'      => $e->getMessage(),
                'requestData' => $request->all()
            ];
            QALog::error(__METHOD__, $errLog, self::LOG_FILE);
            return $this->error();
        }
    }

    /**
     * 菜单列表
     * @return mixed
     * @user yun.li
     * @time 2019/5/7 下午6:24
     */
    public function menu()
    {
        $menu = $this->lmPermissionService->getMenu();
        return $this->success($menu);
    }

    /**
     * 全部节点树
     * @return array
     * @user yun.li
     * @time 2019/5/7 下午6:47
     */
    public function permissionTree()
    {
        $result = $this->lmPermissionService->getPermissionTree();
        return $result;
    }


}