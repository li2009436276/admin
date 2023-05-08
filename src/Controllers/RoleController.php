<?php


namespace Admin\Controllers;


use Admin\Requests\Role\AddRequest;
use Admin\Requests\Role\UpdateRequest;
use Admin\Resources\BaseResource;
use Admin\Resources\ErrorResource;
use Admin\Repositories\Contracts\RoleInterface;
use Illuminate\Http\Request;

class RoleController
{

    private $roleInterface;

    public function __construct(RoleInterface $roleInterface){

        $this->roleInterface = $roleInterface;
    }

    /**
     * 添加权限
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function add(){
        $routes = $this->roleInterface->roleRoute();

        return view('role.add',['routes' => $routes]);
    }

    /**
     * 添加角色
     * @param AddRequest $request
     * @return mixed
     */
    public function ajaxAdd(AddRequest $request){

        $res = $this->roleInterface->create($request->only(['name']),$request->routes);
        if ($res) {

            return new BaseResource([]);
        }

        return new ErrorResource([]);
    }

    /**
     * 角色列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function lists(){


        return view('role.lists');
    }

    /**
     * 角色列表
     * @return BaseResource
     */
    public function ajaxLists(){

        $res = $this->roleInterface->get();
        return new BaseResource($res);
    }

    /**
     * 修改角色
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function update(Request $request){

        $routes = [];
        $role = $this->roleInterface->findById($request->id);
        if ($role) {

            $routes = $this->roleInterface->roleRoute($role->id);
        }

        $data = [
            'role'  => $role,
            'routes' => $routes ,
        ];
        return view('role.update',$data);
    }

    /**
     * 权限更新
     * @param UpdateRequest $request
     * @return BaseResource|ErrorResource
     */
    public function ajaxUpdate(UpdateRequest $request){

        $res = $this->roleInterface->updateRole($request->only(['id','name']),$request->routes);

        if ($res) {

            return new BaseResource([]);
        }

        return new ErrorResource([]);
    }
}