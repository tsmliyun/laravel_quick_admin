<?php

namespace App\Http\Middleware;

use App\Models\CrmAdminPermissionModel;
use App\Services\UserService;
use Closure;

class CheckAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 临时用 todo
//        if (config('app.env') != 'production') {
//            return $next($request);
//        }

        // 当前登录用户信息
        $userInfo = UserService::getUserInfo();
        // 当前用户所属角色拥有的权限
        $userPermissions = [];
        if (!empty($userInfo->userRole)) {
            // 超级管理员拥有至高无上的权限
            if ($userInfo->userRole->role_id == 1) {
                return $next($request);
            }
            foreach ($userInfo->userRole->rolePermissions as $item) {
                $userPermissions[] = $item->permission_id;
            }
        }

        if (!empty($userPermissions)) {
            // 查看访问的路由的信息
            $uri     = $request->route()->uri();
            $uriInfo = CrmAdminPermissionModel::where('path', '=', $uri)->first();
            // 判断用户是否拥有此权限
            if (!empty($uriInfo) && in_array($uriInfo->id, $userPermissions)) {
                return $next($request);
            }
        }
        return response()->json([
            'status'  => 'error',
            'message' => 'access forbidden',
            'error'   => [
                'code'    => config('response_code.request_forbidden'),
                'message' => trans('common.request_forbidden'),
            ],
        ]);
    }
}
