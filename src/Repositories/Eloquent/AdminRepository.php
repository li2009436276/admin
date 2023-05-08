<?php


namespace Admin\Repositories\Eloquent;


use Admin\Models\Admin;
use Admin\Repositories\Contracts\AdminInterface;
use Curl\PwdService\PwdService;
use MakeRep\Repository;
use DB;
class AdminRepository extends Repository implements AdminInterface
{

    function model()
    {
        return Admin::class;
    }


    /**
     * 管理员列表
     * @param $where
     * @param int $pageSize
     * @param string $field
     * @return mixed
     */
    public function lists($where,$pageSize = 10,$field = '*')
    {
        $res = $this->model
            ->with('role')
            ->where($where)
            ->select($field)
            ->paginate($pageSize);

        return $res;
    }

    /**
     * 忘记密码
     * @param $data
     * @return mixed|void
     */
    public function forget($data)
    {

        $pwd = PwdService::makePwd($data['pwd']);
        return $this->update(['account'=>$data['account']],$pwd);
    }

}