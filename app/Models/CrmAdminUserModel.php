<?php
/**
 * Created by PhpStorm.
 * User: yunli
 * Date: 2019/4/29
 * Time: 下午2:01
 */

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CrmAdminUserModel extends Authenticatable
{
    use Notifiable;

    use SoftDeletes;

    protected $rememberTokenName = '';

    protected $table = 'crm_admin_user';

    protected $fillable = [
        'username',
        'email',
        'phone',
        'password',
        'status',
    ];

    protected $hidden = [
        'password'
    ];

    /**
     * 需要被转换成日期的属性。
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function userRole(){
        return $this->belongsTo(CrmAdminUserRoleModel::class,'id','user_id');
    }




}