<?php
/**
 * Created by PhpStorm.
 * User: yunli
 * Date: 2019/5/6
 * Time: 下午5:40
 */

namespace App\Models;


class CrmAdminPermissionModel extends BaseModel
{
    protected $table = 'crm_admin_permission';

    protected $fillable = [
        'parent_id',
        'title',
        'icon',
        'path',
        'is_menu',
        'sort',
        'status',
        'level'
    ];

}