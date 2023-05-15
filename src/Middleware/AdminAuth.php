<?php


namespace Admin\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class AdminAuth
{
    public function handle($request, Closure $next)
    {

        $adminInfo = Session::get('admin');

        if (!$adminInfo) {

            $this->verifyAjax($request);
            return redirect()->route('login');
        }

        //检测用户是否有权限操作
        $uri = $request->route()->uri();
        $uri = $uri == '/' ? $uri : '/'.$uri;             //uri添加'/'
        if (!in_array($uri,$adminInfo['routes'])) {

            $uri = str_replace('ajax','',$uri); //去掉ajax请求
            if (!in_array(strtolower($uri),$adminInfo['routes'])) {

                $this->verifyAjax($request);
                abort(403, '抱歉，你没有权限访问！');
            }
        }

        $request->merge(['admin'=>$adminInfo]);

        return $next($request);
    }

    /**
     * 判断是否是ajax提交
     * @param $request
     * @throws \MakeRep\Exceptions\ApiException
     */
    private function verifyAjax($request){

        //判断是否是ajax请求
        if (strpos('  '.$request->header('accept'),'application/json')) {

           return tne('NO_AUTH',['code_file'=>'admin_code']);
        }
    }
}