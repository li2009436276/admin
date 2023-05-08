<?php

namespace Admin\Controllers;


use Admin\Requests\Route\AddRequest;
use Admin\Requests\Route\UpdateRequest;
use Admin\Resources\BaseResource;
use Admin\Resources\ErrorResource;
use Admin\Repositories\Contracts\RouteInterface;
use Illuminate\Http\Request;

class RouteController
{
    private $routeInterface;

    public function __construct(RouteInterface $routeInterface){

        $this->routeInterface = $routeInterface;
    }

    /**
     * 添加权限
     * @param AddRequest $request
     * @return BaseResource|ErrorResource
     */
    public function ajaxAdd(AddRequest $request){

        $data = $request->only(['pid','name','path','icon','sort','status']);
        $res = $this->routeInterface->add($data);
        if ($res) {

            return new BaseResource([]);
        }

        return new ErrorResource([]);
    }
    /**
     * 更新权限
     * @param UpdateRequest $request
     * @return BaseResource|ErrorResource
     */
    public function ajaxUpdate(UpdateRequest $request){

        $data = $request->only(['pid','name','path','icon','sort','status']);
        $res = $this->routeInterface->update(['id'=>$request->id],$data);

        if ($res) {

            return new BaseResource('UPDATE_SUCCESS');
        }

        return new ErrorResource('UPDATE_FAIL');
    }

    /**
     * 权限删除
     * @param Request $request
     * @return BaseResource|ErrorResource
     */
    public function ajaxDelete(Request $request){

        $res = $this->routeInterface->delete(['id'=>$request->id]);
        if ($res) {

            return new BaseResource([]);
        }

        return new ErrorResource([]);
    }
}