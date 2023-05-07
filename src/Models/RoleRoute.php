<?php


namespace Admin\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleRoute extends Model
{
    use SoftDeletes;
    protected $table = 'role_route';
    protected $fillable = [
        'id','role_id','route_id'
    ];
}