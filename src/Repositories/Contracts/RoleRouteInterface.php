<?php


namespace Admin\Repositories\Contracts;


interface RoleRouteInterface
{
    /**
     * 角色和权限选择关系
     * @param $roleId
     * @return mixed
     */
    public function routes($roleId);
}