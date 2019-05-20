<?php
/**
 * Created by PhpStorm.
 * User: yunli
 * Date: 2019/5/6
 * Time: 下午5:40
 */

namespace App\Models;


class CrmAdminUserRoleModel extends BaseModel
{
    protected $table = 'crm_admin_user_role';

    protected $fillable = [
        'user_id',
        'role_id',
    ];

    public function role(){
        return $this->hasOne(CrmAdminRoleModel::class,'id','role_id');
    }

    public function rolePermissions(){
        return $this->hasMany(CrmAdminRolePermissionModel::class,'role_id','role_id');
    }

}