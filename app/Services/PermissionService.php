<?php
/**
 * Created by PhpStorm.
 * User: yunli
 * Date: 2019/4/30
 * Time: 上午10:48
 */

namespace App\Services;


use App\Models\CrmAdminPermissionModel;

class PermissionService
{
    /**
     * 权限列表
     * @param array $data
     * @return mixed
     * @user yun.li
     * @time 2019/5/7 上午11:54
     */
    public function getPermissionList(array $data)
    {
        $page = $data['page'] ?? 1;
        $pageCount = $data['pageCount'] ?? config('crm.pageCount');
        $result = CrmAdminPermissionModel::query();
        if (!empty($data['title'])) {
            $result->where('title', 'like', $data['title'] . '%');
        }
        if (isset($data['status'])) {
            $result->where('status', '=', $data['status']);
        }
        $data['parent_id'] = $data['parent_id'] ?? 0;
        $result->where('parent_id', '=', $data['parent_id']);

        if(!empty($data['is_admin'])){
            $result = $result->paginate($pageCount);
            return $result;
        }
        $totalCount = $result->count();
        $rows = $result->offset(($page - 1) * $pageCount)
            ->limit($pageCount)
            ->get();
        $return = formatPage($rows, $totalCount, $page, $pageCount);
        return $return;
    }

    /**
     * 修改权限信息
     * @param array $data
     * @param int $id
     * @return int
     * @user yun.li
     * @time 2019/5/7 上午11:54
     */
    public function updatePermissionById(array $data, int $id)
    {
        return CrmAdminPermissionModel::where('id', '=', $id)->update($data);
    }

    /**
     * 查询权限信息
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null|object|static
     * @user yun.li
     * @time 2019/5/7 上午11:55
     */
    public function getPermissionByCond(array $data = [])
    {
        $result = CrmAdminPermissionModel::query();
        if ($data['id']) {
            $result->where('id', '=', $data['id']);
        }
        $result = $result->first();
        return $result;
    }

    /**
     * 获取菜单信息
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     * @user yun.li
     * @time 2019/5/7 下午6:24
     */
    public static function getMenu()
    {
        // 当前登录用户信息
        $userInfo = UserService::getUserInfo();
        // 当前用户所属角色拥有的权限
        $userPermissions = [];
        if (!empty($userInfo->userRole)) {
            foreach ($userInfo->userRole as $value) {
                if (empty($value->rolePermissions)) {
                    continue;
                }
                foreach ($value->rolePermissions as $item) {
                    $userPermissions[] = $item->permission_id;
                }
            }
        }

        // 查询菜单信息
        $columns = [
            'id',
            'parent_id',
            'title',
            'icon',
            'path',
            'is_menu',
            'sort',
            'status'
        ];
        $result = CrmAdminPermissionModel::where('is_menu', '=', 1)
            ->where('status', '=', 1);
        if (!empty($userPermissions)) {
            $result->whereIn('id', $userPermissions);
        }
        $result = $result->orderBy('sort')
            ->get($columns)
            ->toArray();
        if (empty($result)) {
            return [];
        }
        $tree = self::getTree($result, 0);
        return $tree;
    }

    /**
     * 获取权限节点树
     * @return array
     * @user yun.li
     * @time 2019/5/7 下午6:43
     */
    public function getPermissionTree()
    {
        $columns = [
            'id',
            'parent_id',
            'title',
            'icon',
            'path',
            'is_menu',
            'sort',
            'status'
        ];
        $permissions = CrmAdminPermissionModel::where('status', '=', 1)->get($columns)->toArray();
        if (empty($permissions)) {
            return [];
        }
        $tree = $this->getTree($permissions, 0);
        return $tree;
    }

    /**
     * getTree
     * @param array $nodeArray
     * @param int $pid
     * @return array
     * @user yun.li
     * @time 2019/5/7 下午6:44
     */
    private static function getTree($nodeArray = array(), $pid = 0)
    {
        $return = array();
        foreach ($nodeArray as $key => $value) {
            if ($value['parent_id'] == $pid) {
                $value['child'] = self::getTree($nodeArray, $value['id']);
                $return[] = $value;
            }
        }
        return $return;
    }


}