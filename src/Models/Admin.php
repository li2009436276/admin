<?php


namespace Admin\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Admin extends Model
{
    use SoftDeletes;
    protected $table = 'admins';
    protected $fillable = [
        'id','role_id','account','pwd','salt','nickname','phone','email','head_img','status'
    ];

    /**
     * 用户头像
     * @param $value
     * @return array
     */
    public function getHeadImgAttribute($value){

        if (!empty($value)) {

            return ['url'=>Storage::url($value),'path'=>$value];
        }

        return $value;
    }

    /**
     * 管理员所属角色
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role(){

        return $this->belongsTo(Role::class,'role_id','id')->select(['id','name']);
    }
}