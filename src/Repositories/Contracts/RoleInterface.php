<?php


namespace Admin\Repositories\Contracts;


interface RoleInterface
{

    /**
     * 添加角色
     * @param $data
     * @param $routes
     * @return mixed
     */
    public function create($data,$routes);

    /**
     * 更新角色
     * @param $data
     * @param $routes
     * @return mixed
     */
    public function updateRole($data,$routes);

    /**
     * 角色和权限关系
     * @param $roleId
     */
    public function roleRoute($roleId = 0);
}