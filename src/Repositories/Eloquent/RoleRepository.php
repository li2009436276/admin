<?php


namespace Admin\Repositories\Eloquent;


use Admin\Models\Role;
use Admin\Repositories\Contracts\RoleInterface;
use Curl\StrService\StrService;
use MakeRep\Repository;
use DB;

class RoleRepository extends Repository implements RoleInterface
{

    function model()
    {
        return Role::class;
    }

    /**
     * 添加角色
     * @param $data
     * @param $routes
     * @return mixed
     */
    public function create($data,$routes)
    {
        DB::beginTransaction();
        $res = $this->add($data);
        if (!$res) {

            DB::rollback();
            tne('ROLE_ADD_ERROR');
        }

        $roleRouteRes = $this->roleRouteAdd($res->id,$routes);
        if (!$roleRouteRes) {

            DB::rollback();
            tne('ROLE_ROUTE_ADD_ERROR');
        }

        DB::commit();

        return $res;
    }

    /**
     * 更新角色
     * @param $data
     * @param $routes
     * @return false|mixed
     * @throws \MakeRep\Exceptions\ApiException
     */
    public function updateRole($data, $routes)
    {
        DB::beginTransaction();
        $res = $this->update(['id'=>$data['id']],['name'=>$data['name']]);
        if ($res === false) {

            DB::rollback();
            tne('UPDATE_FAIL');
        }

        $roleRouteRes = $this->roleRouteAdd($data['id'],$routes);
        if (!$roleRouteRes) {

            DB::rollback();
            tne('ROLE_ROUTE_ADD_ERROR');
        }

        DB::commit();

        return true;
    }

    /**
     *  获取角色权限
     * @param $roleId
     */
    public function roleRoute($roleId = 0)
    {
        //角色分配的权限
        if ($roleId) {

            $roleRouteInterface = resolve('Admin\Repositories\Contracts\RoleRouteInterface');
            $roleRoutes = $roleRouteInterface->get(['role_id' => $roleId], ['route_id']);
            $roleRoutes = $roleRoutes->pluck('route_id')->toArray();
        }

        //所有权限
        $routeInterface = resolve('Admin\Repositories\Contracts\RouteInterface');
        $routes = $routeInterface->get([],['id','pid','name as title','icon','name','path','sort','status'])->toArray();

        foreach ($routes as $key=>&$value) {

            //字段名称
            $value['field'] = 'routes[]';

            if ($roleId) {

                if (in_array($value['id'],$roleRoutes) && !empty($value['path'])) {

                    $value['checked'] = true;

                }
            }

            if ($value['status'] == 2) {

                $value['title'] = $value['title'].'(隐藏)';
            }
        }

        //进行无限极排序
        $routes = StrService::limitLess($routes);

        return [['id'=>0,'pid' =>0,'path'=>'','spread'=>true ,'title'=>'权限列表','name'=>'权限列表','sort'=>1,'status'=>1, 'children' => $routes]];
    }

    /**
     * 设置角色权限
     * @param $roleId
     * @param $routes
     * @return mixed
     */
    private function roleRouteAdd($roleId,$routes){

        //删除原角色ID
        $roleRouteInterface = resolve('Admin\Repositories\Contracts\RoleRouteInterface');
        $roleRouteInterface->delete(['role_id'=>$roleId]);

        $routeData = [];
        $time = date('Y-m-d H:i:s');
        foreach ($routes as $value) {

            $routeData[] = [
                'role_id'=> $roleId,
                'route_id'=>$value,
                'created_at' => $time,
                'updated_at' => $time
            ] ;
        };

        $res = $roleRouteInterface->insert($routeData);

        return $res;
    }

}