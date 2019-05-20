<?php
/**
 * Created by PhpStorm.
 * User: yunli
 * Date: 2019/4/30
 * Time: 上午10:48
 */

namespace App\Services;


use App\Models\CrmAdminUserModel;
use App\Models\CrmAdminUserRoleModel;

class UserService
{
    /**
     * 管理员列表
     * @param array $data
     * @return mixed
     * @user yun.li
     * @time 2019/4/30 下午1:06
     */
    public function getUserList(array $data)
    {
        $page          = $data['page'] ?? 1;
        $pageCount     = $data['pageCount'] ?? config('crm.pageCount');
        $userTable     = config('db_table.crm_admin_user');
        $roleTable     = config('db_table.crm_admin_role');
        $userRoleTable = config('db_table.crm_admin_user_role');
        $result        = CrmAdminUserModel::query()->leftJoin($userRoleTable, $userRoleTable . '.user_id', '=', $userTable . '.id')->leftJoin($roleTable, $roleTable . '.id', '=', $userRoleTable . '.role_id');
        if (!empty($data['username'])) {
            $result->where($userTable . '.username', 'like', $data['username'] . '%');
        }
        if (!empty($data['email'])) {
            $result->where($userTable . '.email', '=', $data['email']);
        }
        if (isset($data['status']) && $data['status'] !== null) {
            $result->where($userTable . '.status', '=', $data['status']);
        }
        $totalCount = $result->count(\DB::raw('distinct ' . $userTable . '.id'));
        $rows       = $result->select(\DB::raw("$userTable.*,{$roleTable}.id as role_id,{$roleTable}.name as role_name"));
        if ($data['is_admin']) {
            $rows = $rows->orderBy($userTable . '.created_at', 'desc')->paginate($pageCount);
            return $rows;
        }
        $rows   = $rows->offset(($page - 1) * $pageCount)
            ->limit($pageCount)
            ->orderBy($userTable . '.created_at', 'desc')
            ->get();
        $return = formatPage($rows, $totalCount, $page, $pageCount);
        return $return;
    }

    /**
     * 新增管理员
     * @param array $data
     * @return $this|\Illuminate\Database\Eloquent\Model
     * @user yun.li
     * @time 2019/4/30 下午2:25
     */
    public function addUser(array $data)
    {
        $addData = [
            'username' => $data['username'] ?? '',
            'email'    => $data['email'] ?? '',
            'phone'    => $data['phone'] ?? '',
            'password' => !empty($data['pass']) ? bcrypt($data['pass']) : '',
            'status'   => 1
        ];
        return CrmAdminUserModel::query()->create($addData);
    }

    /**
     * getUserById
     * @param int $userId
     * @return array
     * @user yun.li
     * @time 2019/4/30 下午3:22
     */
    public function getUserById(int $userId): array
    {
        $result = CrmAdminUserModel::query()->with('userRole', 'userRole.role')
            ->where('id', '=', $userId)
            ->first();
        if (empty($result)) {
            return [];
        }
        $detail = [
            'id'        => $result->id,
            'username'  => $result->username,
            'email'     => $result->email,
            'phone'     => $result->phone,
            'status'    => $result->status,
            'role_id'   => $result->userRole->role_id ?? 0,
            'role_name' => $result->userRole->role->name ?? '',
        ];
        return $detail;
    }

    /**
     * updateUserById
     * @param array $data
     * @param int $userId
     * @return int
     * @user yun.li
     * @time 2019/4/30 下午3:51
     */
    public function updateUserById(array $data, int $userId)
    {
        return CrmAdminUserModel::query()
            ->where('id', '=', $userId)
            ->update($data);
    }

    /**
     * deleteUserById
     * @param $id
     * @return int
     * @user yun.li
     * @time 2019/4/30 下午4:32
     */
    public function deleteUserById($id)
    {
        return CrmAdminUserModel::destroy($id);
    }

    /**
     * 通用根据条件查询返回单个用户信息
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null|object|static
     * @user yun.li
     * @time 2019/5/5 下午5:36
     */
    public function getUserByCond(array $data = [])
    {
        $result = CrmAdminUserModel::query();
        if ($data['email']) {
            $result->where('email', '=', $data['email']);
        }
        $result = $result->first();
        return $result;
    }

    /**
     * 修改用户的角色
     * @param int $userId
     * @param array $roleId
     * @return bool
     * @user yun.li
     * @time 2019/5/7 下午3:38
     * @throws
     */
    public function updateUserRole(int $userId, array $roleId = [])
    {
        try {
            \DB::beginTransaction();
            CrmAdminUserRoleModel::where('user_id', '=', $userId)->delete();
            if (!empty($roleId)) {
                $addData = [];
                foreach ($roleId as $value) {
                    $addData[] = [
                        'role_id' => $value,
                        'user_id' => $userId
                    ];
                }
                CrmAdminUserRoleModel::insert($addData);
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        return true;
    }

    /**
     * 获取当前登录用户信息
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     * @user yun.li
     * @time 2019/5/8 上午10:33
     */
    public static function getUserInfo()
    {
        return \Auth::user();
    }


}