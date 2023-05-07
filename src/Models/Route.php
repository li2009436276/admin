<?php


namespace Admin\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Route extends Model
{
    use SoftDeletes;
    protected $table = 'routes';
    protected $fillable = ['id','pid','name','path','icon','sort','status'];
}