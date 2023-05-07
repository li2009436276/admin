<?php


namespace Admin\Controllers;


use Admin\Requests\Login\ForgetRequest;
use Admin\Requests\Login\LoginRequest;
use Admin\Resources\BaseResource;
use Admin\Resources\ErrorResource;
use Admin\Repositories\Contracts\AdminInterface;
use Admin\Repositories\Contracts\RoleRouteInterface;
use Curl\PwdService\PwdService;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Facades\Session;

class LoginController
{

    private $adminInterface;
    private $roleRouteInterface;

    public function __construct(AdminInterface $adminInterface,RoleRouteInterface $roleRouteInterface){

        $this->adminInterface       = $adminInterface;
        $this->roleRouteInterface   = $roleRouteInterface;
    }

    /**
     * 输出图形验证码
     */
    public function captcha(){
        $builder = new CaptchaBuilder;

        $builder->setBackgroundColor(220, 210, 230);
        $builder->setMaxAngle(0);
        $builder->setMaxBehindLines(0);
        $builder->setMaxFrontLines(0);

        //可以设置图片宽高及字体
        $builder->build($width = 100, $height = 40, $font = null);
        //获取验证码的内容
        $phrase = $builder->getPhrase();

        //把内容存入session
        Session::put('verCode', $phrase);

        //生成图片
        header("Cache-Control: no-cache, must-revalidate");
        header('Content-Type: image/jpeg');
        $builder->output();
    }

    /**
     * 登录页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function login(){
        return view('login.login');
    }

    /**
     * 管理员登录
     * @param LoginRequest $request
     * @return BaseResource
     */
    public function ajaxLogin(LoginRequest $request){

        $res = $this->adminInterface->index(['account'=>$request->account]);
        if (!$res) {

            return new ErrorResource('ACCOUNT_NOT_EXIST');
        }

        //判断密码
        if (!PwdService::verifyPwd($request->pwd,$res)) {

            return new ErrorResource('PWD_ERROR');
        }

        //刷新验证码
        Session::put('verCode',null);
        Session::put('admin',$res->toArray());

        //存储权限
        $this->roleRouteInterface->routes(Session::get('admin')['role_id']);

        return new BaseResource('LOGIN_SUCCESS');
    }

    /**
     * 忘记密码
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function forget(){

        return view('login.forget');
    }

    /**
     * 忘记密码
     * @param ForgetRequest $request
     * @return BaseResource
     */
    public function ajaxForget(ForgetRequest $request){

        $res = $this->adminInterface->forget($request->only('account','pwd'));
        if (!$res) {

            return new ErrorResource('');
        }

        $admin = $this->adminInterface->index(['account'=>$request->account]);
        Session::put('admin',$admin->toArray());
        $this->roleRouteInterface->routes(Session::get('admin')['role_id']);

        return new BaseResource('UPDATE_SUCCESS');
    }

    /**
     * 退出
     */
    public function ajaxLogout(){

        Session::put('admin',null);

        return new BaseResource([]);
    }
}