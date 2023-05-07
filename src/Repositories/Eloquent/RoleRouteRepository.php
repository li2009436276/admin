<?php


namespace Admin\Repositories\Eloquent;


use Admin\Models\RoleRoute;
use Admin\Repositories\Contracts\RoleRouteInterface;
use Curl\StrService\StrService;
use Illuminate\Support\Facades\Session;
use MakeRep\Repository;

class RoleRouteRepository extends Repository implements RoleRouteInterface
{

    function model()
    {
        return RoleRoute::class;
    }

    /**
     * 权限查询
     * @param $roleId
     * @return mixed
     */
    public function routes($roleId)
    {
        $res = $this->model
            ->where('role_id',$roleId)
            ->select(['routes.id','routes.pid','routes.path','routes.name','routes.icon','routes.sort','routes.status'])
            ->join('routes',function($join){
                $join->on('routes.id','=','role_route.route_id');
            })
            ->groupBy('routes.id')
            ->orderBy('routes.sort','desc')
            ->orderBy('routes.id','asc')
            ->get();

        if ($res->isNotEmpty()) {

            //存入权限
            $admin = Session::get('admin');
            $admin['routes'] = $res->pluck('path')->toArray();

            //菜单无限极分类
            $menus = StrService::limitLess($res = $res->toArray());

            //存入菜单
            $admin['menus'] = $menus;
            Session::put('admin',$admin);
        }

        return $res;
    }
}