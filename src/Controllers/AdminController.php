<?php

namespace Admin\Controllers;


use Admin\Requests\Admin\AdminAddRequest;
use Admin\Requests\Admin\AdminUpdateRequest;
use Admin\Resources\Admin\AdminCollection;
use Admin\Resources\BaseResource;
use Admin\Resources\ErrorResource;
use Admin\Repositories\Contracts\AdminInterface;
use Admin\Repositories\Contracts\RoleInterface;
use Curl\PwdService\PwdService;
use Illuminate\Http\Request;

class AdminController
{

    private $adminInterface;
    private $roleInterface;

    public function __construct(AdminInterface $adminInterface,RoleInterface $roleInterface){

        $this->adminInterface = $adminInterface;
        $this->roleInterface  = $roleInterface;
    }

    /**
     * 添加管理员
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function add(){

        $roles = $this->roleInterface->get();

        return view('admin.add', ['roles' => $roles]);

    }

    /**
     * 新增管理员
     * @param AdminAddRequest $request
     * @return BaseResource|ErrorResource
     */
    public function ajaxAdd(AdminAddRequest $request){

        $data = $request->only(['account','phone','nickname','head_img','email','role_id','status']);
        $pwd  = PwdService::makePwd($request->pwd);
        $data = array_merge($data,$pwd);
        $res = $this->adminInterface->add($data);
        if ($res) {

            return new BaseResource([]);
        }

        return new ErrorResource([]);
    }

    /**
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function lists(){

        return view('admin.lists');
    }

    /**
     * 管理员列表
     * @param Request $request
     * @return mixed
     */
    public function ajaxLists(Request $request){

        $pageSize = $request->pageSize ? :10;
        $res = $this->adminInterface->pageLists([],'*',$pageSize);

        return new AdminCollection($res);
    }

    /**
     * 管理员修改
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function update(Request $request){

        $res = $this->adminInterface->findById($request->id);
        if (!$res) {

            abort(404);
        }


        $roles = $this->roleInterface->get();

        return view('admin.update', array_merge($res->toArray(), ['roles' => $roles->toArray()]));
    }

    /**
     * 管理员修改
     * @param AdminUpdateRequest $request
     * @return BaseResource|ErrorResource
     */
    public function ajaxUpdate(AdminUpdateRequest $request){
        $data = $request->only(['account','pwd','phone','nickname','head_img','email','role_id','status']);
        $res = $this->adminInterface->update(['id'=>$request->id],$data);
        if ($res) {

            return new BaseResource([]);
        }

        return new ErrorResource([]);
    }

    /**
     * 管理员删除
     * @param Request $request
     * @return BaseResource|ErrorResource
     */
    public function ajaxDelete(Request $request){

        $res = $this->adminInterface->delete(['id'=>$request->id]);

        if ($res) {

            return new BaseResource([]);
        }

        return new ErrorResource([]);
    }
}