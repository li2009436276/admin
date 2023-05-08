<?php


namespace Admin\Repositories\Contracts;


interface AdminInterface
{

    /**
     * 管理员列表
     * @param $where
     * @param int $pageSize
     * @param string $field
     * @return mixed
     */
    public function lists($where,$pageSize = 10,$field = '*');

    /**
     * 忘记密码
     * @param $data
     * @return mixed
     */
    public function forget($data);
}